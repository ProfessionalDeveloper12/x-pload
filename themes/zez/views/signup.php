<?=Modules::run(get_theme()."/header", false)?>
	
	<section class="login-page">
		<div class="login-form">
			<div class="logo">
				<a href="<?=cn()?>"><img class="logo-black" src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
			</div>

			<form action="<?=cn('auth/ajax_register')?>" data-redirect="<?=cn('auth/login')?>" class="actionForm" method="POST">
			<div class="login-box mb-3">
				<div class="text-welcome">
					<h3><?=lang("register_now")?></h3>
					<p><?=lang("create_your_account_and_enjoy")?></p>
				</div>		
				<div class="input-group mb-3">
				  	<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon-fullname">
				    		<i class="la la-user"></i>
				    	</span>
				  	</div>
				  	<input type="text" class="form-control" name="fullname" placeholder="<?=lang("fullname")?>" aria-label="<?=lang("fullname")?>" aria-describedby="basic-addon-fullname">
				</div>
				<div class="input-group mb-3">
				  	<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon-email">
				    		<i class="la la-envelope"></i>
				    	</span>
				  	</div>
				  	<input type="email" class="form-control" name="email" placeholder="<?=lang("email")?>" aria-label="<?=lang("email")?>" aria-describedby="basic-addon-email" value="<?=get("email")?>">
				</div>
				<div class="input-group mb-3">
				  	<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon-password">
				    		<i class="la la-unlock"></i>
				    	</span>
				  	</div>
				  	<input type="password" class="form-control" name="password" placeholder="<?=lang("password")?>" aria-label="<?=lang("password")?>" aria-describedby="basic-addon-password">
				</div>
				<div class="input-group mb-3">
				  	<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon-confirm-password">
				    		<i class="la la-unlock"></i>
				    	</span>
				  	</div>
				  	<input type="password" class="form-control" name="confirm_password" placeholder="<?=lang("confirm_password")?>" aria-label="<?=lang("confirm_password")?>" aria-describedby="basic-addon-confirm-password">
				</div>
				<div class="input-group mb-3">
				  	<div class="input-group-prepend">
				    	<span class="input-group-text" id="basic-addon-timezone">
				    		<i class="la la-clock-o"></i>
				    	</span>
				  	</div>
				  	<select name="timezone" class="form-control auto-select-timezone" aria-describedby="basic-addon-timezone">
                        <?php if(!empty(tz_list())){
                        foreach (tz_list() as $value) {
                        ?>
                        <option value="<?=$value['zone']?>"><?=$value['time']?></option>
                        <?php }}?>
                    </select>
				</div>
				<?php if(get_option('google_captcha_enable', 0) == 1 && get_option('google_captcha_client_id', '') != "" && get_option('google_captcha_client_secret', '') != ""){?>
				<div class="input-group mb-3">
					<div class="g-recaptcha" data-sitekey="<?=get_option('google_captcha_client_id', '')?>"></div>
				</div>
				<?php }?>
				<div class="mb-3">
					<input class="inp-cbx" name="terms" id="cbx" type="checkbox" style="display: none;"/>
					<label class="cbx" for="cbx"><span>
					    <svg width="12px" height="10px" viewbox="0 0 12 10">
					      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
					    </svg></span><span><?=lang("I agree to all")?> <a href="<?=cn("p/terms_and_policies")?>"><?=lang("Terms of Services")?></a></span>
					</label>
            	</div>
            	<div class="notify"></div>
				<button type="submit" class="btn btn-primary btn-block btn-singin ladda-button" data-style="zoom-in"><?=lang("sign_up")?></button>
			</div>
			</form>
			<div class="text-try-now">
				<?=lang("already_have_an_account")?> <a href="<?=cn("auth/login")?>"><?=lang("sign_in")?></a>
			</div>
		</div>
	</section>

<?=Modules::run(get_theme()."/footer", false)?>