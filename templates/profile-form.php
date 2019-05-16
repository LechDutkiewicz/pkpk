<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php
	$error = $template->get_errors();
	if ( strlen($error) == 51) : ?>
		<div class="alert alert-success"><?php esc_html_e('Profil zaktualizowany.', 'pkpk'); ?></div>
	<?php else : ?>
		<div class="alert alert-danger"><?php echo $error; ?></div>
	<?php endif; ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		<div>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
			<input type="hidden" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
		</div>

		<div class="form-field">
			<label for="first_name"><?php _e( 'Imię*', 'theme-my-login' ); ?></label>
			<input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" required/>
		</div>

		<div class="form-field">
			<label for="last_name"><?php _e( 'Nazwisko*', 'theme-my-login' ); ?></label>
			<input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" required/>
		</div>

		<div class="form-field">
			<label for="email"><?php _e( 'Adres e-mail*', 'theme-my-login' ); ?></label>
			<input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" required/>
			<?php
			$new_email = get_option( $current_user->ID . '_new_email' );
			if ( $new_email && $new_email['newemail'] != $current_user->user_email ) : ?>
			<div class="updated inline">
			<p><?php
				printf(
					__( 'There is a pending change of your e-mail to %1$s. <a href="%2$s">Cancel</a>', 'theme-my-login' ),
					'<code>' . $new_email['newemail'] . '</code>',
					esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
			); ?></p>
			</div>
			<?php endif; ?>
		</div>

		<div class="form-field tml-nickname-wrap">
			<label for="nickname"><?php _e( 'Pseudonim', 'pkpk' ); ?></label>
			<input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" />
		</div>

		<div class="form-field tml-display-name-wrap">
			<label for="display_name"><?php _e( 'Wyświetlana nazwa', 'pkpk' ); ?></label>
			<td>
				<select name="display_name" id="display_name">
				<?php
					$public_display = array();
					$public_display['display_nickname']  = $profileuser->nickname;
					$public_display['display_username']  = $profileuser->user_login;
					if ( ! empty( $profileuser->first_name ) )
						$public_display['display_firstname'] = $profileuser->first_name;
					if ( ! empty( $profileuser->last_name ) )
						$public_display['display_lastname'] = $profileuser->last_name;
					if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
						$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
						$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
					}
					if ( ! in_array( $profileuser->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
						$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;
					$public_display = array_map( 'trim', $public_display );
					$public_display = array_unique( $public_display );
					foreach ( $public_display as $id => $item ) {
				?>
					<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		</div>

		<div class="form-field">
			<label for="report_on_email"><?php _e( 'Otrzymuj raporty mailowo', 'theme-my-login' ); ?></label>
			<input type="checkbox" name="report_on_email" class="ios8-switch ios8-switch-lg" id="report_on_email" value="yes" <?php if (esc_attr( get_the_author_meta( "report_on_email", $current_user->ID )) == "yes") echo "checked"; ?> /><label for="report_on_email"></label><br />
		</div>

		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>
		<div class="form-field form-field--extra-margin">
			<input type="submit" class="btn btn--full-width btn--border-green btn--large" value="<?php esc_attr_e( 'Zaktualizuj profil', 'theme-my-login' ); ?>" name="submit" id="submit" />
		</div>
		<div class="form-field">
			<label for="password1"><?php _e( 'Nowe hasło', 'theme-my-login' ); ?></label>

				<input class="hidden" value=" " /><!-- #24364 workaround -->
				<div>
					<span class="password-input-wrapper0">
						<input type="password" name="pass1" id="password1" value="" autocomplete="off" aria-describedby="pass-strength-result"/>
					</span>
					<div id="pass-strength-result" aria-live="polite"></div>
				</div>
		</div>
		<div class="form-field">
			<label for="password2"><?php _e( 'Powtórz nowe hasło', 'theme-my-login' ); ?></label>
			<input name="pass2" id="password2" type="password" class="regular-text" value="" autocomplete="off"/>
		</div>

		<script type='text/javascript'>
		var password = document.getElementById("password1"),
				confirm_password = document.getElementById("password2");

		function validatePassword(){
		  if(password.value != confirm_password.value) {
		    confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
		    confirm_password.setCustomValidity('');
		  }
		}

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
		</script>
		<?php endif; ?>

		</table>

		<?php// do_action( 'show_user_profile', $profileuser ); ?>

		<p class="tml-submit-wrap">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="btn btn--full-width btn--border-green btn--large" value="<?php esc_attr_e( 'Zmień hasło', 'theme-my-login' ); ?>" name="submit" id="submit" />
		</p>
	</form>
</div>
