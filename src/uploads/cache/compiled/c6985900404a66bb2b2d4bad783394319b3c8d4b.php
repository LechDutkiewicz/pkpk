<?php 
  global $post;
  $user = wp_get_current_user();
  $course = new App\Course();
  // $course_path = $course->getPath($course->getActiveCourse());
  $course_path = get_permalink($course->id);
  $courses = $course->getUserCourses();
 ?>

<header class="banner banner--shop banner--app-in">
  <div class="container container--flex justify-content-center">
    <div class="col-md-10 col-lg-9 col-xl-8">
      <div class="row justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <a class="brand" href="<?php echo e(home_url('/')); ?>">
            <?php echo $__env->make('partials.logo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </a>

          <?php if(count($courses) > 1): ?>
            <nav class="nav-app hidden-md-down">
              <ul class="d-flex justify-content-end">
                <li class="has-sub-menu left-separator banner--app__course-name">
                  <a href="<?php echo the_permalink($course->id); ?>">
                    <?php echo e(__('Kurs', 'pkpk')); ?> <?php echo e(the_field('course_start', $course->id)); ?>

                    <i class="zmdi zmdi-chevron-down"></i>
                  </a>

                  <div class="sub-menu">
                    <ul>
                      <?php for($i=0; $i < count($courses); $i++): ?>
                        <?php if($courses[$i] != $course->id ): ?>
                          <li><a href="<?php echo the_permalink($courses[$i]); ?>"><?php echo e(the_field('course_start', $courses[$i])); ?></a></li>
                        <?php endif; ?>
                      <?php endfor; ?>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          <?php else: ?>
            <a class="banner--app__course-name d-sm-none" href="<?php echo the_permalink($course->id); ?>">
              <?php echo e(__('Kurs', 'pkpk')); ?> <?php echo e(the_field('course_start', $course->id)); ?>

            </a>
          <?php endif; ?>
        </div>

        <nav class="nav-cta hidden-md-down">
          <ul class="nav">
            <?php if( !is_user_logged_in() ): ?>
              <li><a href="<?php echo e(wp_login_url()); ?>" class="btn--login"><?php echo e(esc_html__('Zaloguj się', 'pkpk')); ?></a></li>
              <li><a href="#cennik" class="btn btn--bg-transparent btn--border-white scroll-to-btn"><?php echo e(esc_html__('Zapisz się', 'pkpk')); ?></a></li>
            <?php else: ?>
              <li class="banner__profile has-sub-menu">
                <a href="<?php echo e(get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id); ?>">
                  <span class="banner__user-hello"><?php echo e(__('Witaj', 'pkpk')); ?></span>
                  <?php if(!empty($user->user_firstname)): ?>
                    <span class="banner__user-name"><?php echo e($user->user_firstname); ?></span>
                  <?php endif; ?>
                  <?php if(!empty($user->user_lastname)): ?>
                    <span class="banner__user-name"><?php echo e($user->user_lastname); ?></span>
                  <?php endif; ?>
                  <?php if(empty($user->user_firstname) && empty($user->user_lastname)): ?>
                    <span class="banner__user-name"><?php echo e($user->user_nicename); ?></span>
                  <?php endif; ?>
                  <i class="zmdi zmdi-chevron-down"></i>
                </a>
                <div class="sub-menu">
                  <ul>
                    <li><a href="<?php echo e($course_path); ?>"><?php echo e(__('Moje lekcje')); ?><i class="zmdi zmdi-edit"></i></a></li>
                    <li><a href="<?php echo e(get_permalink( get_page_by_title( 'Raporty' ) ) . $course->id); ?>"><?php echo e(__('Moje raporty')); ?><i class="zmdi zmdi-format-line-spacing"></i></a></li>
                    <li><a href="<?php echo e(get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id); ?>"><?php echo e(__('Ustawienia')); ?><i class="zmdi zmdi-settings"></i></a></li>
                    <li class="sub-menu__log-out"><a href="<?php echo e(wp_logout_url()); ?>"><?php echo e(__('Wyloguj się')); ?><i class="zmdi zmdi-sign-in"></i></a></li>
                  </ul>
                </div>
              </li>
              <?php if('ustawienia' === $post->post_name): ?>
                <li><a href="<?php echo e($course_path); ?>" class="btn btn--bg-transparent btn--border-white"><?php echo e(esc_html__('Przejdź do kursu', 'pkpk')); ?> <i class="zmdi zmdi-arrow-right"></i></a></li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </nav>

        <?php if('ustawienia' === $post->post_name): ?>
          <a href="<?php echo e($course_path); ?>" class="btn btn--bg-transparent btn--border-white hidden-lg-up"><?php echo e(esc_html__('Przejdź do kursu', 'pkpk')); ?> <i class="zmdi zmdi-arrow-right"></i></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>
