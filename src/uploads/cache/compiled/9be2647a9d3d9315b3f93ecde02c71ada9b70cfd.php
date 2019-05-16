<div class="container container--padding">
  <div class="row">
    <div class="col-md-8 col-lg-9 content--app__main">
      <h1 class="content--app__heading"><?php echo e(__('Twoje lekcje', 'pkpk')); ?></h1>
      <?php $__env->startComponent('components.shadow-box', ['variant' => 'white', 'row' => false]); ?>
        <?php echo $__env->make('partials/course/lessons', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php echo $__env->renderComponent(); ?>
      <!--<div class="c-lessons-more">
        <a href="#" class="btn btn--border-light-green btn--large btn--full-width"><?php echo e(__('Załaduj poprzednie lekcje', 'pkpk')); ?></a>
      </div>-->
    </div>
    <div class="col-md-4 col-lg-3 content--app__sidebar">
      <div class="theiaStickySidebar">
        <?php echo $__env->make('partials/course/progress', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials/course/lessons-list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
    </div>
  </div>
</div>
