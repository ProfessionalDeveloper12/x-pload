<?=Modules::run(get_theme()."/header", false)?>
	
	<section class="login-page">
		<div class="login-form">
			<div class="logo">
				<a href="<?=cn()?>"><img class="logo-black" src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
			</div>
			<form class="actionForm" action="<?=cn("auth/ajax_forgot_password")?>">
			<div class="login-box mb-3">
				<div class="text-welcome">
					<h3><?=lang("recovery_password")?></h3>
					<p><?=lang("enter_your_email_to_get_new_password_and_continue")?></p>
				</div>	
				<div class="input-group mb-3">
				  	<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon1">
				    		<i class="la la-envelope"></i>
				    	</span>
				  	</div>
				  	<input type="email" class="form-control" name="email" placeholder="<?=lang("email")?>" aria-label="<?=lang("email")?>" aria-describedby="basic-addon1">
				</div>
				<div class="notify"></div>
				<button type="submit" class="btn btn-primary btn-block btn-singin ladda-button" data-style="zoom-in"><?=lang("submit")?></button>
			</div>
			</form>
		</div>
	</section>

<?=Modules::run(get_theme()."/footer", false)?>