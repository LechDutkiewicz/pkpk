{{--
  Template Name: Checkout Template
--}}

@extends('layouts.shop')

@section('content')
  @php
  echo pkpk_checkout_form();
  @endphp
@endsection
