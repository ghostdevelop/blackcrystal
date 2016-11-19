<?php 
class WebcreativesLoginWidget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'login', 'description' => "Bejelentkezés");
		$this->WP_Widget(false, 'Bejelentkezés', $widget_ops);
	}

	function widget($args, $instance) {
		global $user_ID, $user_identity, $user_level, $user_email, $user_login;
		extract($args);
		echo $before_widget;
		echo $before_title;
		if ($user_ID):
			echo $user_identity;
			echo $after_title;
		else:
			echo 'Bejelentkezés';
			echo $after_title;
			?>
			<form action="<?php bloginfo('wpurl') ?>/wp-login.php" method="post" name="login" id="form-login">
				<fieldset class="input" style="border: 0 none;">
					<p id="form-login-username">
						<label for="log"><?php echo 'Felhasználónév';?></label>
						<br>
						<input type="text" name="log" id="log" value="<?php echo esc_attr(stripslashes($user_login), 1) ?>"  size="20" />
					</p>
					<p id="form-login-password">
						<label for="pwd"><?php echo "Jelszó"; ?></label>
						<br>
						<input type="password" name="pwd" id="pwd" size="20" /><br />
					</p>
					<p id="form-login-remember">
						<label for="rememberme"><?php echo 'Emlékezz rám' ?></label>
						<input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" />
					</p>
					<input class="art-button" type="submit" name="submit" value="<?php echo 'Bejelentkezés'; ?>" />
				</fieldset>
				<input type="hidden" name="redirect_to" value="<?php echo theme_get_current_url(); ?>"/>
			</form>
			<ul>
				<?php if (get_option('users_can_register')) { ?>
				<li><a href="<?php bloginfo('wpurl') ?>/webaruhaz/regisztracio/"><?php echo "Regisztráció"; ?></a></li>
				<?php } ?>
				<li><a href="<?php bloginfo('wpurl') ?>/wp-login.php?action=lostpassword"><?php _e("Elfelejtett jelszó", THEME_NS); ?></a></li>
			</ul>
		<?php endif;
		echo $after_widget;
	}
}
?>