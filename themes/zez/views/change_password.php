<?=Modules::run(get_theme()."/header", false)?>>
    
    <section class="login-page">
        <div class="login-form">
            <div class="logo">
                <a href="<?=cn()?>"><img class="logo-black" src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
            </div>
            <form class="actionForm" action="<?=cn("auth/ajax_change_password")?>" data-redirect="<?=cn('auth/login')?>" method="POST">
            <div class="login-box mb-3">
                <div class="text-welcome">
                    <h3><?=lang("new_password")?></h3>
                    <p><?=lang("enter_your_new_password_to_continue")?>.</p>
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
                    <input type="hidden" class="form-control" id="reset_key" name="reset_key" value="<?=segment(3)?>">
                </div>
                <div class="notify"></div>
                <button type="submit" class="btn btn-primary btn-block btn-singin ladda-button" data-style="zoom-in"><?=lang("change_password")?></button>
            </div>
            </form>
        </div>
    </section>

<?=Modules::run(get_theme()."/footer", false)?>