@php
$user = wp_get_current_user();
$course = new App\Course();
$title = get_field( 'ppd_header', 'options' );
$subtitle = get_field( 'ppd_subheader', 'options' );
$paragraph = get_field( 'ppd_paragraph', 'options' );
$anchor = get_field( 'ppd_anchor', 'options' );
@endphp

<div class="container container--padding">
  <div class="row">
    <div class="col-xs-12 col-md-8 col-lg-9 content--app__main">
      <h1 class="content--app__heading">{{ $title }}</h1>
      <div class="shadow-box shadow-box--white">
        <div class="shadow-box__container">
          <div class="col-sm-10 col-md-11 col-lg-10">
            @component('components.alert')
            @slot('subtitle')
            {{ $subtitle }}
            @endslot
            @slot('buttons')
            <a href="{{ get_permalink( get_page_by_title( 'Ustawienia' ) ) . $course->id }}" class="btn btn--border-secondary btn--large btn--full-width">{{ $anchor }}</a>
            @endslot
            @if ($paragraph)
            {{ the_field( 'ppd_paragraph', 'options' ) }}
            @endif
            @endcomponent
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
