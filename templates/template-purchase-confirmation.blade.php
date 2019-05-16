{{--
  Template Name: Purchase Confirmation Template
--}}

@extends('layouts.shop')

@section('content')

  @if ( !empty($_GET["payment_key"]) )

    @component('components.alert')
      @slot('icon')
        <i class="zmdi zmdi-check"></i>
      @endslot
      @slot('title')
        {{ __('Potwierdzenie zamówienia', 'pkpk') }}
      @endslot

      @slot('buttons')
        <a href="{{ home_url() }}" class="btn btn--border-secondary btn--full-width btn--large">Wróć do strony głównej</a>
      @endslot

      @php
      echo do_shortcode('[edd_receipt]');
      @endphp
    @endcomponent

  @else
    @component('components.alert')
      @slot('icon')
        <i class="zmdi zmdi-check"></i>
      @endslot
      @slot('title')
        {{ __('Dziękujemy', 'pkpk') }}
      @endslot
      @slot('subtitle')
        {{ __('Płatność została zrealizowana pomyślnie', 'pkpk') }}
      @endslot
      @slot('buttons')
        <a href="{{ home_url() }}" class="btn btn--border-secondary btn--full-width btn--large">Wróć do strony głównej</a>
      @endslot

      <p>Kilka dni przed rozpoczęciem programu, dostaniesz maila ze wskazówkami. Potwierdzenie tej transakcji już powinieneś/naś mieć na swojej skrzynce mailowej.</p>
      <p>Gdybyś miał/a jakieś pytania, <a href="mailto:kontakt@produktywnosckrokpokroku.pl">napisz do mnie.</a></p>
    @endcomponent
  @endif

@endsection
