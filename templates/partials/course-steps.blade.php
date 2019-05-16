@php(pkpk_setup_featured_course())

@component('components.skewy-container', ['variant' => 'white bg bg--gray bg--steps'])
  <div class="container container--steps container--padding">
    <div class="row">
      <div class="container">
        <h2 class="std-heading">{{ the_field('step-by-step_heading') }}</h2>
        @if ( have_rows('step-by-step_steps') )
          <div class="steps container">
            <div class="row">
              @while(have_rows('step-by-step_steps')) @php(the_row())
                <div class="steps__step col-sm-6 col-lg-3">
                  <div class="steps__step-icon">
                    <i class="{{ the_sub_field('step_icon') }}"></i>
                  </div>
                  <div class="steps__step-body">
                    <div class="steps__step-heading">
                      <p><strong>{{ the_sub_field('step_heading') }}</strong></p>
                    </div>
                    <div class="steps__step-content">
                      {{ the_sub_field('step_content') }}
                    </div>
                  </div>
                </div>
              @endwhile
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endcomponent

@php(wp_reset_postdata())
