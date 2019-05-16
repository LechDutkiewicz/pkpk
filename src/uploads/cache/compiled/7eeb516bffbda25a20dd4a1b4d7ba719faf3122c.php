<?php $__env->startComponent('components.bg-section', ['variant' => 'dark row no-gutters', 'id' => 'trener']); ?>
  <div class="container container--padding">
    <div class="row">
      <div class="coach-content col-6">
        <div class="row">
        <?php echo e(the_field('coach_about')); ?>


        <?php if(have_rows('coach_social_media')): ?>
          <ul class="social-profiles">
            <?php while(have_rows('coach_social_media')): ?> <?php (the_row()); ?>
              <li class="social-profiles__item">
                <?php if(get_sub_field('url_type') == 'email' ): ?>
                  <a href="mailto:<?php echo e(the_sub_field('email')); ?>">
                    <i class="zmdi <?php echo e(the_sub_field('icon')); ?>"></i>
                  </a>
                <?php elseif( get_sub_field('url_type') == 'url' ): ?>
                  <a href="<?php echo e(the_sub_field('url')); ?>">
                    <i class="zmdi <?php echo e(the_sub_field('icon')); ?>"></i>
                  </a>
                <?php endif; ?>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php echo $__env->renderComponent(); ?>
