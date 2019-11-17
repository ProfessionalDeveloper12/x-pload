<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?=get_option("website_title", "X-Pload - Social Marketing Tool")?></title>
	<meta name="description" content="<?=get_option("website_description", "save time, do more, manage multiple social networks at one place")?>" />
    <meta name="keywords" content="<?=get_option("website_keyword", 'social marketing tool, social planner, automation, social schedule')?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?=get_option("website_favicon", BASE.'assets/img/favicon.png')?>" />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=get_option("website_logo_white", BASE.'assets/img/logo-white.png')?>">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/zez/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/zez/assets/css/responsive.css"> 
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/zez/assets/plugins/ladda/ladda-themeless.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/zez/assets/fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>themes/zez/assets/fonts/font-awesome/css/font-awesome.min.css">
   
 
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js"></script>
    <?php if(get_option('google_captcha_enable', 0) == 1 && get_option('google_captcha_client_id', '') != "" && get_option('google_captcha_client_secret', '') != ""){?>
    	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php }?>
    <script type="text/javascript">
        var token = '<?=$this->security->get_csrf_hash()?>',
            PATH  = '<?=PATH?>',
            BASE  = '<?=BASE?>';
    </script>

</head>
<body>
	<div class="preloader"></div><!-- /.preloader -->
	<div class="page-wrapper">

	<?php if($show){?>
	<header class="site-header header-one">
        <nav class="navbar navbar-expand-lg navbar-light header-navigation stricky">
            <div class="container clearfix">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="logo-box clearfix">
                    <a class="navbar-brand" href="<?=PATH?>">
						<img class="main-logo " src="<?=get_option("website_logo_black", BASE.'assets/img/logo-black.png')?>">
                    </a>
                    <button class="menu-toggler" data-target=".header-one .main-navigation">
                        <span class="fa fa-bars"></span>
                    </button>
                </div><!-- /.logo-box -->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="main-navigation">
                    <ul class=" navigation-box one-page-scroll-menu ">
                        <li class="current scrollToLink">
                            <a href="<?=PATH?>#home"><?=lang("home")?></a>
                        </li>
                        <li class="scrollToLink">
                            <a href="<?=PATH?>#features"><?=lang("features")?></a>
                        </li>
                        <?php if(get_payment()){?>
                        <li class="scrollToLink">
                            <a href="<?=PATH?>#pricing"><?=lang("pricing")?></a>
                            
                        </li>
                        <?php }?>
                        <li class="scrollToLink">
                            <a href="<?=PATH?>blog"><?=lang("blog")?></a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
                <div class="right-side-box">
			    	<?php if(!session("uid")){?>
				      	<a href="<?=cn("auth/login")?>" class="header-one__btn"><?=lang("login")?></a>
				      	<?php if(get_option("singup_enable", 1)){?>
				      		<a href="<?=cn("auth/signup")?>" class="header-one__btn"><?=lang("signup")?></a>
			      		<?php }?>
			      	<?php }else{?>
			      	<a href="<?=cn("account_manager")?>" class="header-one__btn"><?=lang("dashboard")?></a>
			      	<?php }?>

			      	<?php 
                    $lang_default = get_default_language();
                    if(!empty($lang_default)){
                    ?>
                    <div class="btn-group btn-lang">
					  	<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    	<?=$lang_default->name?>
					  	</button> 
					  	<div class="dropdown-menu">
					  		<?php if(!empty($languages)){
	                        foreach ($languages as $key => $value) {
	                        ?>
						    <a class="dropdown-item actionItem" href="<?=cn('set_language')?>" data-redirect="<?=current_url()?>" data-id="<?=$value->code?>"><?=$value->name?></a>
						    <?php }}?>
					  	</div>
					</div>
                    <?php }?>
                </div><!-- /.right-side-box -->
            </div>
            <!-- /.container -->
        </nav>
    </header><!-- /.header-one -->
	<?php }?>