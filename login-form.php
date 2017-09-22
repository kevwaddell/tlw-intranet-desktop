<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php if (is_page_template( 'login-page.php' )) { ?>
	<h1>Sign in to <?php bloginfo('name');?> <?php bloginfo('description');?></h1>
	<?php } ?>
	
	<?php $template->the_action_template_message( 'login' ); ?>
	<?php $template->the_errors(); ?>
	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
	
		<input style="display:none" type="text" name="fakeusernameremembered"/>
		<input style="display:none" type="password" name="fakepasswordremembered"/>
		
		<div class="form-group">
			<input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" autocomplete="off" class="input form-control" placeholder="User ID" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />
		</div>
		<div class="form-group">
			<?php if (!is_page_template( 'login-page.php' )) { ?>
			<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" autocomplete="off" class="input form-control" placeholder="Password" value="" size="20" />
			<?php } else { ?>
				
			<div class="input-group">
				<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" autocomplete="off" class="input form-control" placeholder="Password" value="" size="20" />
				<span class="input-group-btn">
					<button type="submit" name="wp-submit" class="btn btn-default" id="wp-submit<?php $template->the_instance(); ?>"><i class="fa fa-angle-right fa-lg"></i></button>
				</span>
			</div>
			
			<?php } ?>
		</div>

		<?php do_action( 'login_form' ); ?>

		<div class="checkbox text-center">
			<label for="rememberme<?php $template->the_instance(); ?>">
			<input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" /> <?php esc_attr_e( 'Keep me signed in' ); ?>
			</label>
		</div>

			<?php if (!is_page_template( 'login-page.php' )) { ?>
			<div class="form-group submit">
			<input type="submit" name="wp-submit" class="btn btn-default btn-block" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Log In' ); ?>" />
			</div>
			<?php } ?>
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="login" />
		
	</form>
	<?php if (!is_page_template( 'login-page.php' )) { ?>
	<?php $template->the_action_links( array( 'login' => false ) ); ?>
	<?php } ?>
</div>

<?php if (is_page_template( 'login-page.php' )) { ?>
<footer class="user-footer"><?php $template->the_action_links( array( 'login' => false ) ); ?></footer>
<?php } ?>
