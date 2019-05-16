<!doctype html>
<html <?php (language_attributes()); ?>>
  <?php echo $__env->make('partials.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <body <?php (body_class()); ?>>
    <div id="app">
      <?php (do_action('get_header')); ?>
      <?php echo $__env->make('partials.header-shop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <div class="content">
        <main class="main">
          <?php echo $__env->yieldContent('content'); ?>
        </main>
      </div>
      <?php (do_action('get_footer')); ?>
    </div>
    <?php (wp_footer()); ?>
  </body>
</html>
