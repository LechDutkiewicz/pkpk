<?php
namespace App;
use WP_Query;
use Imagick;

class Course {
    public $id;
    public $restricted_to;
    private $course;

    function __construct($id = '') {
        if(! empty($id) ) {
            $course = get_post($id);
            $this->setID($course);
        } else {
            global $wp_query;
            if( isset($wp_query->query_vars['course_id']) ) {
                $this->id = urldecode($wp_query->query_vars['course_id']);
            } else {
                global $post;
                $this->setID($post);
            }
        }

        $this->checkCommentsOpen();
    }

    protected function sendCertificates() {
        $option_name = 'pkpk_c_' . $this->id . 'certf_send';

        if ( get_option( $option_name ) !== false ) {
            return;
        } else {
            $users = $this->getCourseUsers();

            foreach ($users as $user) {
                $to = $user['email'];
                $subject = '[Produktywność Krok Po Kroku] Certyfikat ukończenia kursu.';

                $key = 'download_certificate_' . ( $user['id'] * $this->id );
                $nonce = wp_create_nonce( $key );
                $admin_url = admin_url( 'admin-ajax.php?action=download_certificate&course=' . $this->id . '&id=' . $user['id'] );

                $message = 'Cześć!<br><br> Kliknij <a href="' . $admin_url . '">tutaj</a> aby pobrać certyfikat w PDF.<br><br>Piotrek.';
                $headers = array('Content-Type: text/html; charset=UTF-8');

                wp_mail( $to, $subject, $message, $headers );
            }

            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
            $deprecated = null;
            $autoload = 'no';
            add_option( $option_name, 'true', $deprecated, $autoload );
        }

        return;
    }

    public function getCertificateUrl() {
        $user_id = get_current_user_id();
        $admin_url = admin_url( 'admin-ajax.php?action=download_certificate&course=' . $this->id . '&id=' . $user_id );

        return $admin_url;
    }

    public function isOver() {
        return get_field('course_is_close', $this->id);
    }

    protected function scheduledEvents() {
        $course_end = get_field('course_end', $this->id, false);
        $course_end_time = strtotime($course_end);

        add_action( 'make_certificates', $this->generateCertificates() );

        if( !wp_next_scheduled( 'make_certificates' ) ) {
          wp_schedule_single_event( $course_end_time, 'make_certificates' );
      }
  }

  protected function checkCommentsOpen() {
        // if course is open do nothing
    if ( !$this->isOver() ) {
        return;
    }

    $query = $this->newLessonsQuery();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            add_filter( 'comments_open' , function() { return false; } );
        }
    }
    wp_reset_postdata();
}


protected function setID($post) {
    if ( $post->post_type === 'course' ) {
        $this->id = $post->ID;
        $this->course = $post;
    } else if ( $post->post_type === 'lesson' ) {
        $this->id = $post->post_parent;
        $this->course = get_post($post->post_parent);
    } else {
        $this->id = $this->getActiveCourse();
    }

    $this->restricted_to = get_field('course_download', $this->id);
}

public function getCourseUsers() {
    $restricted_to = $this->restricted_to;
    $id = $this->id;
    $course_users = [];

        // get all payments to this course
    $payments = get_payments_user_meta( $this->restricted_to );

    foreach($payments as $payment) {
            // check if user exist
        $user = get_userdata( $payment['id'] );
        if ( $user !== false ) {
                //user id does exist
            if ( !empty($payment['first_name']) && !empty($payment['last_name'] ) ) {
              $course_users[] = $payment;
          } else {
                  // we have to ask user for first name or last name
          }
      }
  }

  return $course_users;
}

protected function generateCertificates() {
    $users = $this->getCourseUsers();

    $i = 0;

    foreach ($users as $user) {
        $args = array( $user );

        $course_end = get_field('course_end', $this->id, false);
        $course_end_time = strtotime($course_end);
        $time = time();

        add_action( 'make_certificate', $this->generateCertificate($user) );
        $next_time = $time + $i * 600;

        if ( false !== ( $next_time = wp_next_scheduled( 'make_certificate' ) ) ) {
          wp_schedule_single_event( $next_time, 'make_certificate' );
      }

      $i++;
  }
}

public function generateCertificate($user) {
    $upload_dir = $this->getCertificatesDir();
    $course_end = get_field('course_end', $this->id, false);
        //sleep(10);
    return makePDF($user, $course_end, $upload_dir);
}

protected function setCourseID($id) {
    $this->id = $id;
}

public function getCertificatesDir() {
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $upload_dir = $upload_dir . '/pkpk-courses/course-' . $this->id . '/certificates';

    if (! is_dir($upload_dir) ) {
        $this->createCertificatesDir($upload_dir);
    }

    return $upload_dir;
}

