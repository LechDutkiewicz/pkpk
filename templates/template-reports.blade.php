{{--
  Template Name: Reports Template
--}}

@php
  $course = new App\Course();
  $has_access = $course->hasAccess();
  $is_started = $course->isStarted();
  $is_over = $course->isOver();
@endphp

@extends(!$has_access ? 'layouts/shop' : ($is_started ? 'layouts/base/course' : 'layouts/base/app-logged-in'))

@section('content')
  @if ($has_access)
    @if ($is_started)
      @while(have_posts()) @php(the_post())
        <div class="container container--padding">
          <div class="row">
            <div class="col-xs-12 col-md-9 content--app__main">
              <h1 class="content--app__heading">
                {{ __('Twoje raporty', 'pkpk') }}
                @if ($is_over)
                  <span> - {{ __('kurs zakończony', 'pkpk') }}</span>
                @endif
              </h1>
              @component('components.shadow-box', ['variant' => 'white', 'row' => false])
                @include('partials/course/reports')
              @endcomponent
            </div>
            <div class="col-xs-12 col-md-3 content--app__sidebar">
              @include('partials/course/progress')
              @include('partials/course/lessons-list')
            </div>
          </div>
        </div>
      @endwhile
    @else
      @include('partials/course/not-started')
    @endif
  @else
    @include('partials/course/not-access')
  @endif
@endsection
