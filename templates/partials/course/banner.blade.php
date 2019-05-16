<div class="c-lesson__banner d-flex justify-content-center">
  <div class="col-sm-11 col-lg-10">
    <p class="c-lesson__banner__subheading">
      {{ the_field('banner_upperheading', 'options-course') }}
    </p>
    <h3 class="c-lesson__banner__heading">
      {{ the_field('banner_heading', 'options-course') }}
    </h3>
    <p class="c-lesson__banner__content">
      {{ the_field('banner_content', 'options-course') }}
    </p>
    <a href="{{ home_url( '/#cennik' ) }}" class="btn btn--green btn--large">{{ the_field('banner_btn-text', 'options-course') }}</a>
  </div>
</div>