<?=Modules::run(get_theme()."/header", false)?>

    <section class="login-page">
        <div class="login-form">
            <div class="logo">
                <a href="<?=cn()?>"><img class="logo-black" src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>"></a>
            </div>
            <div class="login-box mb-3">
                <div class="text-welcome">
                    <h3 class="text-success"><?=lang("activation_successfully")?></h3>
                    <p><?=lang("your_account_has_been_registered_successfully")?>.</p>
                </div>      
                <a href="<?=cn("auth/login")?>" class="btn btn-primary btn-block btn-singin"><?=lang("start_now")?></a>
            </div>
        </div>
    </section>

<?=Modules::run(get_theme()."/footer", false)?>