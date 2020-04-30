@php( pkpk_setup_featured_course() )
@php($frontpage_id = get_option( 'page_on_front' ))
@component('components.skewy-container', ['variant' => 'white', 'id' => 'kurs'])
<div class="container container--course-details container--padding">
  <div class="row">

    @if (have_rows('course_sections'))
    <div class="course-desc col-lg-6">
      @while(have_rows('course_sections')) @php(the_row())
      <div class="course-desc__section">
        <h2 class="course-desc__heading">
          @php(the_sub_field('section_heading'))
        </h2>
        <div class="course-desc__content">
          @php(the_sub_field('section_content'))
        </div>
      </div>
      @endwhile
    </div>
    @endif

    <div class="course-details col-lg-6">
      <div class="course-details__row row align-items-center">
        <div class="course-details__item col-sm-8">
          <p class="course-details__heading course-details__heading--accent">
            Najbliższa edycja za:
          </p>
          <div class="course-details__item-content">
            @php
            $course = pkpk_find_closest_course(true);
            $course_id = $course['ID'];
            $date = new DateTime($course['start_raw']);
            @endphp
            <p>
              <Countdown date="{{ $date->format('Y/m/d H:i') }}"></Countdown>
              <span class="course-details__separator"></span>
              <span class="course-details__light">{{ the_field('course_start', $course_id) }}</span>
            </p>
          </div>
        </div>
        <div class="course-details__item col-sm-4">
          <div class="course-details__item-content course-details__item-content--end">
            <p>
              {{ App\cta_enroll('btn-bg-transparent', 'normal', 'border-green', false) }}
              <a href="#cennik" class="course-details__more-options scroll-to-btn">{{ esc_html__('Sprawdź inne terminy', 'pkpk') }} <i class="zmdi zmdi-arrow-right"></i></a>
            </p>
          </div>
        </div>
      </div>
      <div class="course-details__row row">
        <div class="course-details__item col-6 col-sm-4">
          <p class="course-details__heading">
            {{ esc_html__( 'Czas trwania:', 'pkpk' ) }}
          </p>
          <div class="course-details__item-content">
            @if (get_field('course_duration', $frontpage_id))
            @php($course_duration = get_field('course_duration', $frontpage_id))
            @else
            @php
            $course_start = get_field('course_start', $course_id, false);
            $course_end = get_field('course_end', $course_id, false);
            $diff = strtotime($course_end) - strtotime($course_start);
            $course_duration = floor($diff/86400);
            @endphp
            @endif
            <p>
              {{ $course_duration }}
              @if ( $course_duration === 1 )
              {{ esc_html__( 'dzień', 'pkpk' ) }}
              @else
              {{ esc_html__( 'dni', 'pkpk' ) }}
              @endif
            </p>
          </div>
        </div>

        <div class="course-details__item col-6 col-sm-4">
          <p class="course-details__heading">
            {{ esc_html__( 'Potrzebujesz dziennie:', 'pkpk' ) }}
          </p>
          <div class="course-details__item-content">
            <p>{{ the_field('course_daily_time', $course_id) }}</p>
          </div>
        </div>

        <div class="course-details__item col-sm-4">
          <p class="course-details__heading">
            {{ esc_html__( 'Poziom:', 'pkpk' ) }}
          </p>
          <div class="course-details__item-content">
            @php
            $course_level = get_field_object('course_level', $course_id);
            $course_level_value = $course_level['value'];
            @endphp
            <p>{{ $course_level['choices'][$course_level_value] }}</p>
            <div class="course-details__level" data-level="{{ $course_level_value }}"></div>
          </div>
        </div>
      </div>
      <div class="course-details__row row">
        <div class="course-details__item col-sm-4">
          <p class="course-details__heading">
            {{ esc_html__( 'Średnia ocena kursu:', 'pkpk' ) }}
          </p>
          <div class="course-details__item-content course-details__item-content--no-justify">
            @php
            $course_rating = get_field('course_average_rating');
            @endphp
            <p>
              <span class="course-details__rating">
                <strong>{{ str_replace('.', ',', $course_rating) }}</strong>
              </span>
              <div class="course-details__rating-bar">
                <div style="width: {{ $course_rating * 10 }}%"></div>
              </div>
            </p>
          </div>
        </div>
        <div class="course-details__item col-sm-8">
          <p class="course-details__heading">
            {{ esc_html__( 'O kursie:', 'pkpk' ) }}
          </p>
          <div class="course-details__item-content">
            @if (have_rows('course_features'))
            <ul class="course-details__features-list">
              @while (have_rows('course_features')) @php(the_row())
              <li>
                @php( $icon = get_sub_field('feature_icon') )
                @if ( $icon )
                <i class="zmdi {{ $icon }}"></i>
                @endif
                <span>{{ the_sub_field('feature_content') }}</span>
              </li>
              @endwhile
            </ul>
            @endif
          </div>
        </div>
      </div>
    </div>
    @php(wp_reset_postdata())
    <div class="col-12 text-center">

      {{ App\cta_enroll() }}

      {{ App\cta_warranty_msg('dark', 'center') }}

    </div>
  </div>
</div>
@endcomponent
