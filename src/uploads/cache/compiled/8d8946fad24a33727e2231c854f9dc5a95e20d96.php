<?php $__env->startSection('content'); ?>
  <?php 
    global $post
   ?>
  <?php $__env->startComponent('components.alert'); ?>
    <?php $__env->slot('title'); ?>
      <?php echo e(__('Wysłaliśmy Ci wiadomość!', 'pkpk')); ?>

    <?php $__env->endSlot(); ?>
    <?php $__env->slot('subtitle'); ?>
      <?php echo e(__('Sprawdź swoją skrzynkę e-mail.', 'pkpk')); ?>

    <?php $__env->endSlot(); ?>
    <?php $__env->slot('buttons'); ?>
      <a href="<?php echo e(home_url('/')); ?>" class="btn btn--border-secondary btn--large btn--full-width"><?php echo e(__('Wróć na stronę główną', 'pkpk')); ?></a>
    <?php $__env->endSlot(); ?>

    <?php  echo $post->post_content  ?>
    <p><a href="<?php echo e(wp_login_url(false)); ?>"><?php echo e(__('Jeśli jednak pamiętasz hasło, wróć do logowania', 'pkpk')); ?></a></p>
  <?php echo $__env->renderComponent(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/base/app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>