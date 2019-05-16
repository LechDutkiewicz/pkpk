<div class="c-lessons">
  <?php 
    global $post;
    $post_id = $post->ID;

    $args = [
      'post_type' => 'lesson',
      'post_parent' => $post_id,
      'order' => 'DESC',
    ];

    $lessons_query = new WP_Query($args);
    $lessons_count = $lessons_query->post_count;

    $user_id = get_current_user_id();
   ?>

  <?php $bladeQuery = new WP_Query($args); ?><?php if ($bladeQuery->have_posts()) : ?><?php while ($bladeQuery->have_posts()) : ?><?php $bladeQuery->the_post(); ?>
    <article class="c-lessons__item d-flex justify-content-center">
      <div class="col-sm-10 col-md-11 col-lg-10">
        <header>
          <p class="c-lessons__item__date"><?php echo e(the_date('j F Y')); ?></p>
          <h2 class="c-lessons__item__heading"><a href=<?php echo e(the_permalink()); ?>><strong><?php echo e($lessons_count); ?>.</strong> <?php echo e(the_title()); ?></a></h2>
        </header>
        <main class="c-lessons__item__content">
          <?php echo e(the_excerpt()); ?>

        </main>
        <footer class="c-lessons__item__meta">
          <div class="c-lessons__item__meta-info">
            <span class="c-lessons__item__comments">
              (<?php echo e(comments_number( 'Brak komentarzy', '1 komentarz', '% komentarze' )); ?>)
            </span>
            <?php 
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
          <a href="<?php echo e(the_permalink()); ?>" class="btn btn--border-green"><?php echo e(__('Przejdź do lekcji', 'pkpk')); ?></a>
        </footer>
      </div>
    </article>
    <?php ($lessons_count--); ?>
  <?php endwhile; ?><?php endif; ?>
  <?php $bladeQuery = new WP_Query($args); ?><?php if ($bladeQuery->have_posts() == false) : ?>
    <div class="c-lessons__empty d-flex justify-content-center align-items-center">
      <div class="alert alert-warning"><?php echo e(__('Ten kurs nie ma żadnych lekcji', 'pkpk')); ?></div>
    </div>
  <?php endif; ?>
  <?php (wp_reset_postdata()); ?>

</div>
