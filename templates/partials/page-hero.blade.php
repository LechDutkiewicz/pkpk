@php( $image = get_field('hero_bg') )

<section class="page-hero" style="background-image: url('{{ $image['url'] }}');">
  <div class="container container--flex container--padding">
    <div class="page-hero__content">
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
    <div :class="['page-hero__video', { playing: youtubePlaying == true }]">
      <youtube video-id="{{ the_field('hero_video_id') }}" player-width="100%" player-height="100%" @playing="playing" @ended="end" :player-vars="{controls: 1, iv_load_policy: 3, showinfo: 0, rel: 0}"></youtube>
    </div>
  </div>
</section>
