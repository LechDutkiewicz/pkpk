<div class="c-lessons">
  @php
    global $post;
    $post_id = $post->ID;
    $course = new App\Course();
    $is_over = $course->isOver();

    $args = [
      'post_type' => 'lesson',
      'post_parent' => $post_id,
      'order' => 'DESC',
    ];

    $lessons_query = new WP_Query($args);
    $i = 0;
    $lessons_count = $lessons_query->post_count;

    $user_id = get_current_user_id();
  @endphp

  @query($args)
    <article class="c-lessons__item d-flex justify-content-center">
      <div class="col-sm-10 col-md-11 col-lg-10">
        <header>
          <p class="c-lessons__item__date">{{ the_date('j F Y') }}</p>
          <h2 class="c-lessons__item__heading"><a href={{ the_permalink() }}><strong>{{ $lessons_count }}.</strong> {{ the_title() }}</a></h2>
        </header>
        <main class="c-lessons__item__content">
          {{ the_excerpt() }}
        </main>
        <footer class="c-lessons__item__meta">
          <div class="c-lessons__item__meta-info">
            <span class="c-lessons__item__comments">
              ({{ comments_number( 'Brak komentarzy', '1 komentarz', '% komentarze' ) }})
            </span>
            @php
              $report_is_sended = prod_userreporting_is_report_sended($user_id, get_the_ID());
              $report_can_send = prod_userreporting_can_send_report($user_id, get_the_ID());
              $report_status_class = '';

              if ( $report_is_sended ) {
                $report_status_class .= 'is-sended';
              } else {
                if ( $report_can_send ) {
                  $report_status_class .= 'not-sended can-send';
                } else {
                  $report_status_class .= 'not-sended cannot-send';
                }
              }
            @endphp
            <span class="c-lessons__item__report-status {{ $report_status_class }}">
              @if ($report_is_sended)
                <i class="zmdi zmdi-check"></i> {{ __('Raport wysłany w terminie', 'pkpk') }}
              @else
                @if ($report_can_send)
                  <i class="zmdi zmdi-time-countdown"></i> {{ __('Raport jeszcze nie wysłany', 'pkpk') }}
                @else
                  <i class="zmdi zmdi-close"></i> {{ __('Nie możesz już wysłać raportu', 'pkpk') }}
                @endif
              @endif
            </span>
          </div>
          <a href="{{ the_permalink() }}" class="btn btn--border-green">{{ __('Przejdź do lekcji', 'pkpk') }}</a>
        </footer>
      </div>
    </article>

    @if ($is_over)
      @php($i++)
      @if ($i === 3)
        @include('partials/course/banner', ['title' => 'To tylko zajawki lekcji.'])
      @endif
    @endif

    @php($lessons_count--)
  @endquery
  @notposts($args)
    <div class="c-lessons__empty d-flex justify-content-center align-items-center">
      <div class="alert alert-warning">{{ __('Ten kurs nie ma żadnych lekcji', 'pkpk') }}</div>
    </div>
  @endnotposts
  @php(wp_reset_postdata())

</div>
