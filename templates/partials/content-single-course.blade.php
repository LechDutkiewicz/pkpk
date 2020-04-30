@php
  $course = new App\Course();
  $is_over = $course->isOver();
@endphp

<div class="container container--padding">
  <div class="row">
    <div class="col-xs-12 col-md-8 col-lg-9 content--app__main">
      <h1 class="content--app__heading">
        {{ __('Twoje lekcje', 'pkpk') }}
        @if ($is_over)
          <span> - {{ __('kurs zakończony', 'pkpk') }}</span>
        @endif
      </h1>
      @component('components.shadow-box', ['variant' => 'white', 'row' => false])
        @include('partials/course/lessons')
      @endcomponent
    </div>
    <div class="col-xs-12 col-md-4 col-lg-3 content--app__sidebar">
      <div class="theiaStickySidebar">
        @include('partials/course/progress')
        @include('partials/course/lessons-list')
      </div>
    </div>
  </div>
</div>
