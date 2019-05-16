{{--
  Template Name: Lost password Template
--}}

@extends('layouts/base/app')

@section('content')
  @php global $post @endphp

  <h2 class="std-heading">{{ the_title() }}</h2>
  <div class="std-content">@php echo $post->post_content @endphp</div>

  @php
  echo do_shortcode('[theme-my-login show_title=0 default_action="lostpassword"]');
  @endphp

@endsection
