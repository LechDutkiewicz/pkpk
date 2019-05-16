<?php $__env->startSection('content'); ?>
  <?php $__env->startComponent('components.alert'); ?>
    <?php $__env->slot('icon'); ?>
      <i class="icon ion-information"></i>
    <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?>
      <?php echo e(__('Historia Zamówień', 'pkpk')); ?>

    <?php $__env->endSlot(); ?>
    <?php $__env->slot('subtitle'); ?>
      <?php echo e(__('Wszystkie Twoje Zamówienia.', 'pkpk')); ?>

    <?php $__env->endSlot(); ?>
    <?php $__env->slot('buttons'); ?>
      <a href="<?php echo e(home_url('/')); ?>" class="btn btn--border-secondary btn--large btn--full-width"><?php echo e(__('Wróć na stronę główną', 'pkpk')); ?></a>
    <?php $__env->endSlot(); ?>

    <?php 
    echo do_shortcode('[purchase_history]');
     ?>
  <?php echo $__env->renderComponent(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>