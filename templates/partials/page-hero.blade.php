@php( $image = get_field('hero_bg') )

<section class="page-hero" style="background-image: url('{{ $image['url'] }}');">
  <div class="container container--flex container--padding">
    <div class="page-hero__content order-2">
      <h2 class="page-hero__heading">
        {{ the_field('hero_heading') }}
      </h2>
      <div class="page-hero__lead">
        {{ the_field('hero_content') }}
      </div>

      <div class="page-hero__cta">

        {{ App\cta_enroll() }}

        {{ App\cta_warranty_msg("light") }}

        @php
        $course = pkpk_find_closest_course();
        $date = new DateTime($course['start_raw']);
        @endphp
        <p class="page-hero__closest-course">{{ esc_html__('Najbliższy program:', 'pkpk') }} {{ $date->format('d.m.Y') }}</p>

      </div>
    </div>
    <div :class="['page-hero__video order-1 order-lg-3', { playing: youtubePlaying == true }]">
      <div class="ytvideo__headline"><i class="zmdi zmdi-volume-up"></i><strong>Upewnij się, że masz włączony dźwięk!</strong> (Poczekaj proszę na pełne załadowanie filmu)</div>
      <div class="ytvideo-holder">
        <youtube video-id="{{ the_field('hero_video_id') }}" player-width="100%" player-height="100%" @ready="ready" @ended="end" :player-vars="{autoplay: 1, controls: 2, cc_load_policy: 1, color: 'white', enablejsapi: 1, hl: 'pl', loop: 1, modestbranding: 1, origin: 'produktywnosckrokpokroku.pl', playsingline: 1, showinfo: 0}"></youtube>
        <div id="video-sound-overlay">
          <div class="unmute-button">
            <img src="{{ App\asset_path('images/soundbutton-pkpk.png') }}" alt="Kliknij żeby włączyć dźwięk">
          </div>
          <div class="play-button">
            <img src="{{ App\asset_path('images/playbutton-small.png') }}" alt="Kliknij żeby włączyć video">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
