@php
global $post;
$user = wp_get_current_user();
$course = new App\Course();
$lesson = new App\Lesson();
$courses = $course->getUserCourses();
@endphp

<header class="banner banner--app" :class="bannerClass">
  <div class="main-header">
    <div class="container container--padding">
      <div class="row align-items-center">
        <div class="d-flex align-items-center">
          <a class="brand" href="{{ home_url('/') }}">
            @include('partials.logo')
          </a>
        </div>

        <button @click="hamburger" id="open-mobile-nav" class="hamburger hamburger--3dy hidden-md-up d-md-none" :class="{ 'is-active': navOpen }" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>

        @if (count($courses) > 1)
        <nav class="nav-app">
          <ul class="d-flex justify-content-end">
            <li class="has-sub-menu left-separator banner--app__course-name">
              <a href="{!! the_permalink($course->id) !!}">
                {{ __('Kurs', 'pkpk') }} {{ the_field('course_start', $course->id) }}
                <i class="zmdi zmdi-chevron-down"></i>
              </a>

              <div class="sub-menu">
                <ul>
                  @for ($i=0; $i < count($courses); $i++)
                  @if ($courses[$i] != $course->id )
                  <li><a class="sub-menu__item" href="{!! the_permalink($courses[$i]) !!}">{{ the_field('course_start', $courses[$i]) }}</a></li>
                  @endif
                  @endfor
                </ul>
              </div>
            </li>
          </ul>
        </nav>
        @else
        <a class="banner--app__course-name hidden-sm-down" href="{!! the_permalink($course->id) !!}">
          {{ __('Kurs', 'pkpk') }} {{ the_field('course_start', $course->id) }}
        </a>
        @endif

        <nav class="nav-app nav-app--controls">
          <ul class="d-flex justify-content-end">
            <li><a href="{{ $course->getPath() }}">{{ __('Strona kursu', 'pkpk') }}</a></li>
            <li class="d-md-none"><a href="{{ get_permalink( get_page_by_title( 'Raporty' ) ) . $course->id }}">{{ __('Moje raporty', 'pkpk') }}</a></li>
            <li class="banner__profile has-sub-menu">
              <a class="btn btn--course-pro" href="{{ get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id  }}">
                <span class="banner__user-hello">{{ __('Witaj', 'pkpk') }}</span>
                @if (!empty($user->user_firstname))
                <span class="banner__user-name">{{ $user->user_firstname }}</span>
                @endif
                @if (!empty($user->user_lastname))
                <span class="banner__user-name">{{ $user->user_lastname }}</span>
                @endif
                @if (empty($user->user_firstname) && empty($user->user_lastname))
                <span class="banner__user-name">{{ $user->user_nicename }}</span>
                @endif
                <i class="zmdi zmdi-chevron-down h-bd"></i>
              </a>
              <div class="sub-menu">
                <ul>
                  <li class="d-none d-md-block"><a class="sub-menu__item" href="{{ get_permalink( get_page_by_title( 'Raporty' ) ) . $course->id }}">{{ __('Moje raporty') }}<i class="zmdi zmdi-format-line-spacing"></i></a></li>
                  <li><a class="sub-menu__item" href="{{ get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id }}">{{ __('Ustawienia') }}<i class="zmdi zmdi-settings"></i></a></li>
                  <li class="sub-menu__log-out"><a class="sub-menu__item" href="{{ wp_logout_url() }}">{{ __('Wyloguj się') }}<i class="zmdi zmdi-sign-in"></i></a></li>
                </ul>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    @php
    $args = [
    'post_type' => 'lesson',
    'post_parent' => $course->id,
    'order' => 'DESC',
    ];

    $lessons_query = new WP_Query($args);
    $i = $lessons_query->post_count;

    @endphp

    <div class="banner__lessons-list d-md-none" :class="{ 'is-open': lessonsOpen, 'hidden': !lessonsList }">
      <div class="banner__lessons-list__heading" @click="openLessons">
        <div class="container d-flex justify-content-between align-items-center" v-if="!lessonsOpen">
          <h3><strong>{{ $lesson->currentNumber() + 1 }}.</strong> {{ the_title() }}</h3>
          <i class="zmdi zmdi-chevron-down"></i>
        </div>
        <div class="container d-flex justify-content-between align-items-center" v-if="lessonsOpen">
          <h3>{{ __('Twoje lekcje', 'pkpk' )}}</h3>
          <i class="zmdi zmdi-close"></i>
        </div>
      </div>
      <nav>
        <ul class="container">
          @query($args)
          @if($lesson_id == get_the_ID())
          <li class="active">
            <span class="c-lessons-list__counter">{{ $i }}</span>
            {{ the_title() }}
          </li>
          @else
          <li>
            <a href="{{ the_permalink() }}">
              <span class="c-lessons-list__counter">{{ $i }}</span>
              {{ the_title() }}
            </a>
          </li>
          @endif
          @php($i--)
          @endquery
        </ul>
      </nav>
    </div>

    @php(wp_reset_postdata())

  </div>
</header>
