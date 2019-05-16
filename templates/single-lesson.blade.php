@php
  $lesson = new App\Lesson();
  $has_access = $lesson->hasAccess();
  $is_started = $lesson->isStarted();
  $user = wp_get_current_user();
  $user = wp_get_current_user();
  $active = !in_array( 'inactive_subscriber', (array) $user->roles );
@endphp

@extends(!$has_access || !$active ? 'layouts/shop' : ($is_started ? 'layouts/base/lesson' : 'layouts/base/app-logged-in'))

@section('content')
  @if ($has_access)
    @if ($is_started)
      @if($active)
        @while(have_posts()) @php(the_post())
          @include('partials/content-single-'.get_post_type())
        @endwhile
      @else
        @include('partials/course/not-active')
      @endif
    @else
      @include('partials/course/not-started')
    @endif
  @else
    @include('partials/course/not-access')
  @endif
@endsection
