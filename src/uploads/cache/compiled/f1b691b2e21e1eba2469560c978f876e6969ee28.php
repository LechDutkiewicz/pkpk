<!doctype html>
<html <?php (language_attributes()); ?>>
  <?php echo $__env->make('partials.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <body <?php (body_class()); ?>>
    <?php (do_action('get_header')); ?>
    <div id="app">
      <?php echo $__env->make('partials.headers.lesson', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <div class="content content--app">
        <main class="main">
          <?php if(have_posts()): ?>
            <?php while(have_posts()): ?> <?php (the_post()); ?>
              <?php $__env->startComponent('components.skewy-container', ['variant' => 'white']); ?>
                <?php echo $__env->yieldContent('content'); ?>
              <?php echo $__env->renderComponent(); ?>
            <?php endwhile; ?>
          <?php endif; ?>
        </main>
      </div>
      <?php (do_action('get_footer')); ?>
      <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php (wp_footer()); ?>
  </body>
</html>
