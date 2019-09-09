<?php

namespace App;

use Roots\Sage\Container;
use Illuminate\Contracts\Container\Container as ContainerContract;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param ContainerContract $container
 * @return ContainerContract|mixed
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
function sage($abstract = null, $parameters = [], ContainerContract $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
    ? $container->make($abstract, $parameters)
    : $container->make("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/**
 * Page titles
 * @return string
 */
function title()
{
    if (is_home()) {
        if ($home = get_option('page_for_posts', true)) {
            return get_the_title($home);
        }
        return __('Latest Posts', 'sage');
    }
    if (is_archive()) {
        return get_the_archive_title();
    }
    if (is_search()) {
        return sprintf(__('Search Results for %s', 'sage'), get_search_query());
    }
    if (is_404()) {
        return __('Not Found', 'sage');
    }
    return get_the_title();
}

function update_slugs() {
    $post_type = 'lesson';

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
                'ID' => $post->id,
                'post_name' => $new_permalink
            ];

              // Update the post into the database
            //   wp_update_post( $this_post );
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

/**
 * Translated month names
 * @return string
 */

function month_in_pl( $month ) {

    $month_names = array(
        1    => "stycznia",
        2    => "lutego",
        3    => "marca",
        4    => "kwietnia",
        5    => "maja",
        6    => "czerwca",
        7    => "lipca",
        8    => "sierpnia",
        9    => "września",
        10   => "października",
        11   => "listopada",
        12   => "grudnia"
    );

    return $month_names[$month];
}

/**
 * CTA warranty content
 * @return false
 */

function cta_warranty_msg( $color = 'dark', $layout = 'unset' ) {

    $cta_warranty = get_field('cta_warranty', 'options-warranty');
    $cta_warranty_tooltip = get_field('cta_warranty_tooltip', 'options-warranty');

    if ( $cta_warranty && $cta_warranty_tooltip ) {
        ?>
        <span class="cta__warranty cta__warranty--<?= $color; ?> justify__content--<?= $layout; ?>" data-toggle="tooltip" data-html="true" title="<?= $cta_warranty_tooltip; ?>" data-trigger="hover focus"><span><?= $cta_warranty; ?></span><i class="fa fa-info"></i></span>
        <?php
    }

    return false;
}
