<div class="c-lessons c-reports">
  @php
    $course = new App\Course();

    $args = [
      'post_parent' => $course->id,
      'post_type' => 'lesson',
			'post_status' => 'publish',
			'orderby' 	=> 'date',
			'order'		=> 'DESC',
			'posts_per_page' => -1,
    ];

    $lessons_query = new WP_Query($args);
    $lessons_count = $lessons_query->post_count;

    $user_id = get_current_user_id();
    $empty = true;
  @endphp

  @query($args)
    @php

      $lesson_id = get_the_ID();
      $fields = get_post_meta($lesson_id, 'prod_userreporting_fields', true);
      $reports = get_post_meta($lesson_id, 'prod_userreporting_reports', true);
      $mandatory = get_post_meta($lesson_id, 'prod_userreporting_mandatory', true);

      $userReport = $reports[$user_id];

      $report_is_sended = prod_userreporting_is_report_sended($user_id, get_the_ID());
      $report_can_send = prod_userreporting_can_send_report($user_id, get_the_ID());
      $report_status_class = '';

      if ( $report_is_sended ) {
        if ( $report_is_sended === 1 ) {
          $report_status_class .= 'is-sended';
        } else {
          if ( $report_can_send ) {
            $report_status_class .= 'is-draft can-send';
          } else {
            $report_status_class .= 'is-draft cannot-send';
          }
        }
      } else {
        if ( $report_can_send ) {
          $report_status_class .= 'not-sended can-send';
        } else {
          $report_status_class .= 'not-sended cannot-send';
        }
      }
    @endphp

      @php
        $empty = false;
      @endphp
      <article class="c-lessons__item d-flex justify-content-center">
        <div class="col-sm-11 col-md-10">
          <header>
            <div class="c-lessons__item__meta d-flex justify-content-between">
              <p class="c-lessons__item__date">{{ the_date('j F Y') }}</p>
              <span class="c-lessons__item__report-status {{ $report_status_class }}">
                @if ($report_is_sended === 1)
                  <i class="zmdi zmdi-check"></i> {{ __('Raport wysłany w terminie', 'pkpk') }}
                @else
                  @if ($report_is_sended === 2)
                    @if ($report_can_send)
                      <i class="zmdi zmdi-alert-triangle"></i> {{ __('Masz wersję roboczą raportu, ale nie została wysłana', 'pkpk') }}
                    @else
                      <i class="zmdi zmdi-close"></i> {{ __('Masz wersję roboczą raportu, ale nie możesz już jej wysłać', 'pkpk') }}
                    @endif
                  @else
                    @if ($report_can_send)
                      <i class="zmdi zmdi-time-countdown"></i> {{ __('Raport jeszcze nie wysłany', 'pkpk') }}
                    @else
                      <i class="zmdi zmdi-close"></i> {{ __('Nie możesz już wysłać raportu', 'pkpk') }}
                    @endif
                  @endif
                @endif
              </span>
          </div>
            <h2 class="c-lessons__item__heading"><a href={{ the_permalink() }}><strong>{{ $lessons_count }}.</strong> {{ the_title() }}</a></h2>
          </header>
          <main class="c-lessons__item__content">
            
            @if (is_array($userReport))
              @php
              echo prod_userreporting_format_filled_report($userReport, $fields, '', $mandatory);
              @endphp
            @endif

            @if (!is_array($userReport))
              @php
              echo prod_userreporting_format_filled_report(false, $fields, '', $mandatory);
              @endphp
            @endif
          </main>
        </div>
      </article>
    @php($lessons_count--)
  @endquery

  @php(wp_reset_postdata())

  @if ($empty)
    <div class="c-lessons__empty d-flex justify-content-center align-items-center">
      <div class="alert alert-warning col-md-10">{{ __('Żaden raport nie został jeszcze wypełniony.', 'pkpk') }}</div>
    </div>
  @endif
</div>
