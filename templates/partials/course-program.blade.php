@php(pkpk_setup_featured_course())
@component('components.skewy-container', ['variant' => 'white', 'id' => 'program'])
<div class="container container--program flex--wrap container--padding">
  <h2 class="std-heading std-heading--full-width">{{ the_field('program_heading') }}</h2>
  <div class="row row--flex flex--between">

    @component('components.shadow-box', ['variant' => 'white', 'col' => 'lg-8', 'row' => true])
    @if (have_rows('program_list'))
    <div class="features-list features-list--with-ico">
      <ul class="row">
        @while(have_rows('program_list')) @php(the_row())
        <li class="features-list__element col-md-6">
          <i class="features-list__element-icon ion-android-checkmark-circle"></i>
          <div class="features-list__element-content">
            <p class="features-list__element-heading">
              {{ the_sub_field('list_heading') }}
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

    @if (have_rows('program_summary'))
    <div class="features-summary col-12 col-lg-4">
      <div class="row">
        @while(have_rows('program_summary')) @php(the_row())
        <div class="col-sm-6 col-lg-12">
          <div class="features-summary__item">
            <div class="features-summary__item-award">
              <i class="features-summary__item-icon zmdi {{ the_sub_field('icon') }}"></i>
              <span class="features-summary__item-uniq">{{ the_sub_field('award') }}</span>
            </div>
            <div class="features-summary__item-content">
              {{ the_sub_field('content') }}
            </div>
          </div>
        </div>
        @endwhile
      </div>
    </div>
    @endif
    <div class="col-12 text-center" style="margin-top: 6rem; margin-bottom: 3rem;">
      
      {{ App\cta_enroll() }}

      {{ App\cta_warranty_msg('dark', 'center') }}
      
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-7 text-center course-desc__content">
      <p>W ciągu pierwszych siedmiu dni kurs jest dla Ciebie za darmo! Jeśli w tym czasie uznasz, że nie jest dla Ciebie - oddam Ci 100% Twoich pieniędzy. Wystarczy, że napiszesz do mnie maila z rezygnacją, a środki wrócą z powrotem na Twoje konto.</p>
    </div>
  </div>
</div>
@endcomponent
@php(wp_reset_postdata())
