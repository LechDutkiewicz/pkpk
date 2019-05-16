<!doctype html>
<html <?php (language_attributes()); ?>>
  <?php echo $__env->make('partials.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <body <?php (body_class()); ?>>
    <div id="app">
      <?php (do_action('get_header')); ?>
      <?php echo $__env->make('partials.header-shop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <div class="content content--app">
        <main class="main">
          <?php if(have_posts()): ?>
            <?php while(have_posts()): ?> <?php (the_post()); ?>
              <?php $__env->startComponent('components.skewy-container', ['variant' => 'white']); ?>
                <div class="container">
                  <div class="row justify-content-center no-gutters">
                    <?php $__env->startComponent('components.shadow-box', ['variant' => 'white', 'col' => 'md-10 col-lg-8 shop-content shop-content--app']); ?>
                      <div class="container--flex justify-content-center container--full-width">
                        <div class="col-sm-10">
                          <?php echo $__env->yieldContent('content'); ?>
                        </div>
                      </div>
                    <?php echo $__env->renderComponent(); ?>
                  </div>
                </div>
              <?php echo $__env->renderComponent(); ?>
            <?php endwhile; ?>
          <?php else: ?>
            <?php $__env->startComponent('components.skewy-container', ['variant' => 'white']); ?>
              <div class="container">
                <div class="row justify-content-center no-gutters">
                  <?php $__env->startComponent('components.shadow-box', ['variant' => 'white', 'col' => 'md-10 col-lg-8 shop-content shop-content--app']); ?>
                    <div class="container--flex justify-content-center container--full-width">
                      <div class="col-sm-10">
                        <?php echo $__env->yieldContent('content'); ?>
                      </div>
                    </div>
                  <?php echo $__env->renderComponent(); ?>
                </div>
              </div>
            <?php echo $__env->renderComponent(); ?>
          <?php endif; ?>
        </main>
      </div>
      <?php (do_action('get_footer')); ?>
    </div>
    <?php (wp_footer()); ?>
  </body>
</html>
