{{--
  Template Name: Settings Template
--}}

@extends('layouts.subscribe')

@section('content')
  @php
  echo 'test';
  the_content();
  echo '<h2>5</h2>';
  echo do_shortcode('[userreporting_all id="5"]');
  echo '<h2>50</h2>';
  echo do_shortcode('[userreporting_all id="50"]');
  echo '<h2>25</h2>';
  echo do_shortcode('[userreporting_all id="25"]');
  @endphp
@endsection
