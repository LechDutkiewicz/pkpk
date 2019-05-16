<?php

//namespace App;

/**
 * Meta boxes
 */
add_action('add_meta_boxes', function () {
    add_meta_box( 'lesson-parent', esc_html__('Kurs', 'pkpk'), 'lesson_attributes_meta_box', 'lesson', 'side', 'high', null );
    add_meta_box( 'lesson-list', esc_html__('Lekcje', 'pkpk'), 'lesson_list_meta_box', 'course', 'side', 'high', null );
    add_meta_box( 'reports-list', esc_html__('Raporty', 'pkpk'), 'reports_list_meta_box', 'course', 'side', 'high', null );
    add_meta_box( 'course-users', esc_html__('Uczestnicy Kursu', 'pkpk'), 'course_users_meta_box', 'course', 'side', 'high', null );
}, 20, 3);

function get_admin_edit_user_link( $user_id ){
  if ( get_current_user_id() == $user_id )
     $edit_link = get_edit_profile_url( $user_id );
  else
     $edit_link = add_query_arg( 'user_id', $user_id, self_admin_url( 'user-edit.php'));

  return $edit_link;
}

function course_users_info($post) {
  global $post;
  $originalpost = $post;
  $original_query = $wp_query;
  $parent_id = $originalpost->ID;
  $users = prod_userreporting_get_all_users_IDs($post->ID);

  $the_query = new WP_Query( array( 
    'order' => 'DESC',
    'post_type' => 'lesson',
    'post_parent' => $parent_id,
    'post_status' => 'publish',
    'posts_per_page' => -1
  ) );

  $course_users = [];
  $mandatory_reports = [];
  $not_mandatory_reports = [];
  $user_mandatory_reports = [];
  $user_not_mandatory_reports = [];
  $user_unfilled_mandatory_reports = [];
  $user_unfilled_not_mandatory_reports = [];

  if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      $reports = get_post_meta(get_the_ID(), 'prod_userreporting_reports', true);
      $mandatory = get_post_meta(get_the_ID(), 'prod_userreporting_mandatory', true) == "true";      
      $lesson_id = get_the_ID();

      if ($mandatory) {
        $mandatory_reports[] = get_the_ID();
      } else {
        $not_mandatory_reports[] = get_the_ID();
      }

      if ($users) {
        foreach($users as $user) {
          $wpuser = get_user_by( 'email', $user['email'] );
          $user_id = $wpuser->ID;
          $userHasReport = false;
          if ($reports[$user_id] ) {
            $userHasReport = true;
          }

          if ($userHasReport) {            
            if ($mandatory) {
              $user_mandatory_reports[$user_id][] = $lesson_id; 
            } else {
              $user_not_mandatory_reports[$user_id][] = $lesson_id; 
            }
          } else {
            if ($mandatory) {
              $user_unfilled_mandatory_reports[$user_id][] = $lesson_id; 
            } else {
              $user_unfilled_not_mandatory_reports[$user_id][] = $lesson_id; 
            }
          }
        }
      }
    }

    wp_reset_postdata();
  }

  foreach ($users as $user) {
    $wpuser = get_user_by( 'email', $user['email'] );
    $user_id = $wpuser->ID;
    $user_is_active = !in_array( 'inactive_subscriber', (array) $wpuser->roles );

    $course_users[$user_id] = [
      'id' => $user_id,
      'first_name' => $wpuser->first_name,
      'last_name' => $wpuser->last_name,
      'email' => $user['email'],
      'is_active' => $user_is_active,
      'mandatory_reports' => $user_mandatory_reports[$user_id],
      'not_mandatory_reports' => $user_not_mandatory_reports[$user_id],
      'unfilled_mandatory_reports' => $user_unfilled_mandatory_reports[$user_id],
      'unfilled_not_mandatory_reports' => $user_unfilled_not_mandatory_reports[$user_id]
    ];
  }

  return $course_users;
}

