@component('components.skewy-container', ['id' => 'pros'])
  <div class="container container--flex flex--wrap container--padding" style="margin-top: -6rem">
    <div class="row row--flex flex--between">
      <div class="col-lg-6">
        <h2 class="std-heading std-heading--full-width std-heading--center std-heading--testimonials">{{ the_field('pros_heading') }}</h2>
        @component('components.shadow-box', ['variant' => 'white', 'row' => true])
          @if (have_rows('pros'))
            <div class="features-list features-list--with-ico">
              <ul class="row justify-content-center">
                @while(have_rows('pros')) @php(the_row())
                  <li class="features-list__element col-md-10">
                    <i class="features-list__element-icon ion-android-checkmark-circle"></i>
                    <div class="features-list__element-content">
                      <p class="features-list__element-heading">
                        {{ the_sub_field('text') }}
                      </p>
                      <div class="features-list__element-text">
                        {{ the_sub_field('list_content') }}
                      </div>
                    </div>
                  </li>
                @endwhile
              </ul>
            </div>
          @endif
        @endcomponent
      </div>
      <div class="col-lg-6">
        <h2 class="std-heading std-heading--full-width std-heading--center std-heading--testimonials">{{ the_field('cons_heading') }}</h2>
        @component('components.shadow-box', ['variant' => 'white', 'row' => true])
          @if (have_rows('cons'))
            <div class="features-list features-list--with-ico">
              
              <ul class="row justify-content-center">
                @while(have_rows('cons')) @php(the_row())
                  <li class="features-list__element col-md-10">
                    <i class="features-list__element-icon ion-ios-close-outline"></i>
                    <div class="features-list__element-content">
                      <p class="features-list__element-heading">
                        {{ the_sub_field('text') }}
                      </p>
                      <div class="features-list__element-text">
                        {{ the_sub_field('list_content') }}
                      </div>
                    </div>
                  </li>
                @endwhile
              </ul>
            </div>
          @endif
        @endcomponent
      </div>
    </div>
  </div>
@endcomponent