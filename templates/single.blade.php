@extends('layouts.shop')

@section('content')
  @while(have_posts()) @php(the_post())
    <h1>test</h1>
    @include('partials/content-single-'.get_post_type())
  @endwhile
@endsection
