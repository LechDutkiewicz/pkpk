<?php
// Register Custom Post Types
add_action('init', function() {
	$labels = array(
		'name'                  => _x( 'Kursy', 'Post Type General Name', 'pkpk' ),
		'singular_name'         => _x( 'Kurs', 'Post Type Singular Name', 'pkpk' ),
		'menu_name'             => __( 'Kursy', 'pkpk' ),
		'name_admin_bar'        => __( 'Kurs', 'pkpk' ),
		'archives'              => __( 'Archiwum', 'pkpk' ),
		'attributes'            => __( 'Item Attributes', 'pkpk' ),
		'parent_item_colon'     => __( 'Rodzic:', 'pkpk' ),
		'all_items'             => __( 'Wszystkie Kursy', 'pkpk' ),
		'add_new_item'          => __( 'Dodaj nowy kurs', 'pkpk' ),
		'add_new'               => __( 'Dodaj Nowy', 'pkpk' ),
		'new_item'              => __( 'Nowy Kurs', 'pkpk' ),
		'edit_item'             => __( 'Edytuj', 'pkpk' ),
		'update_item'           => __( 'Aktualizuj', 'pkpk' ),
		'view_item'             => __( 'Zobacz Kurs', 'pkpk' ),
		'view_items'            => __( 'Zobacz Kursy', 'pkpk' ),
		'search_items'          => __( 'Szukaj kursu', 'pkpk' ),
		'not_found'             => __( 'Not found', 'pkpk' ),
		'not_found_in_trash'    => __( 'Not Found in Trash', 'pkpk' ),
		'featured_image'        => __( 'Featured Image', 'pkpk' ),
		'set_featured_image'    => __( 'Set featured image', 'pkpk' ),
		'remove_featured_image' => __( 'Remove featured image', 'pkpk' ),
		'use_featured_image'    => __( 'Use as featured image', 'pkpk' ),
		'insert_into_item'      => __( 'Insert into item', 'pkpk' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'pkpk' ),
		'items_list'            => __( 'Items list', 'pkpk' ),
		'items_list_navigation' => __( 'Items list navigation', 'pkpk' ),
		'filter_items_list'     => __( 'Filter items list', 'pkpk' ),
	);
	$args = array(
		'label'                 => __( 'Kurs', 'pkpk' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'editor', 'post-formats' ),
		'taxonomies'            => array(),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
    'rewrite'               => array('slug' => 'kurs', 'with_front' => false),
		//'cptp_permalink_structure' => "/%postname%/",
	);
	register_post_type( 'course', $args );

  $labels = array(
		'name'                  => _x( 'Lekcje', 'Post Type General Name', 'pkpk' ),
		'singular_name'         => _x( 'Lekcja', 'Post Type Singular Name', 'pkpk' ),
		'menu_name'             => __( 'Lekcje', 'pkpk' ),
		'name_admin_bar'        => __( 'Lekcja', 'pkpk' ),
		'archives'              => __( 'Archiwum', 'pkpk' ),
		'attributes'            => __( 'Item Attributes', 'pkpk' ),
		'parent_item_colon'     => __( 'Rodzic:', 'pkpk' ),
		'all_items'             => __( 'Wszystkie Lekcje', 'pkpk' ),
		'add_new_item'          => __( 'Dodaj nową lekcję', 'pkpk' ),
		'add_new'               => __( 'Dodaj Nową', 'pkpk' ),
		'new_item'              => __( 'Nowa Lekcja', 'pkpk' ),
		'edit_item'             => __( 'Edytuj', 'pkpk' ),
		'update_item'           => __( 'Aktualizuj', 'pkpk' ),
		'view_item'             => __( 'Zobacz Lekcję', 'pkpk' ),
		'view_items'            => __( 'Zobacz Lekcje', 'pkpk' ),
		'search_items'          => __( 'Szukaj lekcji', 'pkpk' ),
		'not_found'             => __( 'Not found', 'pkpk' ),
		'not_found_in_trash'    => __( 'Not Found in Trash', 'pkpk' ),
		'featured_image'        => __( 'Featured Image', 'pkpk' ),
		'set_featured_image'    => __( 'Set featured image', 'pkpk' ),
		'remove_featured_image' => __( 'Remove featured image', 'pkpk' ),
		'use_featured_image'    => __( 'Use as featured image', 'pkpk' ),
		'insert_into_item'      => __( 'Insert into item', 'pkpk' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'pkpk' ),
		'items_list'            => __( 'Items list', 'pkpk' ),
		'items_list_navigation' => __( 'Items list navigation', 'pkpk' ),
		'filter_items_list'     => __( 'Filter items list', 'pkpk' ),
	);
	$args = array(
		'label'                 => __( 'Lekcja', 'pkpk' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'comments', 'author' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'          		=> 'lessons',
    'rewrite'               => array('slug' => 'lekcja', 'with_front' => true),
		//'cptp_permalink_structure' => "/kwiecien/2017/%lesson_number%/",
	);
	register_post_type( 'lesson', $args );

	$labels = array(
		'name'                  => _x( 'Rekomendacje', 'Post Type General Name', 'pkpk' ),
		'singular_name'         => _x( 'Rekomendacja', 'Post Type Singular Name', 'pkpk' ),
		'menu_name'             => __( 'Rekomendacje', 'pkpk' ),
		'name_admin_bar'        => __( 'Rekomendacja', 'pkpk' ),
		'archives'              => __( 'Item Archives', 'pkpk' ),
		'attributes'            => __( 'Item Attributes', 'pkpk' ),
		'parent_item_colon'     => __( 'Parent Item:', 'pkpk' ),
		'all_items'             => __( 'Wszystkie Rekomendacje', 'pkpk' ),
		'add_new_item'          => __( 'Dodaj Nową Rekomendację', 'pkpk' ),
		'add_new'               => __( 'Dodaj Nową', 'pkpk' ),
		'new_item'              => __( 'New Item', 'pkpk' ),
		'edit_item'             => __( 'Edit Item', 'pkpk' ),
		'update_item'           => __( 'Update Item', 'pkpk' ),
		'view_item'             => __( 'View Item', 'pkpk' ),
		'view_items'            => __( 'View Items', 'pkpk' ),
		'search_items'          => __( 'Search Item', 'pkpk' ),
		'not_found'             => __( 'Not found', 'pkpk' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'pkpk' ),
		'featured_image'        => __( 'Featured Image', 'pkpk' ),
		'set_featured_image'    => __( 'Set featured image', 'pkpk' ),
		'remove_featured_image' => __( 'Remove featured image', 'pkpk' ),
		'use_featured_image'    => __( 'Use as featured image', 'pkpk' ),
		'insert_into_item'      => __( 'Insert into item', 'pkpk' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'pkpk' ),
		'items_list'            => __( 'Items list', 'pkpk' ),
		'items_list_navigation' => __( 'Items list navigation', 'pkpk' ),
		'filter_items_list'     => __( 'Filter items list', 'pkpk' ),
	);
	$args = array(
		'label'                 => __( 'Rekomendacja', 'pkpk' ),
		'description'           => __( 'Testimonial information page.', 'pkpk' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-page',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'testimonials', $args );

}, 10);

/*
// Set permalink for Lessons
add_filter('post_type_link', function($permalink, $post, $leavename) {
  $post_id = $post->ID;

	if ( !($post->post_type == 'lesson' || $post->post_type == 'course') || empty($permalink) || in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
			return $permalink;
	}

	if ( $post->post_type == 'lesson' ) {
			$parent = $post->post_parent;
			$parent_post = get_post( $parent );
			$lesson = new App\Lesson($post);
			$lesson_number = $lesson->currentNumber($post->ID);
			$permalink = str_replace('%lesson_number%', $lesson_number, $permalink);
	}

	if ( $post->post_type == 'course' ) {
			$permalink = str_replace('%courseid%', $post->ID, $permalink);
	}

	return $permalink;
}, 10, 3);*/
