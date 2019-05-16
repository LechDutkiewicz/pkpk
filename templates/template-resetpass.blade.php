{{--
  Template Name: Reset password Template
--}}

@extends('layouts.shop')

@section('content')
  @php global $post @endphp

  <h2 class="std-heading">{{ __('Ustaw nowe hasło', 'pkpk' )}}</h2>
  <div class="std-content">{{ __('Wpisz nowe hasło poniżej.', 'pkpk') }}</div>

  @php
  theme_my_login( array('default_action' => 'resetpass', 'show_title' => false) );
  @endphp

@endsection