function course_users_meta_box($post) {
  global $post;
  $originalpost = $post;
  $original_query = $wp_query;
  $users = course_users_info($post);
  $parent_id = $post->post_parent;

  $args = array(
    'post_parent' => $parent_id,
    'post_type'   => 'lesson', 
    'numberposts' => -1,
    'post_status' => 'publish' 
  );

  $children = get_children( $args );
  $children_lenght = count($children);
  
  $active_users = array_filter($users, function($user) {
    return $user['is_active'];
  });

  echo '<p>Wszystkich uczestnikow: <strong>' . count($users) . '</strong></p>';
  echo '<p>Aktywnych uczestników: <strong>' . count($active_users) . '</strong></p>';
  echo '<p>Zawieszonych uczestników: <strong>' . ( count($users) - count($active_users) ) . '</strong></p>';

  foreach($users as $user) {
    echo '<div id="prod-user-' . $user['id'] . '">';
    echo '<h3><a href="' . get_admin_edit_user_link($user['id']) . '" target="_blank">' . $user['first_name'] . ' ' . $user['last_name'] . '</a> (' . ($user['is_active'] ? 'aktywny' : 'zawieszony') . ')' . '</h3>';
    echo '<table style="text-align: left">';
    echo '<tr><th>Raporty *</th><th>Raporty niewypełnione *</th><th>Raporty</th><th>Raporty niewypełnione</th></tr>';
    $i = 0;

    for($i = 0; $i < $children_lenght; $i++) {
      $mandatory_title = '';
      $mandatory_url = '';
      $mandatory_date = '';
    
      if ($user['mandatory_reports'][$i]) {
        $mandatory_title = get_the_title( $user['mandatory_reports'][$i] );
        $mandatory_url = get_the_permalink( $user['mandatory_reports'][$i] );
        $mandatory_date = ' (' . get_the_date( 'j F, Y g:i', $user['mandatory_reports'][$i] ). ')';
      }

      $mandatory_unfilled_title = '';
      $mandatory_unfilled_url = '';
      $mandatory_unfilled_date = '';
      if ($user['unfilled_mandatory_reports'][$i]) {
        $mandatory_unfilled_title = get_the_title( $user['unfilled_mandatory_reports'][$i] );
        $mandatory_unfilled_url = get_the_permalink( $user['unfilled_mandatory_reports'][$i] );
        $mandatory_unfilled_date = ' (' . get_the_date( 'j F, Y g:i', $user['unfilled_mandatory_reports'][$i] ). ')';
      }

      $not_mandatory_title = '';
      $not_mandatory_url = '';
      $not_mandatory_date = '';
      if ($user['not_mandatory_reports'][$i]) {
        $not_mandatory_title = get_the_title( $user['not_mandatory_reports'][$i] );
        $not_mandatory_url = get_the_permalink( $user['not_mandatory_reports'][$i] );
        $not_mandatory_date = ' (' . get_the_date( 'j F, Y g:i', $user['not_mandatory_reports'][$i] ). ')';
      }

      $not_mandatory_unfilled_title = '';
      $not_mandatory_unfilled_url = '';
      $not_mandatory_unfilled_date = '';
      if ($user['unfilled_not_mandatory_reports'][$i]) {
        $not_mandatory_unfilled_title = get_the_title( $user['unfilled_not_mandatory_reports'][$i] );
        $not_mandatory_unfilled_url = get_the_permalink( $user['unfilled_not_mandatory_reports'][$i] );
        $not_mandatory_unfilled_date = ' (' . get_the_date( 'j F, Y g:i', $user['unfilled_not_mandatory_reports'][$i] ) . ')';
      }

      echo '<tr>';
      echo '<td><a href="' . $mandatory_url . '" target="_blank">' . $mandatory_title . '</a>' . $mandatory_date . '</td>';
      echo '<td><a href="' . $mandatory_unfilled_url . '" target="_blank">' . $mandatory_unfilled_title . '</a>' . $mandatory_unfilled_date . '</td>';
      echo '<td><a href="' . $not_mandatory_url . '" target="_blank">' . $not_mandatory_title . '</a>' . $not_mandatory_date . '</td>';
      echo '<td><a href="' . $not_mandatory_unfilled_url . '" target="_blank">' . $not_mandatory_unfilled_title . '</a>' . $not_mandatory_unfilled_date . '</td>';
      echo '</tr>';
    }

    echo '</tr>';
    echo '</table>';
    echo '</div>';
  }

  $wp_query = $original_query;
  $post = $originalpost;
  setup_postdata( $original_post );
}

/**
 * Get the Course dropdown
 */
