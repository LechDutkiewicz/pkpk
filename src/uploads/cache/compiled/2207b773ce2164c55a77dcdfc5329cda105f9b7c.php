<?php (pkpk_setup_featured_course()); ?>

<section class="bg bg--gray bg--steps">
  <div class="container container--steps container--padding">
    <div class="row">
      <div class="container">
        <h2 class="std-heading"><?php echo e(the_field('step-by-step_heading')); ?></h2>
        <?php if( have_rows('step-by-step_steps') ): ?>
          <div class="steps">
            <div class="row">
              <?php while(have_rows('step-by-step_steps')): ?> <?php (the_row()); ?>
                <div class="steps__step col-sm-6 col-lg-3">
                  <div class="steps__step-icon">
                    <i class="<?php echo e(the_sub_field('step_icon')); ?>"></i>
                  </div>
                  <div class="steps__step-body">
                    <div class="steps__step-heading">
                      <p><strong><?php echo e(the_sub_field('step_heading')); ?></strong></p>
                    </div>
                    <div class="steps__step-content">
                      <?php echo e(the_sub_field('step_content')); ?>

                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php (wp_reset_postdata()); ?>
