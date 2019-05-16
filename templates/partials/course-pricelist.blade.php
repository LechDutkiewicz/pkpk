@php(pkpk_setup_featured_course())
@php($frontpage_id = get_option( 'page_on_front' ))
@component('components.skewy-container', ['variant' => 'white', 'id' => 'cennik'])
<div class="container flex--wrap  container--padding container--cennik">
  <h2 class="std-heading std-heading--full-width std-heading--center">Weź udział w programie</h2>

  <div class="spin-loader" v-if="!coursesFetched">
    <div class="spin">
      <i class="icon ion-load-d"></i>
    </div>
  </div>

  <div class="select-course container" v-if="coursesFetched">
    <h3 class="select-course__heading">Termin kursu:</h3>
    <ul class="select-course__dates">
      <li v-for="(course, index) in courses" @click="selectedCourse = index, highlightDate = true" :class="{selected: selectedCourse == index}">
        @{{ course.start }}
      </li>
    </ul>
  </div>
  <div class="price-table container" v-if="coursesFetched">
    <div class="row justify-content-center">
      @component('components.shadow-box', ['variant' => 'white', 'col' => 'md-10 col-lg-8 col-xl-7', 'row' => true])

      <div class="col-sm-6 price-table__item price-table__item--color-secondary d-flex flex-wrap">
        <div class="price-table__item-head" style="width: 100%;">
          <p class="price-table__item-variant">Program podstawowy</p>
          <p class="price-table__item-price">@{{ courses[selectedCourse].variants.basic.price | toFixed }}zł</p>
          <p class="price-table__item-desc">{{ the_field('course_basic_subheader', $frontpage_id) }}</p>

          @if (have_rows('course_basic_features', $frontpage_id))
          <div class="price-table__item-content">
            <ul class="price-table__item-details col" style="padding-left: 15px; padding-right: 15px; margin-bottom: 30px;">
              @while(have_rows('course_basic_features', $frontpage_id)) @php(the_row())
              <li>{{ the_sub_field('feature') }}</li>
              @endwhile
            </ul>
          </div>
          @endif
        </div>
        <div class="price-table__item-footer align-self-end" style="width: 100%;">
          <a :href="'{{ home_url('/zamowienie?edd_action=add_to_cart&download_id=') }}' + courses[selectedCourse].downloadID + '&amp;edd_options&#91;price_id&#93;=1'" class="btn btn--large btn--green">Zapisz się na kurs</a>
          {{ App\cta_warranty_msg('dark', 'center') }}
          <p class="price-table__selected-date">Wybrany termin: <span :class="{ 'highlight' : highlightDate }">@{{ courses[selectedCourse].start }}</span>
          </div>
        </div>

        <div class="col-sm-6 price-table__item price-table__item--color-green d-flex flex-wrap">
          <div class="price-table__item-head" style="width: 100%;">
            <p class="price-table__item-variant">Program rozszerzony</p>
            <p class="price-table__item-price">@{{ courses[selectedCourse].variants.pro.price | toFixed }}zł</p>
            <p class="price-table__item-desc">{{ the_field('course_pro_subheader', $frontpage_id) }}</p>

            @if (have_rows('course_pro_features', $frontpage_id))
            <div class="price-table__item-content">
              <ul class="price-table__item-details col" style="padding-left: 15px; padding-right: 15px; margin-bottom: 30px;">
                @while(have_rows('course_pro_features', $frontpage_id)) @php(the_row())
                <li>{{ the_sub_field('feature') }}</li>
                @endwhile
              </ul>
            </div>
            @endif
          </div>
          <div class="price-table__item-footer align-self-end" style="width: 100%;">
            <a :href="'{{ home_url('/zamowienie?edd_action=add_to_cart&download_id=') }}' + courses[selectedCourse].downloadID + '&amp;edd_options&#91;price_id&#93;=2'" class="btn btn--large btn--green">Zapisz się na kurs</a>
            {{ App\cta_warranty_msg('dark', 'center') }}
            <p class="price-table__selected-date">Wybrany termin: <span :class="{ 'highlight' : highlightDate }">@{{ courses[selectedCourse].start }}</span>
            </div>
          </div>

          @endcomponent
        </div>
      </div>
    </div>
    @endcomponent
    @php(wp_reset_postdata())
