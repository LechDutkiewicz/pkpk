{{--
  Template Name: Home Template
--}}

@extends('layouts.landing')

@php
  // Clear cart before any action
  do_action('pkpk_before_home_content');

  function update_slugs() {    $post_type = 'lesson';

    $the_query = new WP_Query([
      'post_type' => $post_type,
      'posts_per_page' => -1
    ]);

    $monthnames = array(
        'styczen',
        'luty',
        'marzec',
        'kwiecien',
        'maj',
        'czerwiec',
        'lipiec',
        'sierpien',
        'wrzesien',
        'pazdziernik',
        'listopad',
        'grudzien',
    );

    if ( $the_query->have_posts() ) {
      while ( $the_query->have_posts() ) {
        $the_query->the_post();
        global $post;
        $permalink = $post->post_name;
        $new_permalink = $post->post_name;

        try {
            if ( $post->post_type === 'lesson' ) {
                $course_start = get_field('course_start', $post->post_parent, false);
                $monthindex = date('m', strtotime($course_start));
                $year = date('Y', strtotime($course_start));
            } else if ( $post->post_type === 'course' ) {
                $course_start = get_field('course_start', $post->ID, false);
                $monthindex = date('m', strtotime($course_start));
            } else {
                $monthindex = intval(get_post_time( 'n', "GMT" == false, $post->ID ));
            }

            $monthname = $monthnames[$monthindex - 1];
            if ( substr( $permalink, 0, 2 ) !== '20' ) {
              $new_permalink = $year . '-' . $monthname . '-' . $post->post_name;
            }

            if ($permalink !== $new_permalink) {
              $this_post = [
                'ID' => $post->ID,
                'post_name' => $new_permalink
              ];
              
              // Update the post into the database
              wp_update_post( $this_post );
            }

        } catch (Exception $e) {
            return;
        }
      }
      /* Restore original Post Data */
      wp_reset_postdata();
    } else {
      // no posts found
    }
  }
@endphp

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-hero')
    @include('partials.home.intro')
    @include('partials.testimonials', ['order' => '1', 'count' => 2, 'offset' => 0])
    @include('partials.course-details')
    @include('partials.faq')
    @include('partials.course-steps')
    @include('partials.course-pricelist')
    @include('partials.home.course-feedback')
    @include('partials.author-section')
    @include('partials.clients')
    @include('partials.home.course-desc')
    @include('partials.course-program')
    @include('partials.home.pros-cons')
    @include('partials.testimonials', ['order' => '3', 'count' => 2, 'offset' => 4])
    @include('partials.contact')
    @include('partials.popup')
  @endwhile
@endsection
