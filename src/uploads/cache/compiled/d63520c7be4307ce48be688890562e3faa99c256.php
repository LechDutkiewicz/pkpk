<?php $__env->startSection('content'); ?>
  <?php 
  echo pkpk_checkout_form();
   ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>