function reports_list_meta_box($post) {
  // Kinda dirty hack, wp_reset_postdata() not working
  global $post;
  $originalpost = $post;
  $original_query = $wp_query;
  $parent_id = $originalpost->ID;
  $users = prod_userreporting_get_all_users_IDs($post->ID);
  $course_users = course_users_info($post);
  // The Query
  $the_query = new WP_Query( array( 
    'order' => 'DESC',
    'post_type' => 'lesson',
    'post_parent' => $parent_id,
    'post_status' => 'publish',
    'posts_per_page' => -1
  ) );

  $i = 0;
  $bad_users = [];
  $max_reports = 1;

  if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) {
      if ($i > $max_reports) {
        break;
      }

      $the_query->the_post();
      $reports = get_post_meta(get_the_ID(), 'prod_userreporting_reports', true);
      $timevalid = get_post_meta(get_the_ID(), 'prod_userreporting_timevalid', true);
      $mandatory = get_post_meta(get_the_ID(), 'prod_userreporting_mandatory', true) == "true";
      $report_date = strtotime(get_the_time('Y/m/d'));
      $report_expire = $report_date + $timevalid * 60 * 60;
      $report_time_left = $report_expire - current_time('timestamp');
      $report_is_open = false;

      if ($report_time_left >= 0 || $timevalid === '0' ) {
        $report_is_open = true;
      }

      // echo $report_is_open;
      
      if (!$mandatory) {
        continue;
      }

      echo $i;

      if ($users) {
        foreach ($users as $user) {
          $userHasReport = false;
          $wpuser = get_user_by( 'email', $user['email'] );
          $userId = $wpuser->ID;
          $user_is_active = !in_array( 'inactive_subscriber', (array) $wpuser->roles );

          if ($reports[$userId] ) {
            $userHasReport = true;
          }
          if (!$user_is_active) {
            unset($bad_users[$userId]);
          }
          if ($i === 0 && $report_is_open) {
            $max_reports = 2;
          }
          if (!$userHasReport) {            
            if ($i === $max_reports - 1) {
              $bad_users[$userId] = [
                'email' => $user['email']
              ];
            }
          } else {
            if ($i === $max_reports) {
              unset($bad_users[$userId]);
            }
          }

          if (count($course_users[$userId]['not_mandatory_reports']) > 0) {
            unset($bad_users[$userId]);
          }
        }
      }

      $i++;
    }
  }

  if ($bad_users) {
    echo '<div><p>Lista aktywnych uczestników, którzy nie wypełnili dwóch ostatnich obowiązkowych, zamkniętych raportów, nie wypełnili obecnie otwartego (jeśli istnieje) i nie wypełnili żadnego nieobowiązkowego:</p>';
      $i = 1;
      foreach ($bad_users as $userId => $user) {
        echo $i .'. <a href="#prod-user-' . $userId . '">' . $user['email'] . '</a><br>';
        $i++;
      }
    echo '</div>';
  }

  // The Query
  $the_query = new WP_Query( array( 
    'order' => 'DESC',
    'post_type' => 'lesson',
    'post_parent' => $parent_id,
    'post_status' => 'publish',
    'posts_per_page' => -1
  ) );

  // The Loop
  if ( $the_query->have_posts() ) {
    echo '<div class="related-lessons">';
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      $reports = get_post_meta(get_the_ID(), 'prod_userreporting_reports', true);
      $timevalid = get_post_meta(get_the_ID(), 'prod_userreporting_timevalid', true);
      $report_date = get_the_time('Y/m/d');
      $report_expire = strtotime($report_date) + $timevalid * 60 * 60;
      $user_is_active = !in_array( 'inactive_subscriber', (array) $wpuser->roles );

      $bad_users = [];

      if ($users) {
        foreach ($users as $user) {
          $userHasReport = false;
          $wpuser = get_user_by( 'email', $user['email'] );
          $userId = $wpuser->ID;
          $user_is_active = !in_array( 'inactive_subscriber', (array) $wpuser->roles );
          
          if ($reports[$userId] ) {
            $userHasReport = true;
          }
          if (!$userHasReport && $user_is_active) {
            $bad_users[] = [
              'id' => $userId,
              'email' => $user['email']
            ];
          }
        }
      }

      printf('
        <div class="related-lessons__lesson">
          <div class="related-lessons__date">%1s</div>
          <div class="related-lessons__title"><strong>%2s</strong></div>
          <div class="related-lessons__controls">
            <a data-href="%3s" class="related-lessons__control-link"><span>%4s</span></a>
            <a data-href="%5s" class="related-lessons__control-link"><span>%6s</span></a>
          </div>
        </div>',
        'Od: ' . get_the_date('j F, Y g:i a') . '<br>Do: ' . date_i18n( 'j F, Y g:i a', $report_expire ),
        get_the_title(),
        get_the_permalink(),
        esc_html__( 'Wypełnione', 'pkpk' ) . ' (' . count($reports) . ')',
        get_edit_post_link(),
        esc_html__( 'Niewypełnione', 'pkpk' ) . ' (' . count($bad_users)  . ')'
      );

      echo 'Niewypełnione raporty:<br/><br/>';

      //$users2 = prod_userreporting_get_users_with_unfilled_reports(get_the_ID(), $parent_id);
      // and simply send warning email to everyone      
      // print_r(prod_userreporting_get_all_users_IDs($post->post_parent));
      // print_r($reports);
      if ($bad_users) {
        $i = 1;
        foreach ($bad_users as $user) {
          $wpuser = get_user_by( 'email', $user['email'] );
          $user_is_active = !in_array( 'inactive_subscriber', (array) $wpuser->roles );
          if ($user_is_active) {
            echo $i . '. ' . $user['email'] . '<br />';
          }
          $i++;
        }
      }
      echo '<br />';
    }
    echo '</div>';
    // Restore original Post Data, dunno why but not working here, maybe it's a WP bug
    //wp_reset_postdata();
  } else {
    // No lessons found
    echo '<p>' . esc_html__( 'Ten kurs nie posiada żadnych lekcji z raportami.', 'pkpk' ) . '</p>';
  }
  wp_reset_postdata();

  // Add New Lesson button
  $url = admin_url('post-new.php?post_type=lesson&parent_id=' . $parent_id);
  echo '<a href="' . $url . '" class="button button-primary button-large" target="_blank">' . esc_html__('Dodaj nową lekcję', 'pkpk') . '</a>';

  // Restore original query and post
  $wp_query = $original_query;
  $post = $originalpost;
  setup_postdata( $original_post );
}

/**
 * Get the Course dropdown
 */
function lesson_list_meta_box($post) {
    // Kinda dirty hack, wp_reset_postdata() not working
    global $post;
    $originalpost = $post;
    $original_query = $wp_query;
    $parent_id = $originalpost->ID;
    // The Query
    $the_query = new WP_Query( array( 'order' => 'ASC', 'post_type' => 'lesson', 'post_parent' => $parent_id ) );

    // The Loop
    if ( $the_query->have_posts() ) {
    	echo '<div class="related-lessons">';
    	while ( $the_query->have_posts() ) {
    		$the_query->the_post();
        printf('
          <div class="related-lessons__lesson">
            <div class="related-lessons__date">%1s</div>
            <div class="related-lessons__title"><strong>%2s</strong></div>
            <div class="related-lessons__controls">
              <a href="%3s" class="related-lessons__control-link"><span>%4s</span></a>
              <a href="%5s" class="related-lessons__control-link"><span>%6s</span></a>
            </div>
          </div>',
          get_the_date('j F, Y g:i a'),
          get_the_title(),
          get_the_permalink(),
          esc_html__( 'Zobacz', 'pkpk' ),
          get_edit_post_link(),
          esc_html__( 'Edytuj', 'pkpk' )
        );
    	}
    	echo '</div>';
    	// Restore original Post Data, dunno why but not working here, maybe it's a WP bug
    	//wp_reset_postdata();
    } else {
    	// No lessons found
      echo '<p>' . esc_html__( 'Ten kurs nie posiada żadnych lekcji', 'pkpk' ) . '</p>';
    }
    wp_reset_postdata();

    // Add New Lesson button
    $url = admin_url('post-new.php?post_type=lesson&parent_id=' . $parent_id);
    echo '<a href="' . $url . '" class="button button-primary button-large" target="_blank">' . esc_html__('Dodaj nową lekcję', 'pkpk') . '</a>';

    // Restore original query and post
    $wp_query = $original_query;
    $post = $originalpost;
    setup_postdata( $original_post );
}

