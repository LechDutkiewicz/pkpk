<?php $__env->startComponent('components.bg-section', ['variant' => 'lightblue', 'id' => 'faq', 'image' => false]); ?>
  <div class="container container--faq container--padding">
    <h2 class="std-heading std-heading--full-width std-heading--faq">Najczęściej zadawane pytania</h2>

    <?php if(have_rows('faq')): ?>
      <div class="faq row">
          <?php while(have_rows('faq')): ?> <?php (the_row()); ?>
            <div class="faq__item col-md-6">
              <div class="faq__icon">
                <i class="zmdi zmdi-help-outline"></i>
              </div>
              <div class="faq__content">
                <p class="faq__question">
                  <?php echo e(the_sub_field('faq_question')); ?>

                </p>
                <div class="faq__answer">
                  <?php echo e(the_sub_field('faq_answer')); ?>

                </div>
              </div>
            </div>
          <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
<?php echo $__env->renderComponent(); ?>
