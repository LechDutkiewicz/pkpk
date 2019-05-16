{{--
  Template Name: Simple Page
--}}
@extends('layouts/base/app')

@php(the_post())
@section('content')

  @component('components.alert')
    @slot('title')
      {{ the_title() }}
    @endslot
    @slot('buttons')
      <a href="{{ home_url('/') }}" class="btn btn--border-secondary btn--large btn--full-width">{{ __('Wróć na stronę główną', 'pkpk') }}</a>
    @endslot

    @php(the_content())
  @endcomponent

@endsection