protected function createCertificatesDir($upload_dir) {
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $upload_dir = $upload_dir . '/pkpk-courses/course-' . $this->id . '/certificates';

    wp_mkdir_p($upload_dir);
}

public function hasAccess() {

    // Set course ID in different ways depnding on where you are
    $post_type = get_post_type();

    // Get course ID as current post ID for course post type pages
    if ($post_type === 'course') {     
        global $post;   
        $course_id = $post->ID;

    // get course ID from query for reports page template
    } else if ($post_type === 'page' && is_page_template( 'templates/template-reports.blade.php' )) {
        $course_id = get_query_var('course_id');
    }

    $restricted = false;
    $has_access = true;
    $user_id = get_current_user_id();
    $id = $this->id;
    $restricted_to = edd_cr_is_restricted( $course_id );

        // If current user is admin, everything is simple
    if ( current_user_can('administrator') ) {
        return $has_access;
    }

    if ( edd_cr_is_restricted($id) ) {
        $restricted = true;
    }

    if ( $restricted && is_user_logged_in() ) {
        $check_access = edd_cr_user_can_access( $user_id, $restricted_to, $id );
        if ( $check_access['status'] ) {
            $has_access = true;
        } else {
            $has_access = false;
        }
    } else {
        $has_access = false;
    }

    return $has_access;
}

public function isStarted() {
    $is_started = false;
    $start_date = get_field('course_start', $this->id, false);
    $current_time = current_time('timestamp');

    if (strtotime($start_date) - $current_time < 0 || current_user_can('administrator') ) {
        $is_started = true;
    }

    return $is_started;
}

public function getPath($id = '') {
    if ( empty($id) ) {
        $id = $this->id;
    }

    return get_permalink($id);
}

public function getID() {
    return $this->id;
}

protected function newLessonsQuery($parent = null, $number_posts = -1) {
  if ( empty($parent) ) {
      $parent = $this->id;
  }

  $query = new WP_Query([
    'post_type' => 'lesson',
    'post_parent' => $parent,
    'order' => 'ASC',
    'post_status' => 'publish',
    'numberposts' => $number_posts,
]);

  return $query;
}

public function getTotalLessonsCount() {
    $query = $this->newLessonsQuery();
    wp_reset_postdata();

    return $query->post_count;
}

public function getTotalLength() {
  $course_start = get_field('course_start', $this->id, false);
  $course_end = get_field('course_end', $this->id, false);
  $diff = strtotime($course_end) - strtotime($course_start);
  $date_diff = floor($diff/86400);

      //return $date_diff + 1;
      return 32; // TODO: Zrobic sensowne liczenie, w niektorych kursach jest przerwa w srodku
  }

  public function getUserProgress($user_id = null) {
    if (empty($user_id)) {
        $user_id = get_current_user_id();
    }

    $query = $this->newLessonsQuery();
    $i = 0;

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $lesson_id = get_the_ID();
            if ( prod_userreporting_is_report_sended($user_id, $lesson_id) ) {
                $i++;
            }
        }
    }
    wp_reset_postdata();

    return round($i / $this->getTotalLength() * 100, 0);
}

public function getUserCourses($user = '') {
    if ( empty($user) ) {
        $user = get_current_user_id();
    }
    $user_courses = [];
    $user_purchases = [];

    $purchases = edd_get_users_purchased_products( $user );
    if (is_array($purchases) && count($purchases)>0) {
        foreach ($purchases as $purchase) {
            array_push($user_purchases, $purchase->ID);
        }
    }

    $courses = new WP_Query([
      'post_type' => 'course',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'order' => 'ASC',
  ]);

    if ( $courses->have_posts() ) {
        while ( $courses->have_posts() ) {
            $courses->the_post();
            $course_id = $courses->post->ID;
            $download = get_field('course_download', $course_id);

            if ( in_array($download, $user_purchases) || current_user_can('administrator') ) {
                array_push($user_courses, $course_id);
            }
        }
    }

    wp_reset_postdata();

    return $user_courses;
}

public function getActiveCourse() {
    $user_courses = $this->getUserCourses();

    if ( empty($user_courses) ) {
        return;
    }
        // If user has only 1 course, just return it.
    if ( count($user_courses) < 2 ) {
        return $user_courses[0];
    }

    foreach ( $user_courses as $course => $id ) {
        $start = get_field('course_start', $id, false);
        $now = time();

        if ( $now - strtotime($start) > 0 ) {
            return $id;
        }
    }

        // if all courses all future, return the closest
    return $this->getClosestFutureCourse();
}

