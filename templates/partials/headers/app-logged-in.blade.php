@php
  global $post;
  $user = wp_get_current_user();
  $course = new App\Course();
  // $course_path = $course->getPath($course->getActiveCourse());
  $course_path = get_permalink($course->id);
  $courses = $course->getUserCourses();
@endphp

<header class="banner banner--shop banner--app-in">
  <div class="container container--flex justify-content-center">
    <div class="col-md-10 col-lg-9 col-xl-8">
      <div class="row justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <a class="brand" href="{{ home_url('/') }}">
            @include('partials.logo')
          </a>

          @if (count($courses) > 1)
            <nav class="nav-app hidden-md-down d-md-none">
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
                          <li><a href="{!! the_permalink($courses[$i]) !!}">{{ the_field('course_start', $courses[$i]) }}</a></li>
                        @endif
                      @endfor
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          @else
            <a class="banner--app__course-name hidden-md-down d-md-none" href="{!! the_permalink($course->id) !!}">
              {{ __('Kurs', 'pkpk') }} {{ the_field('course_start', $course->id) }}
            </a>
          @endif
        </div>

        <nav class="nav-cta d-lg-none">
          <ul class="nav">
            @if ( !is_user_logged_in() )
              <li><a href="{{ wp_login_url() }}" class="btn--login">{{ esc_html__('Zaloguj się', 'pkpk') }}</a></li>
              <li><a href="#cennik" class="btn btn--bg-transparent btn--border-white scroll-to-btn">{{ esc_html__('Zapisz się', 'pkpk') }}</a></li>
            @else
              <li class="banner__profile has-sub-menu">
                <a href="{{ get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id  }}">
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
                  <i class="zmdi zmdi-chevron-down"></i>
                </a>
                <div class="sub-menu">
                  <ul>
                    <li><a href="{{ $course_path }}">{{ __('Moje lekcje') }}<i class="zmdi zmdi-edit"></i></a></li>
                    <li><a href="{{ get_permalink( get_page_by_title( 'Raporty' ) ) . $course->id }}">{{ __('Moje raporty') }}<i class="zmdi zmdi-format-line-spacing"></i></a></li>
                    <li><a href="{{ get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id  }}">{{ __('Ustawienia') }}<i class="zmdi zmdi-settings"></i></a></li>
                    <li class="sub-menu__log-out"><a href="{{ wp_logout_url() }}">{{ __('Wyloguj się') }}<i class="zmdi zmdi-sign-in"></i></a></li>
                  </ul>
                </div>
              </li>
              @if ('ustawienia' === $post->post_name)
                <li><a href="{{ $course_path }}" class="btn btn--bg-transparent btn--border-white">{{ esc_html__('Przejdź do kursu', 'pkpk') }} <i class="zmdi zmdi-arrow-right"></i></a></li>
              @endif
            @endif
          </ul>
        </nav>

        @if ('ustawienia' === $post->post_name)
          <a href="{{ $course_path }}" class="btn btn--bg-transparent btn--border-white hidden-lg-up">{{ esc_html__('Przejdź do kursu', 'pkpk') }} <i class="zmdi zmdi-arrow-right"></i></a>
        @endif
      </div>
    </div>
  </div>
</header>