function pkpk_find_closest_future_course($courses, $from, $only_one = true, $date_field = 'start_raw') {
  $new_courses = array();
  foreach ($courses as $key => $course ) {

      $diff = strtotime($course[$date_field]) - strtotime($from);
      if ( $diff > 0 ) {
          $new_courses[] = $course;
      }

  }

  if ( $only_one ) {
    return $new_courses[0];
  } else {
    return $new_courses;
  }
}

function pkpk_future_courses() {
  $post_id = 5;
  $featured_course = get_field('featured_course', $post_id);
  $related_courses = get_field('featured_course_related', $post_id);

  $allcourses = array();
  $allcourses[] = $featured_course;

  if ( $related_courses ) {
    foreach ( $related_courses as $course ) {
      $allcourses[] = $course['related_course'];
    }
  }

  // find near course
  $courses = array();
  foreach ( $allcourses as $key => $course ) {
    $download_id = get_field('course_download', $course->ID, false);
    $course_meta = get_post_meta($download_id);
    $prices = unserialize($course_meta['edd_variable_prices'][0]);
    //print_r($course_meta);
    //print_r( $course_meta['_edd_purchase_limit_end_date'] );
    $purchase_end = $course_meta['_edd_purchase_limit_end_date'][0];

    $courses[$key] = array(
      'ID' => $course->ID,
      'start' => get_field('course_start', $course->ID),
      'start_raw' => get_field('course_start', $course->ID, false),
      'purchase_end' => $purchase_end,
      'downloadID' => $download_id,
      'variants' => array(
        'basic' => array(
          'price' => $prices[1]['amount']
        ),
        'pro' => array(
          'price' => $prices[2]['amount']
        )
      )
    );
  }
  $now = date('Y-m-d H:i');
  $future_courses = pkpk_find_closest_future_course($courses, $now, false, 'purchase_end');

  //print_r($courses);
  return $future_courses;
}

function pkpk_find_closest_course($setup_featured_course = false) {
    if ( $setup_featured_course ) {
      wp_reset_postdata();
    }

    global $post;
    $featured_course = get_field('featured_course', $post->ID);
    $related_courses = get_field('featured_course_related', $post->ID);

    $courses = array();
    $courses[] = $featured_course;

    if ( $related_courses ) {
      foreach ( $related_courses as $course ) {
        $courses[] = $course['related_course'];
      }
    }

    // find near course
    $courses_start = array();
    foreach ( $courses as $key => $course ) {
      $courses_start[$key] = array(
        'ID' => $course->ID,
        'start' => get_field('course_start', $course->ID),
        'start_raw' => get_field('course_start', $course->ID, false),
        'download_ID' => get_field('course_download', $course->ID, false),
      );
    }

    //print_r($courses_start);
    date_default_timezone_set('Europe/Warsaw');
    $now = date('Y-m-d H:i');
    $closest_course = pkpk_find_closest_future_course($courses_start, $now);

    if ( $setup_featured_course ) {
      pkpk_setup_featured_course();
    }

    return $closest_course;
}

function pkpk_find_closest_future_date($date_array, $from) {
  foreach($date_array as $key => $day) {
    $diff = strtotime($day) - strtotime($from);
    if ( $diff > 0 ) {
      $result_future[$key] = $day;
    }
  }

  $closest = ksort($result_future);
  return $date_array[$closest];
}

function pkpk_get_closest_course_add_to_cart($id) {

  return pkpk_get_course_add_to_cart($id);
}

function pkpk_get_course_add_to_cart($id) {
  $link = home_url('/') . 'checkout?edd_action=add_to_cart&download_id=' . $id;
  return $link;
}

/**
 * Get the Course dropdown
 */
function lesson_attributes_meta_box($post) {
    $post_type_object = get_post_type_object( $post->post_type );
    $parent_id = htmlspecialchars( $_GET["parent_id"] );

    if ( !empty($parent_id) && empty($post->post_parent) ) {
        $selected = $parent_id;
    } else {
        $selected = $post->post_parent;
    }

	  $pages = wp_dropdown_pages( array( 'post_type' => 'course', 'selected' => $selected, 'name' => 'parent_id', 'show_option_none' => __( '(no parent)' ), 'sort_column'=> 'menu_order, post_title', 'echo' => 0 ) );
	  if ( ! empty( $pages ) ) {
		    echo $pages;
	  }
}

/**
 * Add rewrite rules
 */
/*
add_action( 'init', function() {
    add_rewrite_tag('%lesson%', '([^/]+)', 'lesson=');
    //add_rewrite_tag('%courseid%', '([^/]+)', 'course=');
    add_permastruct('lesson', '/lekcja/kwiecien/2017/%post_id%/%lesson_number%/', false);
    //add_permastruct('course', '/kurs/%courseid%/', false);
    add_rewrite_rule('^lekcja/kwiecien/2017/([^/]+)/([^/]+)/?','index.php?lesson=$matches[1]','top');
    //add_rewrite_rule('^kurs/([^/]+)/?$','index.php?course=29','top');

    // TODO: this should be done only once on theme switch
    flush_rewrite_rules();
});
*/


