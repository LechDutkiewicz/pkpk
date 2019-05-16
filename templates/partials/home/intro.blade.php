@component('components.skewy-container', ['variant' => 'gray'])
  <div class="container container--padding container--intro">
    <div class="row">
      <div class="col-12">
        <div class="c-intro text-center">
          {{ the_field('intro_content' )}}
        </div>
      </div>
    </div>
  </div>
@endcomponent