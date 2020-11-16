@php
  $lesson = new App\Lesson();
  $has_access = $lesson->hasAccess();
  $is_started = $lesson->isStarted();
  $user = wp_get_current_user();
  $active = !in_array( 'inactive_subscriber', (array) $user->roles );
  $privacy_accepted = esc_attr( get_the_author_meta( "accept_privacy", $user->ID ) ) == "yes" ? true : false;
@endphp

@extends(!$has_access || !$active ? 'layouts/shop' : ($is_started ? 'layouts/base/lesson' : 'layouts/base/app-logged-in'))

@section('content')
  @if ($has_access)
    @if ($is_started)
      @if ($privacy_accepted)
        @if($active)
          @while(have_posts()) @php(the_post())
            @include('partials/content-single-'.get_post_type())
          @endwhile
        @else
          @include('partials/course/not-active')
        @endif        
      @else
        @include('partials/course/privacy-not-accepted')
      @endif
    @else
      @include('partials/course/not-started')
    @endif
  @else
    @include('partials/course/not-access')
  @endif
@endsection
