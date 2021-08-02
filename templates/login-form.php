<div class="tml tml-login" id="theme-my-login<?php $template->the_instance(); ?>">

	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login', 'login_post' ); ?>" method="post">
		<p class="tml-user-login-wrap">
			<label for="user_login<?php $template->the_instance(); ?>"><?php
				if ( 'username' == $theme_my_login->get_option( 'login_type' ) ) {
					_e( 'Nazwa użytkownika', 'pkpk' );
				} elseif ( 'email' == $theme_my_login->get_option( 'login_type' ) ) {
					_e( 'Adres e-mail', 'pkpk' );
				} else {
					_e( 'Nazwa użytkownika lub email', 'pkpk' );
				}
			?></label>
			<input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" required autofocus />
		</p>

		<p class="tml-user-pass-wrap">
			<label for="user_pass<?php $template->the_instance(); ?>"><?php _e( 'Hasło', 'pkpk' ); ?></label>
			<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="input" value="" size="20" autocomplete="off" required />
		</p>

		<?php do_action( 'login_form' ); ?>

		<div class="tml-rememberme-submit-wrap">
			<?php $template->the_action_links( array( 'login' => false ) ); ?>
			<p class="tml-rememberme-wrap">
				<input name="rememberme" type="hidden" id="rememberme<?php $template->the_instance(); ?>" value="forever" />
			</p>

			<p class="tml-submit-wrap">
				<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Zaloguj', 'pkpk' ); ?>" class="btn btn--large btn--green" />
				<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
				<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
				<input type="hidden" name="action" value="login" />
			</p>
		</div>
		<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>

		<div class="status alert alert-danger"><?php $template->the_errors(); ?></div>
	</form>
</div>