add_action('acf/input/admin_head', function() {
  // TODO: move js and css to separate files and enqueue it properly
  ?>
  <script type="text/javascript">
  (function($) {
      $(document).ready(function(){
          $('.acf-field-589b219fea183 .acf-input').append( $('#content-restriction') );
          $('.acf-field-589b96e9b1363 .acf-input').append( $('#lesson-list .inside') );
          $('.acf-field-58de6f8558ae0 .acf-input').append( $('#postdivrich') );
          $('.acf-field-58de6f9558ae1 .acf-input').append( $('#postexcerpt .inside') );
          $('.acf-field-58de6fda58ae5 .acf-input').append( $('#commentstatusdiv .inside') );
          $('.acf-field-58de718d36b18 .acf-input').append( $('#userreporting_config .inside') );
          $('.acf-field-58de6fcb58ae4 .acf-input').append( $('#userreporting_filled .inside') );

      });
  })(jQuery);
  </script>


  <style type="text/css">
      .acf-field #wp-content-editor-tools {
          background: transparent !important;
          padding-top: 0 !important;
      }

      #lesson-list,
      /*.wp-admin.post-type-lesson #postdivrich,*/
      .wp-admin.post-type-lesson #postexcerpt,
      .wp-admin.post-type-lesson #commentstatusdiv,
      .wp-admin.post-type-lesson #userreporting_config,
      .wp-admin.post-type-lesson #userreporting_filled {
        display: none;
      }

      .acf-field #edd-cr-options > p {
        padding: 0 12px;
      }

      .acf-field .inside {
          padding: 0;
      }

      .related-lessons {
        margin-bottom: 12px;
      }

      .related-lessons__date {
        border-right: 1px solid rgba(0, 0, 0, 0.1);
        width: 220px;
        flex: 0 0 220px;
        padding: 13px 12px 12px;
      }

      .related-lessons__title {
        font-size: 0.9375rem;
        line-height: 1.4;
        padding: 12px 20px;
        display: flex;
        align-items: center;
      }

      .related-lessons__lesson .related-lessons__control-link {
        border-left: 1px solid rgba(0, 0, 0, 0.1);
        background: rgba(0, 0, 0, 0.04);
        text-decoration: none;
        display: flex;
        align-items: center;
        padding-left: 20px;
        padding-right: 20px;
      }
        .related-lessons__lesson .related-lessons__control-link:hover {
          background: rgba(0, 0, 0, 0.08);
        }

      .related-lessons__lesson {
        display: flex;
        width: 100%;
        justify-content: space-between;
        background: rgba(0, 0, 0, 0.03);
      }

      .related-lessons__lesson {
        margin-bottom: 8px;
      }

      .related-lessons__lesson .related-lessons__title {
        flex: 1 1 auto;
      }

      .related-lessons__lesson .related-lessons__controls {
        padding: 0;
        display: flex;
      }

      .acf-field .inside > ul li a:hover {
        background: rgba(0, 0, 0, 0.07);
      }
  </style>
  <?php
});

function pkpk_setup_featured_course() {
  global $post;

  $featured_course = get_field('featured_course');
  $featured_course_id = $featured_course->ID;
  // override $post
  if ( $featured_course ) {
    $post = $featured_course;
    return setup_postdata( $post );
  }
}

/**
 * Get Checkout Form
 *
 * @since 1.0
 * @return string
 */
function pkpk_checkout_form() {
  $items = edd_get_cart_quantity();

  for( $i = 0; $i < $items - 1; $i++) {
    EDD()->cart->remove($i);
  }
	$payment_mode = edd_get_chosen_gateway();
	$form_action  = esc_url( edd_get_checkout_uri( 'payment-mode=' . $payment_mode ) );
	ob_start();
		echo '<div id="edd_checkout_wrap">';
		if ( edd_get_cart_contents() || edd_cart_has_fees() ) :
?>
			<div id="edd_checkout_form_wrap" class="edd_clearfix">
				<?php do_action( 'edd_before_purchase_form' ); ?>
				<form id="edd_purchase_form" class="edd_form" action="<?php echo $form_action; ?>" method="POST">
					<?php
					/**
					 * Hooks in at the top of the checkout form
					 *
					 * @since 1.0
					 */
					do_action( 'edd_checkout_form_top' );
					if ( edd_show_gateways() ) {
						do_action( 'edd_payment_mode_select'  );
					} else {
						do_action( 'edd_purchase_form' );
					}
					/**
					 * Hooks in at the bottom of the checkout form
					 *
					 * @since 1.0
					 */
					do_action( 'edd_checkout_form_bottom' )
					?>
				</form>
				<?php do_action( 'edd_after_purchase_form' ); ?>
			</div><!--end #edd_checkout_form_wrap-->
		<?php
		else:
			/**
			 * Fires off when there is nothing in the cart
			 *
			 * @since 1.0
			 */
			do_action( 'edd_cart_empty' );
		endif;
		echo '</div><!--end #edd_checkout_wrap-->';
	return ob_get_clean();
}

remove_action( 'edd_purchase_form', 'edd_show_purchase_form' );
remove_action( 'edd_purchase_form_after_user_info', 'edd_user_info_fields' );

function pkpk_avalible_payment_options() {
  echo '<div class="payment-options">';
  echo '<p>' . esc_html__('Płatność możliwa przez:', 'pkpk') . '</p>';
  echo '<div class="payment-options__logos">';
  for( $i = 1; $i < 15; $i++ ) {
    echo '<div class="payment-options__logo-item"><img src="' . App\asset_path('images/payment-logos/payment-logo-'. $i .'.png') . '" alt=""></div>';
  }
  echo '</div>';
  echo '<p>' . esc_html__('oraz wiele innych', 'pkpk') . '</p>';
  echo '</div>';
}
add_action('edd_after_purchase_form', 'pkpk_avalible_payment_options');
/**
 * Shows the User Info fields in the Personal Info box, more fields can be added
 * via the hooks provided.
 *
 * @since 1.3.3
 * @return void
 */
