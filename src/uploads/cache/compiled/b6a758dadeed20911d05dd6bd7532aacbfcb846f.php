<?php 
  $course = new App\Course();
  $has_access = $course->hasAccess();
  $is_started = $course->isStarted();
 ?>



<?php $__env->startSection('content'); ?>
  <?php if($has_access): ?>
    <?php if($is_started): ?>
      <?php while(have_posts()): ?> <?php (the_post()); ?>
        <?php echo $__env->make('partials/content-single-'.get_post_type(), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php endwhile; ?>
    <?php else: ?>
      <?php echo $__env->make('partials/course/not-started', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
  <?php else: ?>
    <?php echo $__env->make('partials/course/not-access', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(!$has_access ? 'layouts/shop' : ($is_started ? 'layouts/base/course' : 'layouts/base/app-logged-in'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>