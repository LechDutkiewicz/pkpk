{{--
  Template Name: Reset Password Sent Template
--}}
@extends('layouts/base/app')

@section('content')
  @php
    global $post
  @endphp
  @component('components.alert')
    @slot('title')
      {{ __('Wysłaliśmy Ci wiadomość!', 'pkpk') }}
    @endslot
    @slot('subtitle')
      {{ __('Sprawdź swoją skrzynkę e-mail.', 'pkpk') }}
    @endslot
    @slot('buttons')
      <a href="{{ home_url('/') }}" class="btn btn--border-secondary btn--large btn--full-width">{{ __('Wróć na stronę główną', 'pkpk') }}</a>
    @endslot

    @php echo $post->post_content @endphp
    <p><a href="{{ wp_login_url(false) }}">{{ __('Jeśli jednak pamiętasz hasło, wróć do logowania', 'pkpk') }}</a></p>
  @endcomponent

@endsection
