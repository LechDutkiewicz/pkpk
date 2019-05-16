@extends('layouts.shop')

@section('content')

  @if (!have_posts())
    @component('components.alert')
      @slot('icon')
        !
      @endslot
      @slot('title')
        {{ __('Błąd 404', 'pkpk') }}
      @endslot
      @slot('subtitle')
        {{ __('Przykro mi, nie potrafiliśmy znaleźć żądanej strony :(', 'pkpk') }}
      @endslot
      @slot('buttons')
        <a href="{{ home_url('/') }}" class="btn btn--border-secondary btn--large btn--full-width">{{ __('Wróć na stronę główną', 'pkpk') }}</a>
      @endslot

      <p>{{ __('Gdybyś miał/a jakieś pytania,', 'pkpk') }} <a href="mailto:kontakt@produktywnosckrokpokroku.pl">{{ __('napisz do mnie', 'pkpk') }}</a>.</p>
    @endcomponent
  @endif

@endsection
