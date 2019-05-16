<?php $__env->startComponent('components.skewy-container', ['variant' => 'white', 'id' => 'kontakt']); ?>
  <div class="container container--contact container--padding">
    <div class="row">
      <div class="col-lg-6">
        <h2 class="std-heading"><?php echo e(the_field('contact_heading')); ?></h2>
        <div class="std-content"><?php echo e(the_field('contact_content')); ?></div>

        <?php if(have_rows('contact_people')): ?>
          <div class="contacts-list">
            <?php while(have_rows('contact_people')): ?> <?php (the_row()); ?>
              <div class="contacts-list__item">
                <div class="contacts-list__item-icon">
                  <i class="zmdi zmdi-email"></i>
                </div>
                <div class="contacts-list__item-content">
                  <p class="contacts-list__email">
                    <a href="mailto:<?php echo e(the_sub_field('email')); ?>"><?php echo e(the_sub_field('email')); ?></a>
                  </p>
                  <div class="contacts-list__name">
                    <strong><?php echo e(the_sub_field('name')); ?></strong><span class="contacts-list__name-separator">|</span><?php echo e(the_sub_field('role')); ?>

                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-lg-6 contact-form">
        <?php 
          $form = get_field('contact_form');
          $shortcode = '[contact-form-7 id="' . $form->ID .'" title="' . $form->post_title . '"]';
          echo do_shortcode( $shortcode );
         ?>
      </div>
    </div>
  </div>
<?php echo $__env->renderComponent(); ?>
