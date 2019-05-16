<header class="banner" id="main-header" :class="bannerClass">
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
          <li><a href="<?php echo e(wp_login_url()); ?>" class="btn--login"><?php echo e(esc_html__('Zaloguj się', 'pkpk')); ?></a></li>
        <?php else: ?>
          <li><a href="<?php echo e(wp_logout_url('/')); ?>" class="btn--login"><?php echo e(esc_html__('Wyloguj się', 'pkpk')); ?></a></li>
        <?php endif; ?>
        <li><a href="#cennik" class="btn btn--bg-transparent btn--border-white scroll-to-btn"><?php echo e(esc_html__('Zapisz się', 'pkpk')); ?></a></li>
      </ul>
    </nav>

  </div>
</header>
