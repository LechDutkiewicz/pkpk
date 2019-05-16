<?php $__env->startSection('content'); ?>

  <?php if( !empty($_GET["payment_key"]) ): ?>

    <?php $__env->startComponent('components.alert'); ?>
      <?php $__env->slot('icon'); ?>
        <i class="zmdi zmdi-check"></i>
      <?php $__env->endSlot(); ?>
      <?php $__env->slot('title'); ?>
        <?php echo e(__('Potwierdzenie zamówienia', 'pkpk')); ?>

      <?php $__env->endSlot(); ?>

      <?php $__env->slot('buttons'); ?>
        <a href="<?php echo e(home_url()); ?>" class="btn btn--border-secondary btn--full-width btn--large">Wróć do strony głównej</a>
      <?php $__env->endSlot(); ?>

      <?php 
      echo do_shortcode('[edd_receipt]');
       ?>
    <?php echo $__env->renderComponent(); ?>

  <?php else: ?>
    <?php $__env->startComponent('components.alert'); ?>
      <?php $__env->slot('icon'); ?>
        <i class="zmdi zmdi-check"></i>
      <?php $__env->endSlot(); ?>
      <?php $__env->slot('title'); ?>
        <?php echo e(__('Dziękujemy', 'pkpk')); ?>

      <?php $__env->endSlot(); ?>
      <?php $__env->slot('subtitle'); ?>
        <?php echo e(__('Płatność została zrealizowana pomyślnie', 'pkpk')); ?>

      <?php $__env->endSlot(); ?>
      <?php $__env->slot('buttons'); ?>
        <a href="<?php echo e(home_url()); ?>" class="btn btn--border-secondary btn--full-width btn--large">Wróć do strony głównej</a>
      <?php $__env->endSlot(); ?>

      <p>Kilka dni przed rozpoczęciem programu, dostaniesz maila ze wskazówkami. Potwierdzenie tej transakcji już powinieneś/naś mieć na swojej skrzynce mailowej.</p>
      <p>Gdybyś miał/a jakieś pytania, <a href="mailto:kontakt@produktywnosckrokpokroku.pl">napisz do mnie.</a></p>
    <?php echo $__env->renderComponent(); ?>
  <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>