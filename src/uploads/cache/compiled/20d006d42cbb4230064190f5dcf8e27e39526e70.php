<div class="c-lessons c-reports">
  <?php 
    $course = new App\Course();

    $args = [
      'post_parent' => $course->id,
      'post_type' => 'lesson',
			'post_status' => 'publish',
			'orderby' 	=> 'date',
			'order'		=> 'DESC',
			'posts_per_page' => -1,
    ];

    $lessons_query = new WP_Query($args);
    $lessons_count = $lessons_query->post_count;

    $user_id = get_current_user_id();
    $empty = true;
   ?>

  <?php $bladeQuery = new WP_Query($args); ?><?php if ($bladeQuery->have_posts()) : ?><?php while ($bladeQuery->have_posts()) : ?><?php $bladeQuery->the_post(); ?>
    <?php 

      $lesson_id = get_the_ID();
      $fields = get_post_meta($lesson_id, 'prod_userreporting_fields', true);
      $reports = get_post_meta($lesson_id, 'prod_userreporting_reports', true);
      $mandatory = get_post_meta($lesson_id, 'prod_userreporting_mandatory', true);

      $userReport = $reports[$user_id];

      $report_is_sended = prod_userreporting_is_report_sended($user_id, get_the_ID());
      $report_can_send = prod_userreporting_can_send_report($user_id, get_the_ID());
      $report_status_class = '';

      if ( $report_is_sended ) {
        $report_status_class .= 'is-sended';
      } else {
        if ( $report_can_send ) {
          $report_status_class .= 'not-sended can-send';
        } else {
          $report_status_class .= 'not-sended cannot-send';
        }
      }
     ?>

    <?php if(is_array($userReport)): ?>
      <?php 
        $empty = false;
       ?>
      <article class="c-lessons__item d-flex justify-content-center">
        <div class="col-sm-11 col-md-10">
          <header>
            <div class="c-lessons__item__meta d-flex justify-content-between">
              <p class="c-lessons__item__date"><?php echo e(the_date('j F Y')); ?></p>
              <span class="c-lessons__item__report-status <?php echo e($report_status_class); ?>">
                <?php if($report_is_sended): ?>
                  <i class="zmdi zmdi-check"></i> <?php echo e(__('Raport wysłany w terminie', 'pkpk')); ?>

                <?php else: ?>
                  <?php if($report_can_send): ?>
                    <i class="zmdi zmdi-time-countdown"></i> <?php echo e(__('Raport jeszcze nie wysłany', 'pkpk')); ?>

                  <?php else: ?>
                    <i class="zmdi zmdi-close"></i> <?php echo e(__('Nie możesz już wysłać raportu', 'pkpk')); ?>

                  <?php endif; ?>
                <?php endif; ?>
              </span>
          </div>
            <h2 class="c-lessons__item__heading"><a href=<?php echo e(the_permalink()); ?>><strong><?php echo e($lessons_count); ?>.</strong> <?php echo e(the_title()); ?></a></h2>
          </header>
          <main class="c-lessons__item__content">
            <?php 
              echo prod_userreporting_format_filled_report($userReport, $fields, '', $mandatory);
             ?>
          </main>
        </div>
      </article>
    <?php endif; ?>
    <?php ($lessons_count--); ?>
  <?php endwhile; ?><?php endif; ?>

  <?php (wp_reset_postdata()); ?>

  <?php if($empty): ?>
    <div class="c-lessons__empty d-flex justify-content-center align-items-center">
      <div class="alert alert-warning col-md-10"><?php echo e(__('Żaden raport nie został jeszcze wypełniony.', 'pkpk')); ?></div>
    </div>
  <?php endif; ?>
</div>
