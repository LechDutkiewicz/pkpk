@php
  $course = new App\Course();
  $courses = $course->getUserCourses();
@endphp

@component('components.alert')
  @slot('icon')
    !
  @endslot
  @if ( !is_user_logged_in() )
    @slot('title')
      {{ __('Zaloguj się', 'pkpk') }}
    @endslot
    @slot('subtitle')
      {{ __('Aby mieć dostęp do treści kursu, musisz się zalogować.', 'pkpk') }}
    @endslot
    @slot('buttons')
      <a href="{{ wp_login_url( get_the_permalink() ) }}" class="btn btn--secondary btn--large btn--full-width">{{ __('Zaloguj się', 'pkpk') }}</a>
      <a href="{{ wp_lostpassword_url( get_the_permalink() ) }}" class="btn btn--border-secondary btn--large btn--full-width">{{ __('Przypomnij hasło', 'pkpk') }}</a>
    @endslot

    <p>Aby mieć dostęp do treści kursu, musisz się zalogować. Jeśli nie pamiętasz hasła - użyj funkcji przypomnienia. A jeśli jeszcze nie zakupiłeś kursu to zapraszam Cię na <a href="{{ home_url('/') }}">stronę główną</a>, gdzie możesz zapoznać się z informacjami na jego temat i dokonać zakupu.</p>
  @else
    @slot('title')
      {{ __('Ups!', 'pkpk') }}
    @endslot
    @slot('subtitle')
      {{ __('Nie masz dostępu do tej edycji kursu.', 'pkpk') }}
    @endslot
    @slot('buttons')
      <a href="{{ home_url('/') }}" class="btn btn--secondary btn--large btn--full-width">{{ __('Wróć do strony głównej', 'pkpk') }}</a>
    @endslot

    <p>Prawdopodobnie posiadasz link do niewłaściwej edycji kursu. Poniżej znajdziesz listę kursów, które są dostępne dla Twojego konta:</p>

    @if (count($courses) > 1)
      <ul>
        @for ($i=0; $i < count($courses); $i++)
          @if ($courses[$i] != $course->id )
            <li><a href="{!! the_permalink($courses[$i]) !!}">{{ the_field('course_start', $courses[$i]) }}</a></li>
          @endif
        @endfor
      </ul>
    
    @else
      <ul>
        <li>
          <a href="{!! the_permalink($course->id) !!}">
        {{ __('Kurs', 'pkpk') }} {{ the_field('course_start', $course->id) }}
          </a>
        </li>
      </ul>

    @endif

  @endif

@endcomponent