function pkpk_user_info_fields() {
	$customer = EDD()->session->get( 'customer' );
	$customer = wp_parse_args( $customer, array( 'first_name' => '', 'last_name' => '', 'email' => '' ) );
	if( is_user_logged_in() ) {
		$user_data = get_userdata( get_current_user_id() );
		foreach( $customer as $key => $field ) {
			if ( 'email' == $key && empty( $field ) ) {
				$customer[ $key ] = $user_data->user_email;
			} elseif ( empty( $field ) ) {
				$customer[ $key ] = $user_data->$key;
			}
		}
	}
	$customer = array_map( 'sanitize_text_field', $customer );
	?>
	<fieldset id="edd_checkout_user_info">
    <p id="edd-first-name-wrap">
			<label class="edd-label" for="edd-first">
				<?php _e( 'First Name', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'edd_first' ) ) { ?>
					<span class="edd-required-indicator">*</span>
				<?php } ?>
			</label>
			<input class="edd-input required" type="text" name="edd_first" id="edd-first" value="<?php echo esc_attr( $customer['first_name'] ); ?>"<?php if( edd_field_is_required( 'edd_first' ) ) {  echo ' required '; } ?> autofocus/>
		</p>
    <p id="edd-last-name-wrap">
			<label class="edd-label" for="edd-last">
				<?php _e( 'Last Name', 'easy-digital-downloads' ); ?>
					<span class="edd-required-indicator">*</span>
			</label>
			<input class="edd-input required" type="text" name="edd_last" id="edd-last" value="<?php echo esc_attr( $customer['last_name'] ); ?>" required/>
		</p>
    <?php do_action( 'edd_purchase_form_before_email' ); ?>
		<p id="edd-email-wrap">
			<label class="edd-label" for="edd-email">
				<?php _e( 'Email Address', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'edd_email' ) ) { ?>
					<span class="edd-required-indicator">*</span>
				<?php } ?>
			</label>
			<input class="edd-input required" type="email" name="edd_email"id="edd-email" value="<?php echo esc_attr( $customer['email'] ); ?>"<?php if( edd_field_is_required( 'edd_email' ) ) {  echo ' required '; } ?>/>
		</p>
		<?php do_action( 'edd_purchase_form_after_email' ); ?>
		<?php do_action( 'edd_purchase_form_user_info' ); ?>
		<?php do_action( 'edd_purchase_form_user_info_fields' ); ?>
	</fieldset>
	<?php
}

add_action( 'edd_purchase_form_after_user_info', 'pkpk_user_info_fields' );

function pkpk_show_purchase_form() {
  $payment_mode = edd_get_chosen_gateway();
	/**
	 * Hooks in at the top of the purchase form
	 *
	 * @since 1.4
	 */
	do_action( 'edd_purchase_form_top' );
	if ( edd_can_checkout() ) {
		do_action( 'edd_purchase_form_before_register_login' );
		$show_register_form = edd_get_option( 'show_register_form', 'none' ) ;
		if( ( $show_register_form === 'registration' || ( $show_register_form === 'both' && ! isset( $_GET['login'] ) ) ) && ! is_user_logged_in() ) : ?>
			<div id="edd_checkout_login_register">
				<?php do_action( 'edd_purchase_form_register_fields' ); ?>
			</div>
		<?php elseif( ( $show_register_form === 'login' || ( $show_register_form === 'both' && isset( $_GET['login'] ) ) ) && ! is_user_logged_in() ) : ?>
			<div id="edd_checkout_login_register">
				<?php do_action( 'edd_purchase_form_login_fields' ); ?>
			</div>
		<?php endif; ?>

		<?php if( ( ! isset( $_GET['login'] ) && is_user_logged_in() ) || ! isset( $show_register_form ) || 'none' === $show_register_form || 'login' === $show_register_form ) {
			do_action( 'edd_purchase_form_after_user_info' );
		}
		/**
		 * Hooks in before Credit Card Form
		 *
		 * @since 1.4
		 */
		//do_action( 'edd_purchase_form_before_cc_form' );
		if( edd_get_cart_total() > 0 ) {
			// Load the credit card form and allow gateways to load their own if they wish
			if ( has_action( 'edd_' . $payment_mode . '_cc_form' ) ) {
				do_action( 'edd_' . $payment_mode . '_cc_form' );
			} else {
				do_action( 'edd_cc_form' );
			}
		}
		/**
		 * Hooks in after Credit Card Form
		 *
		 * @since 1.4
		 */
		do_action( 'edd_purchase_form_after_cc_form' );
	} else {
		// Can't checkout
		do_action( 'edd_purchase_form_no_access' );
	}
	/**
	 * Hooks in at the bottom of the purchase form
	 *
	 * @since 1.4
	 */
	do_action( 'edd_purchase_form_bottom' );
}

function pkpk_checkout_form_top() {
  $cart_items = edd_get_cart_contents();
  $item_note = get_post_meta( $cart_items[0]['id'], 'edd_product_notes', true );
  $warranty_text = get_field( "checkout_warranty_text", "options-warranty" );
  $warranty_img_src = get_field( "checkout_warranty_img", "options-warranty" );
  $warranty_title = get_field( "cta_warranty", "options-warranty" );

  $items = '';

  if ( $cart_items ) {
    foreach ( $cart_items as $key => $item ) {
      $items .= get_the_title( $item['id'] );
      ( $key > 0 ) ? $items .= ' + ' : null;
    }
  }

  $heading = esc_html__('Zapisz się - podsumowanie', 'pkpk');

  if ( $cart_items[0])
  $output = sprintf('
    <h2 class="std-heading">%1$s</h2>
    <div class="std-content">%5$s</div><div class="col-sm-12"><hr></div><div class="row warranty__info"><div class="col-sm-12">%4$s</div></div>',
    $heading,
    $warranty_img_src,
    $warranty_title,
    $warranty_text,
    $item_note
  );

  echo $output;
}
add_action( 'edd_purchase_form_top', 'pkpk_checkout_form_top' );

