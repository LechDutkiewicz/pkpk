{{--
  Template Name: Profile Template
--}}

@extends('layouts/base/app-logged-in')

@section('content')
  @php global $post @endphp

  <h2 class="std-heading">{{ $post->post_title }}</h2>
  <div class="std-content">@php echo $post->post_content @endphp</div>

  @php
  //theme_my_login( array('default_action' => 'profile', 'show_title' => false) );
  echo do_shortcode('[theme-my-login default_action="profile" show_title=0]');
  //echo do_shortcode('[theme-my-login]');
  @endphp

@endsection
