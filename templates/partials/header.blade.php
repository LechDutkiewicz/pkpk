@php
  $user = wp_get_current_user();
  $course = new App\Course();
  $course_path = $course->getPath();
@endphp

<header id="main-header" class="banner banner--landing" :class="bannerClass">
  <div class="container container--flex justify-content-between container--padding">

    <a class="brand" href="{{ home_url('/') }}">
      @include('partials.logo')
    </a>

    <button @click="hamburger" id="open-mobile-nav" class="hamburger hamburger--3dy d-lg-none" :class="{ 'is-active': navOpen }" type="button">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
    </button>

    <nav class="nav-primary" @click="hamburger">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>

    <nav class="nav-cta">
      <ul class="nav">
        @if ( !is_user_logged_in() )
          <li><a href="{{ wp_login_url($course_path) }}" class="btn--login">{{ esc_html__('Zaloguj się', 'pkpk') }}</a></li>
          <li><a href="#cennik" class="btn btn--bg-transparent btn--border-white scroll-to-btn">{{ esc_html__('Zapisz się', 'pkpk') }}</a></li>
        @else
          <li class="banner__profile has-sub-menu">
            <a href="{{ get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id  }}">
              <span class="banner__user-hello">{{ __('Witaj', 'pkpk') }}</span>
              @if (!empty($user->user_firstname))
                <span class="banner__user-name">{{ $user->user_firstname }}</span>
              @endif
              @if (empty($user->user_firstname) && empty($user->user_lastname))
                <span class="banner__user-name">{{ $user->user_nicename }}</span>
              @endif
              <i class="zmdi zmdi-chevron-down"></i>
            </a>
            <div class="sub-menu">
              <ul>
                <li><a class="sub-menu__item" href="{{ get_permalink( get_page_by_title( 'Raporty' ) ) . $course->id }}">{{ __('Moje raporty') }}<i class="zmdi zmdi-format-line-spacing"></i></a></li>
                <li><a class="sub-menu__item" href="{{ get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id }}">{{ __('Ustawienia') }}<i class="zmdi zmdi-settings"></i></a></li>
                <li class="sub-menu__log-out"><a class="sub-menu__item" href="{{ wp_logout_url() }}">{{ __('Wyloguj się') }}<i class="zmdi zmdi-sign-in"></i></a></li>
              </ul>
            </div>
          </li>
          <li><a href="{{ $course_path }}" class="btn btn--course-pro">{{ esc_html__('Przejdź do kursu', 'pkpk') }} <i class="zmdi zmdi-arrow-right"></i></a></li>
        @endif
      </ul>
    </nav>

  </div>
</header>