public function getClosestFutureCourse() {
    $courses = $this->getUserCourses();
    $new_courses = array();

    foreach ($courses as $course => $id) {
        $start = get_field('course_start', $id, false);
        $diff = strtotime($start) - strtotime($from);
        if ( $diff > 0 ) {
            $new_courses[] = $id;
        }
    }

    return $new_courses[0];
}
}

class Lesson extends Course {
    private $lesson;
    protected $lesson_id;
    protected $course_id;

    function __construct($lesson = '') {
        if ( empty($lesson) ) {
            global $post;

            if ( $post->post_type == 'lesson' ) {
                $this->lesson = $post;
                $this->lesson_id = $post->ID;
                $this->course_id = $post->post_parent;
                parent::setCourseID($post->post_parent);
            }
        } else {
            if ( $lesson->post_type == 'lesson' ) {
                $this->lesson = $lesson;
                $this->lesson_id = $lesson->ID;
                $this->course_id = $lessson->post_parent;
                parent::setCourseID($lesson->post_parent);
            }
        }
    }

    protected function getLessonID() {
        return $this->lesson_id;
    }

    public function currentNumber($searching_id = null) {
        if (empty($searching_id) ) {
            $searching_id = $this->lesson_id;
        }

        $query = parent::newLessonsQuery();

        $i = 0;

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $lesson_id = get_the_ID();
                if ( $lesson_id === $searching_id ) {
                    break;
                } else {
                  $i++;
              }
          }
      }

      wp_reset_postdata();

      return $i;
  }

  public function hasAccess() {
    global $post;
    $restricted = false;
    $has_access = true;
    $user_id = get_current_user_id();
    $id = $this->id;
    $restricted_to = edd_cr_is_restricted( $this->course_id );


        // If current user is admin, everything is simple
    if ( current_user_can('administrator') ) {
        return $has_access;
    }

    if ( edd_cr_is_restricted($id) ) {
        $restricted = true;
    }

    if ( $restricted && is_user_logged_in() ) {
        $check_access = edd_cr_user_can_access( $user_id, $restricted_to, $id );
        if ( $check_access['status'] ) {
            $has_access = true;
        } else {
            $has_access = false;
        }
    } else {
        $has_access = false;
    }

    return $has_access;
}
}

class Report extends Lesson {

    function __construct() {
        parent::getLessonID();
    }

    public function display() {
        $timevalid = get_field('report_timevalid', $this->lesson_id);
        $required = get_field('report_required', $this->lesson_id);

        echo 'timevalid: ' .$timevalid . ', required: '. $required;

    }
}

function comment( $comment, $depth, $args ) {
  $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
  ?>
  <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? 'parent' : '', $comment ); ?>>
  <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <footer class="comment-meta">
       <div class="comment-author vcard">
          <?php
          /* translators: %s: comment author link */
          if ( $comment->user_id ) {
            $user = get_userdata($comment->user_id);
            $author = $user->display_name;
        } else {
            $author = get_comment_author_link( $comment );
        }
        printf( __( '%s <span class="says">says:</span>' ),
            sprintf( '<b class="fn">%s</b>', $author )
        );
        ?>
    </div><!-- .comment-author -->

    <div class="comment-metadata">
      <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
         <time datetime="<?php comment_time( 'c' ); ?>">
            <?php
            /* translators: 1: comment date, 2: comment time */
            printf( __( '<strong>%1$s</strong>, %2$s' ), get_comment_date( 'j F Y', $comment ), get_comment_time() );
            ?>
            <i class="zmdi zmdi-calendar-alt"></i>
        </time>
    </a>
    <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
</div><!-- .comment-metadata -->

<?php if ( '0' == $comment->comment_approved ) : ?>
   <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
<?php endif; ?>
</footer><!-- .comment-meta -->

<div class="comment-content">
   <?php comment_text(); ?>

<?php
$post_id = get_the_ID();
$comment_id = get_comment_ID();

        //get the setting configured in the admin panel under settings discussions "Enable threaded (nested) comments  levels deep"
$max_depth = get_option('thread_comments_depth');
        //add max_depth to the array and give it the value from above and set the depth to 1
$default = array(
    'add_below'  => 'comment',
    'respond_id' => 'respond',
    'reply_text' => '<i class="zmdi zmdi-long-arrow-return"></i>' . __( 'Odpowiedz', 'pkpk' ),
    'login_text' => __('Log in to Reply'),
    'depth'      => 1,
    'before'     => '<div class="reply">',
    'after'      => '</div>',
    'max_depth'  => $max_depth
);
comment_reply_link($default, $comment_id, $post_id);

        //print_r($test);
?>

</div><!-- .comment-content -->
</article><!-- .comment-body -->
<?php
}
