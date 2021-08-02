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

    <div><div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.25%;"><figure style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.25%; margin-block-end: 0; margin-block-start: 0; margin-inline-start: 0; margin-inline-end: 0;" ><iframe src="https://api.vadoo.tv/iframe_test?id=LFx4ZxSeYQhFRASvxhoZwC2NuhXjFcJJ" scrolling="no" style="border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute; overflow:hidden; border-radius: 5px;" allowfullscreen="1" allow="autoplay"></iframe></figure></div></div>
    
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
