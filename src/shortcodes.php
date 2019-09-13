<?php

/*===============================================
=            Custom report shortcode            =
===============================================*/

/*----------  Register and add tinymce button  ----------*/

// init process for registering our button
add_action('admin_init', 'report_tinymce_button');
function report_tinymce_button() {

	//Abort early if the user will never see TinyMCE
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
		return;

	//Add a callback to regiser our tinymce plugin   
	add_filter("mce_external_plugins", "report_register_tinymce_button"); 

	// Add a callback to add our button to the TinyMCE toolbar
	add_filter('mce_buttons', 'report_add_tinymce_button');
}


//This callback registers our plug-in
function report_register_tinymce_button($plugin_array) {

	global $pagenow, $typenow;

	// Zarejestruj button tylko podczas edytowania lekcji
	if ( in_array( $pagenow, array( 'post.php' ) ) && $typenow == 'lesson' ) {

		$plugin_array['report_button'] = get_stylesheet_directory_uri() . '/src/shortcodes/reportShortcode.js';
		return $plugin_array;
	}
}

//This callback adds our button to the toolbar
function report_add_tinymce_button($buttons) {

	global $pagenow, $typenow;

	// Dodaj button do tinymce tylko podczas edytowania lekcji
	if ( in_array( $pagenow, array( 'post.php' ) ) && $typenow == 'lesson' ) {

	//Add the button ID to the $button array
		array_push( $buttons, 'report_button');
		return $buttons;
	}
}

/*----------  Add ThickBox with necessary options  ----------*/

function report_shortcode_thickbox() {
	global $post, $pagenow, $typenow;

	// Dodaj thickbox tylko podczas edytowania lekcji
	if ( in_array( $pagenow, array( 'post.php' ) ) && $typenow == 'lesson' ) {
		add_thickbox();

		$lesson_id = $post->ID;
		// ID kursu, do którego przyporządkowana jest lekcja
		$parent_id = wp_get_post_parent_id( $post );

		// Pobierz wszystkie lekcje z tego samego kursu
		$the_query = new WP_Query( array( 
			'order' => 'DESC',
			'post_type' => 'lesson',
			'post_parent' => $parent_id,
			'post_status' => 'publish',
			'posts_per_page' => -1
		) );

		?>
		<div id="report-thickbox" style="display:none;">
			<h2>Wstaw raport użytkownika z lekcji:</h2>
			<?php
			if ( $the_query->have_posts() ) {
				$i = $the_query->found_posts;
				$echo = false;
				?>
				<select id="report_shortcode_select" style="clear: both; display: block; margin-bottom: 1em; margin-top: 1em;">
					<?php
					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						// Jeśli w pętli postów dojdę do tego samego, który aktualnie edytuję, zacznij wyświetlać posty jako opcje w select. Jest to po to, aby dało się wstawić shortcode odnoszący się tylko do przeszłych lekcji
						if ( $post->ID == $lesson_id ) {
							$echo = true;
							$i--;
							continue;
						}
						if ($echo) {
							?>
							<option lesson-id="<?= $lesson_id; ?>" value="<?= $post->ID; ?>"><?= "$i. $post->post_title"; ?></option>
							<?php
						}
						$i--;
					}

					wp_reset_postdata();
					?>
				</select>
				<?php
			}
			?>		
			<p class="submit">
				<input type="button" id="insert_report_shortcode" class="button-primary" value="Wstaw shortcode z raportem" />
				<a id="cancel_report_shortcode" class="button-secondary" onclick="tb_remove();">Anuluj</a>
			</p>
		</div>
		<?php
	}
}
add_action('admin_footer', 'report_shortcode_thickbox');


/*=====  End of Custom report shortcode  ======*/


?>