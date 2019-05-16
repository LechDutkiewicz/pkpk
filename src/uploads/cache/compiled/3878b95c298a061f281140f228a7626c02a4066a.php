<?php 
  $user = wp_get_current_user();
  $course = new App\Course();
  $course_path = $course->getPath();
 ?>

<header id="main-header" class="banner banner--landing" :class="bannerClass">
  <div class="container container--flex justify-content-between container--padding">

    <a class="brand" href="<?php echo e(home_url('/')); ?>">
      <?php echo $__env->make('partials.logo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </a>

    <button @click="hamburger" id="open-mobile-nav" class="hamburger hamburger--3dy hidden-lg-up" :class="{ 'is-active': navOpen }" type="button">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
    </button>

    <nav class="nav-primary" @click="hamburger">
      <?php if(has_nav_menu('primary_navigation')): ?>
        <?php echo wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']); ?>

      <?php endif; ?>
    </nav>

    <nav class="nav-cta">
      <ul class="nav">
        <?php if( !is_user_logged_in() ): ?>
          <li><a href="<?php echo e(wp_login_url($course_path)); ?>" class="btn--login"><?php echo e(esc_html__('Zaloguj się', 'pkpk')); ?></a></li>
          <li><a href="#cennik" class="btn btn--bg-transparent btn--border-white scroll-to-btn"><?php echo e(esc_html__('Zapisz się', 'pkpk')); ?></a></li>
        <?php else: ?>
          <li class="banner__profile has-sub-menu">
            <a href="<?php echo e(get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id); ?>">
              <span class="banner__user-hello"><?php echo e(__('Witaj', 'pkpk')); ?></span>
              <?php if(!empty($user->user_firstname)): ?>
                <span class="banner__user-name"><?php echo e($user->user_firstname); ?></span>
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
          <li><a href="<?php echo e($course_path); ?>" class="btn btn--bg-transparent btn--border-white"><?php echo e(esc_html__('Przejdź do kursu', 'pkpk')); ?> <i class="zmdi zmdi-arrow-right"></i></a></li>
        <?php endif; ?>
      </ul>
    </nav>

  </div>
</header>
