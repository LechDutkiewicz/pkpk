@php
  global $post;
  $course = new App\Course();

  $args = [
    'post_type' => 'lesson',
    'post_parent' => $course->id,
    'order' => 'ASC',
  ];

  $lesson_id = $post->ID;

  $i = 1;
@endphp

@haveposts($args)
<div class="c-lessons-list">
  <h3 class="c-lessons__heading sidebar-heading">{{ __('Spis treści', 'pkpk') }}</h3>
  <ul class="c-lessons-list__list">
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
      @php($i++)
    @endquery
    <li class="c-lessons-list__last-item"></li>
    @php(wp_reset_postdata())
  </ul>
</div>
@endhaveposts
