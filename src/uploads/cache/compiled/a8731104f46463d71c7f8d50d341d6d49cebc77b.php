<?php (pkpk_setup_featured_course()); ?>
<?php $__env->startComponent('components.skewy-container', ['variant' => 'white', 'id' => 'program']); ?>
  <div class="container container--program flex--wrap container--padding">
    <h2 class="std-heading std-heading--full-width"><?php echo e(the_field('program_heading')); ?></h2>
    <div class="row row--flex flex--between">

      <?php $__env->startComponent('components.shadow-box', ['variant' => 'white', 'col' => 'lg-8', 'row' => true]); ?>
        <?php if(have_rows('program_list')): ?>
          <div class="features-list features-list--with-ico">
            <ul class="row">
              <?php while(have_rows('program_list')): ?> <?php (the_row()); ?>
                <li class="features-list__element col-md-6">
                  <i class="features-list__element-icon ion-android-checkmark-circle"></i>
                  <div class="features-list__element-content">
                    <p class="features-list__element-heading">
                      <?php echo e(the_sub_field('list_heading')); ?>

                    </p>
                    <div class="features-list__element-text">
                      <?php echo e(the_sub_field('list_content')); ?>

                    </div>
                  </div>
                </li>
              <?php endwhile; ?>
            </ul>
          </div>
        <?php endif; ?>
      <?php echo $__env->renderComponent(); ?>

      <?php if(have_rows('program_summary')): ?>
        <div class="features-summary col-12 col-lg-4">
          <div class="row">
            <?php while(have_rows('program_summary')): ?> <?php (the_row()); ?>
              <div class="col-sm-6 col-lg-12">
                <div class="features-summary__item">
                  <div class="features-summary__item-award">
                    <i class="features-summary__item-icon zmdi <?php echo e(the_sub_field('icon')); ?>"></i>
                    <span class="features-summary__item-uniq"><?php echo e(the_sub_field('award')); ?></span>
                  </div>
                  <div class="features-summary__item-content">
                    <?php echo e(the_sub_field('content')); ?>

                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </div>
<?php echo $__env->renderComponent(); ?>
<?php (wp_reset_postdata()); ?>
