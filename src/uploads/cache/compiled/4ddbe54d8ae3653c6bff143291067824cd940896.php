<?php $__env->startSection('content'); ?>
  <?php  global $post  ?>

  <h2 class="std-heading"><?php echo e(__('Ustaw nowe hasło', 'pkpk' )); ?></h2>
  <div class="std-content"><?php echo e(__('Wpisz nowe hasło poniżej', 'pkpk')); ?></div>

  <?php 
  theme_my_login( array('default_action' => 'resetpass', 'show_title' => false) );
   ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>