function pkpk_checkout_form_bottom() {
  $cart_items = edd_get_cart_contents();
  $item_date_end = get_post_meta( $cart_items[0]['id'], '_edd_purchase_limit_end_date', true );
  $date_end = strtotime($item_date_end);
  $item_type = get_post_meta( $cart_items[0]['id'], 'edd_variable_prices' );
  $price_id = $cart_items[0]['options']['price_id'];
  $item_type_name = $item_type[0][$price_id]['name'];

  $summary = '<div class="item-summary"><div class="row">';

  $summary .= '<div class="item-summary__el col-sm-4"><p class="item-summary__heading">' . esc_html__('Typ kursu') . '</p><i class="zmdi zmdi-sort-amount-desc"></i>' . $item_type_name . '</div>';
  $summary .= '<div class="item-summary__el col-sm-4"><p class="item-summary__heading">' . esc_html__('Termin') . '</p><i class="zmdi zmdi-calendar-alt"></i>' . date_i18n('j F Y', $date_end) . '</div>';
  $summary .= '<div class="item-summary__el col-sm-4"><p class="item-summary__heading">' . esc_html__('Kwota') . '</p><i class="zmdi zmdi-money-box"></i><span class="edd_cart_amount">' . edd_cart_total(false) . '</span></div>';

  $summary .= '</div></div>';

  echo '<div class="checkout-table">' . $summary . '</div>';
}

add_action( 'edd_purchase_form_before_submit', 'pkpk_checkout_form_bottom', -1 );
add_action( 'edd_purchase_form', 'pkpk_show_purchase_form' );


function pkpk_edd_invoice_data_enable_forms() {
  add_action( 'edd_purchase_form_after_user_info', 'bpmj_edd_invoice_data_cc_form', 0 );
}

remove_action( 'plugins_loaded', 'bpmj_edd_invoice_data_enable_forms', -1 );
//add_action( 'plugins_loaded', 'pkpk_edd_invoice_data_enable_forms' );

/**
 * Renders the Checkout Submit section
 *
 * @since 1.3.3
 * @return void
 */
function pkpk_edd_checkout_submit() {
?>
	<fieldset id="edd_purchase_submit">
		<?php do_action( 'edd_purchase_form_before_submit' ); ?>

		<?php edd_checkout_hidden_fields(); ?>

		<?php echo pkpk_edd_checkout_button_purchase(); ?>

		<?php do_action( 'edd_purchase_form_after_submit' ); ?>

		<?php if ( edd_is_ajax_disabled() ) { ?>
			<p class="edd-cancel"><a href="<?php echo edd_get_checkout_uri(); ?>"><?php _e( 'Go back', 'easy-digital-downloads' ); ?></a></p>
		<?php } ?>
	</fieldset>
<?php
}
remove_action( 'edd_purchase_form_before_submit', 'edd_checkout_final_total', 999 );
remove_action( 'edd_purchase_form_after_cc_form', 'edd_checkout_submit', 9999 );
add_action( 'edd_purchase_form_after_cc_form', 'pkpk_edd_checkout_submit', 9999 );

/**
 * Renders the Purchase button on the Checkout
 *
 * @since 1.2
 * @return string
 */
function pkpk_edd_checkout_button_purchase() {
	$color = edd_get_option( 'checkout_color', 'blue' );
	$color = ( $color == 'inherit' ) ? '' : $color;
	$style = edd_get_option( 'button_style', 'button' );
	$label = edd_get_option( 'checkout_label', '' );
	if ( edd_get_cart_total() ) {
		$complete_purchase = ! empty( $label ) ? $label : __( 'Zapisuję się i płacę', 'pkpk' ) . ' ';
	} else {
		$complete_purchase = ! empty( $label ) ? $label : __( 'Free Download', 'easy-digital-downloads' );
	}
	ob_start();
?>
	<button type="submit" class="edd-submit btn btn--secondary btn--large btn--full-width" id="edd-purchase-button" name="edd-purchase">
    <?php echo $complete_purchase . '<span class="edd_cart_amount">' . edd_cart_total(false) .'</span>'; ?>
  </button>
<?php
	return apply_filters( 'edd_checkout_button_purchase', ob_get_clean() );
}

/**
 * Clear the cart.
 *
 * @since       1.0.0
 */
function eddcc_process_clear_cart() {
	// Remove cart contents
	return EDD()->session->set( 'edd_cart', NULL );
	// Remove all cart fees
	EDD()->session->set( 'edd_cart_fees', NULL );
	// Remove any active discounts
	edd_unset_all_cart_discounts();
}
//eddcc_process_clear_cart();
//add_action( 'edd_download_redirect_to_checkout', 'eddcc_process_clear_cart' );

