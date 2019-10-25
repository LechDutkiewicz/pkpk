@php
  $course = new App\Course();
  $count = $course->getUserProgress();
  $is_over = $course->isOver();
  $cert_url = $course->getCertificateUrl();
@endphp

<div class="c-progress">
  <h3 class="c-progress__heading sidebar-heading">
    @if ($is_over)
      {{ __('Kurs ukończony na:', 'pkpk') }}
    @else
      {{ __('Twój postęp w kursie', 'pkpk') }}
    @endif
  </h3>
  <h2 class="c-progress__number">{{ $count }}%</h2>
  <div class="c-progress__bar">
    <div style="width: {{ $count }}%"></div>
  </div>
  <a href="{{ get_permalink( get_page_by_title( 'Raporty' ) ) . $course->id }}" class="btn btn--border-secondary btn--large btn--full-width">{{ __('Zobacz swoje raporty', 'pkpk') }}</a>
  @if(get_field('course_cert_allowed', $course->id))
    <a href="{{ $cert_url }}" class="btn btn--green btn--large btn--full-width">{{ __('Certyfikat ukończenia', 'pkpk') }}</a>
  @endif
</div>
