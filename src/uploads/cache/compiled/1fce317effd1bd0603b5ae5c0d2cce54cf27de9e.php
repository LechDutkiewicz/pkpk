<?php $__env->startSection('content'); ?>
  <?php  global $post  ?>

  <h2 class="std-heading"><?php echo e(__('Nie pamiętasz hasła?', 'pkpk' )); ?></h2>
  <div class="std-content"><?php  echo $post->post_content  ?></div>

  <?php 
  echo do_shortcode('[theme-my-login show_title=0 default_action="lostpassword"]');
   ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/base/app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>