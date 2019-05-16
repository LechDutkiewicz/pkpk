@component('components.skewy-container', ['variant' => 'gray'])
  <div class="container container--flex flex--wrap container--padding c--{{ $order || '0' }}">
    <h2 class="std-heading std-heading--full-width std-heading--center std-heading--testimonials">{{ the_field('testimonials_heading_' . $order) }}</h2>
    @php
      $args = array(
        'post_type' => 'testimonials',
        'posts_per_page' => $count,
        'offset' => $offset
      );
    @endphp
    <div class="row--testimonials">
      <slick ref="slick" :options="slickOptions">
        @query($args)
          <div class="testimonial">
            <div class="testimonial__content">
              <div class="testimonial__photo">
                @php
                  $image = get_field('testimonial_photo');
                  // vars
                  $url = $image['url'];
                	$title = $image['title'];
                	$alt = $image['alt'];
                  // thumbnail
                  $size = 'pkpk_photo_avatar';
                	$thumb_url = $image['sizes'][ $size ];
                @endphp
                @if ($image)
                  <img src={{ $thumb_url }} alt="{{ $alt }}">
                @else
                  <i class="zmdi zmdi-account"></i>
                @endif
              </div>
              <div class="testimonial__content-inner">
                <p class="testimonial__name">{{ the_title() }}</p>
                <p class="testimonial__city">{{ the_field('testimonial_city') }}</p>
                <div class="testimonial__text">{{ the_field('testimonial_content') }}</div>
              </div>
            </div>
          </div>
        @endquery
        @php(wp_reset_postdata())
      </slick>
    </div>
  </div>
@endcomponent
