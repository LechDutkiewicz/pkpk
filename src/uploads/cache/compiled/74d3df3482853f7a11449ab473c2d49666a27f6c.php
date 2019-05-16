<?php 
  // Clear cart before any action
  //eddcc_process_clear_cart();
  do_action('pkpk_before_home_content');
 ?>

<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php (the_post()); ?>
    <?php echo $__env->make('partials.page-hero', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.course-details', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.course-steps', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.course-program', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.testimonials', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.author-section', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.course-pricelist', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.faq', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.contact', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>