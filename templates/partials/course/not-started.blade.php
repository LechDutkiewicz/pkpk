@php
  $course = new App\Course();
  $date_format = get_field('course_start', $course->id, true);
  $date_raw = get_field('course_start', $course->id, false);
  $date_raw = new DateTime($date_raw);
@endphp

@component('components.alert')
  @slot('icon')
    <i class="zmdi zmdi-time-countdown"></i>
  @endslot
  @slot('title')
    {{ __('Kurs Produktywności', 'pkpk') }}
  @endslot
  @slot('subtitle')
    {{ __('Program rozpocznie się', 'pkpk') }} <strong>{{ $date_format . ' o ' . $date_raw->format('G:i') }}</strong>.
  @endslot
  @slot('buttons')
    <a href="{{ home_url() }}" class="btn btn--border-secondary btn--large btn--full-width">{{ __('Wróć do strony głównej', 'pkpk') }}</a>
  @endslot
  <p>{{ __('Gdybyś miał/a jakieś pytania,', 'pkpk') }} <a href="mailto:kontakt@produktywnosckrokpokroku.pl">{{ __('napisz do mnie', 'pkpk') }}</a>.</p>
@endcomponent
