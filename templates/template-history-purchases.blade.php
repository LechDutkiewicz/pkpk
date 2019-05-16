{{--
  Template Name: History Purchases Template
--}}

@extends('layouts.shop')

@section('content')
  @component('components.alert')
    @slot('icon')
      <i class="icon ion-information"></i>
    @endslot
    @slot('title')
      {{ __('Historia Zamówień', 'pkpk') }}
    @endslot
    @slot('subtitle')
      {{ __('Wszystkie Twoje Zamówienia.', 'pkpk') }}
    @endslot
    @slot('buttons')
      <a href="{{ home_url('/') }}" class="btn btn--border-secondary btn--large btn--full-width">{{ __('Wróć na stronę główną', 'pkpk') }}</a>
    @endslot

    @php
    echo do_shortcode('[purchase_history]');
    @endphp
  @endcomponent

@endsection