function pkpk_edd_process_add_to_cart( $data ) {
	$download_id = absint( $data['download_id'] );
	$options     = isset( $data['edd_options'] ) ? $data['edd_options'] : array();
	if ( ! empty( $data['edd_download_quantity'] ) ) {
		$options['quantity'] = absint( $data['edd_download_quantity'] );
	}
	if ( isset( $options['price_id'] ) && is_array( $options['price_id'] ) ) {
		foreach ( $options['price_id'] as  $key => $price_id ) {
			$options['quantity'][ $key ] = isset( $data[ 'edd_download_quantity_' . $price_id ] ) ? absint( $data[ 'edd_download_quantity_' . $price_id ] ) : 1;
		}
	}
	$cart        = edd_add_to_cart( $download_id, $options );
	if ( edd_straight_to_checkout() && ! edd_is_checkout() ) {

		$query_args 	= remove_query_arg( array( 'edd_action', 'download_id', 'edd_options' ) );
		$query_part 	= strpos( $query_args, "?" );
		$url_parameters = '';
		if ( false !== $query_part ) {
			$url_parameters = substr( $query_args, $query_part );
		}
		wp_redirect( edd_get_checkout_uri() . $url_parameters, 303 );
		edd_die();
	} else {
		wp_redirect( remove_query_arg( array( 'edd_action', 'download_id', 'edd_options' ) ) ); edd_die();
	}
}
remove_action( 'edd_add_to_cart', 'edd_process_add_to_cart' );
//add_action('edd_add_to_cart', 'eddcc_process_clear_cart', 10);
add_action( 'edd_add_to_cart', 'pkpk_edd_process_add_to_cart' );

// function ajax_login() {
//     // First check the nonce, if it fails the function will break
//     check_ajax_referer( 'ajax-login-nonce', 'security' );
//
//     // Nonce is checked, get the POST data and sign user on
//     $info = array();
//     $info['user_login'] = $_POST['username'];
//     $info['user_password'] = $_POST['password'];
//     $info['remember'] = true;
//     // This is not working with SSL, second arg have to be true.
//     $user_signon = wp_signon( $info, false );
//     if ( is_wp_error($user_signon) ) {
//         echo json_encode(array('loggedin'=>false, 'message'=>__('Nieprawidłowy adres email lub hasło.', 'pkpk')));
//     } else {
//         echo json_encode(array('loggedin'=>true, 'message'=>__('Zalogowano pomyślnie, przekierowuję...', 'pkpk')));
//     }
//
//     die();
// }
//
// function ajax_login_init(){
//
// }

// Enable the user with no privileges to run ajax_login() in AJAX
// add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );

// Execute the action only if the user isn't logged in
// if (!is_user_logged_in()) {
//     add_action('wp_enqueue_scripts', 'ajax_login_init');
// }


/**
 * Renders the Discount Code field which allows users to enter a discount code.
 * This field is only displayed if there are any active discounts on the site else
 * it's not displayed.
 *
 * @since 1.2.2
 * @return void
*/
function pkpk_edd_discount_field() {
	if( isset( $_GET['payment-mode'] ) && edd_is_ajax_disabled() ) {
		return; // Only show before a payment method has been selected if ajax is disabled
	}
	if( ! edd_is_checkout() ) {
		return;
	}
	if ( edd_has_active_discounts() && edd_get_cart_total() ) :
		$color = edd_get_option( 'checkout_color', 'blue' );
		$color = ( $color == 'inherit' ) ? '' : $color;
		$style = edd_get_option( 'button_style', 'button' );
?>
		<fieldset id="edd_discount_code">
			<p id="edd_show_discount" style="display:none;">
				<?php _e( 'Have a discount code?', 'easy-digital-downloads' ); ?> <a href="#" class="edd_discount_link"><?php echo _x( 'Click to enter it', 'Entering a discount code', 'easy-digital-downloads' ); ?></a>
			</p>

      <div id="edd-discount-code-wrap">
        <label class="edd-label" for="edd-discount">
					<?php _e( 'Discount', 'easy-digital-downloads' ); ?>
				</label>
        <div class="row">
        <div class="col-md-8">
          <input class="edd-input" type="text" id="edd-discount" name="edd-discount" placeholder="<?php _e( 'Enter discount', 'easy-digital-downloads' ); ?>"/>
        </div>
        <div class="col-md-4">
          <input type="submit" class="btn btn--border-secondary btn--large edd-apply-discount edd-submit" value="<?php echo _x( 'Zastosuj kod', 'Apply discount at checkout', 'easy-digital-downloads' ); ?>"/>
        </div>
      </div>
        <span class="edd-discount-loader edd-loading" id="edd-discount-loader" style="display:none;"></span>
				<span id="edd-discount-error-wrap" class="edd_error edd-alert edd-alert-error" aria-hidden="true" style="display:none;"></span>
        <p class="edd_cart_discount"></p>
      </div>
		</fieldset>
<?php
	endif;
}
remove_action( 'edd_checkout_form_top', 'edd_discount_field', -1 );
add_action( 'edd_purchase_form_before_submit', 'pkpk_edd_discount_field', 0 );

/*-----------------------------------------------------------------------------------*/
/* Browser detection body_class() output */
/*-----------------------------------------------------------------------------------*/
add_filter( 'body_class','browser_body_class' );
function browser_body_class($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera,
 $is_NS4, $is_safari, $is_chrome, $is_iphone;

    if($is_lynx) $classes[] = 'lynx';//don't need
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';//don't need
    elseif($is_IE) {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $browser = substr( "$browser", 25, 8);
        if ($browser == "MSIE 7.0"  ) {
            $classes[] = 'ie7';
            $classes[] = 'ie';
        } elseif ($browser == "MSIE 6.0" ) {
            $classes[] = 'ie6';
            $classes[] = 'ie';
        } elseif ($browser == "MSIE 8.0" ) {
            $classes[] = 'ie8';
            $classes[] = 'ie';
        } elseif ($browser == "MSIE 9.0" ) {
            $classes[] = 'ie9';
            $classes[] = 'ie';
        } else {
            $classes[] = 'ie';
        }
    }
    else $classes[] = 'unknown';

    if($is_iphone) $classes[] = 'iPhone';
    return $classes;
}

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}
