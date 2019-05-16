<div class="tml tml-lostpassword" id="theme-my-login<?php $template->the_instance(); ?>">
	<form name="lostpasswordform" id="lostpasswordform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'lostpassword', 'login_post' ); ?>" method="post">
		<p class="tml-user-login-wrap">
			<label for="user_login<?php $template->the_instance(); ?>"><?php
			if ( 'email' == $theme_my_login->get_option( 'login_type' ) ) {
				_e( 'Adres email:', 'theme-my-login' );
			} else {
				_e( 'Username or E-mail:', 'theme-my-login' );
			} ?></label>
			<input type="email" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" required autofocus />
		</p>

		<?php do_action( 'lostpassword_form' ); ?>

		<p class="tml-submit-wrap">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Wyślij link', 'theme-my-login' ); ?>" class="btn btn--large btn--green"/>
			<input type="hidden" name="redirect_to" value="/haslo-wyslane" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="lostpassword" />
		</p>
	</form>
	<div class="alert alert-danger"><?php $template->the_errors(); ?></div>
	<?php //$template->the_action_links( array( 'lostpassword' => false ) ); ?>
</div>
