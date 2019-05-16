<?php (the_content()); ?>

<?php $__env->startSection('content'); ?>
  <?php  global $post  ?>

  <h2 class="std-heading"><?php echo e($post->post_title); ?></h2>
  <div class="std-content"><?php  echo $post->post_content  ?></div>

  <?php 
  //theme_my_login( array('default_action' => 'profile', 'show_title' => false) );
  echo do_shortcode('[theme-my-login default_action="profile" show_title=0]');
  //echo do_shortcode('[theme-my-login]');
   ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/base/app-logged-in', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>