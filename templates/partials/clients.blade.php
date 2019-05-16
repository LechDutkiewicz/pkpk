@component('components.skewy-container', ['variant' => 'gray', 'id' => 'klienci'])
  <div class="container container--program container--padding">
    <div class="row">
      <div class="col-lg-6">
        <h2 class="std-heading std-heading--full-width">{{ the_field('works_heading') }}</h2>
      </div>
    </div>

    @php($images = get_field('works_clients'))

    @if( $images )
      <div class="row clients-logo align-items-center">
        @foreach( $images as $image )
          <div class="col-6 col-md-4 col-lg clients-logo__item">
            <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" />
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endcomponent