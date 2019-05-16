@component('components.skewy-container', ['variant' => 'white bg bg--gray bg--steps'])
  <div class="container container--padding" style="padding-top: 2rem">
    <div class="row">
      <div class="col-lg-5">
        <h2 class="std-heading">{{ the_field('process_heading') }}</h2>
      </div>
      <div class="col-lg-7 course-desc__content">
        {{ the_field('process_content') }}
      </div>
    </div>
  </div>
@endcomponent
