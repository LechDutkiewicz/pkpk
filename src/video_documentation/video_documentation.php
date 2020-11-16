<?php

if ( !defined( 'ABSPATH' ) )
	exit( 'No direct script access allowed' ); // Exit if accessed directly


/*============================================
=            Add ACF options page            =
============================================*/

if ( !function_exists('setup_acf_tab_video_documentation_bar') ) {

	function setup_acf_tab_video_documentation_bar() {

		if( function_exists('acf_add_options_page') ) {

			acf_add_options_page(array(
				'page_title' 	=> 'Video files with tutorials on how to manage certain tasks in WordPress.',
				'menu_title' 	=> 'Filmiki How-to',
				'slug'			=> 'acf-options-documentation',
				'icon_url'		=> get_template_directory_uri() . '/../src/video_documentation/video_documentation.png',
				'redirect' 		=> false,
				'position'		=> 58,
			));
		}
	}

	setup_acf_tab_video_documentation_bar();

}

/*=====  End of Add ACF options page  ======*/

/*=============================================
=            Add ACF custom fields            =
=============================================*/

/*=====  End of Add ACF custom fields  ======*/


/*==================================================
=            Enqueue styles and scripts            =
==================================================*/

add_action( 'admin_enqueue_scripts', 'documentation_admin_script', 20 );

function documentation_admin_script( $hook ) {

	if ( $hook === 'toplevel_page_acf-options-documentation' ) {

		$extension_path = get_template_directory_uri() . '/src/video_documentation';

		wp_register_style( 'magnific-popup', $extension_path . '/mfp.css' );
		wp_enqueue_style( 'magnific-popup' );

		wp_register_style( 'videodoc-admin', $extension_path . '/admin.css' );
		wp_enqueue_style( 'videodoc-admin' );

		wp_register_script( 'magnific-popup', $extension_path . '/mfp.js', array( 'jquery') );

		wp_register_script( 'videodoc-admin', $extension_path . '/admin.js', array( 'magnific-popup') );
		wp_enqueue_script( 'videodoc-admin' );


	} else {
		return;
	}
}

/*=====  End of Enqueue styles and scripts  ======*/



?>