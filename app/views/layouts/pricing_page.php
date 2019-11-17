<!DOCTYPE html>
<html>
<head>
    <title><?=get_option("website_title", "X-Pload - Social Marketing Tool")?></title>
    <meta name="description" content="<?=get_option("website_description", "save time, do more, manage multiple social networks at one place")?>" />
    <meta name="keywords" content="<?=get_option("website_keyword", 'social marketing tool, social planner, automation, social schedule')?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?=get_option("website_favicon", BASE.'assets/img/favicon.png')?>" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/bootstrap/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/font-feather/feather.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/font-ps/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/layout.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/pricing-page.css">
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        var token = '<?=$this->security->get_csrf_hash()?>',
            PATH  = '<?=PATH?>',
            BASE  = '<?=BASE?>';
            GOOGLE_API_KEY   = 'AIzaSyA7rE-ngRgga_EJ38xZpAJkukB1bCoxOV0';
            GOOGLE_CLIENT_ID = '1088992811074-98f4e7d22gebaodjfa94hfdimnmvk6cl.apps.googleusercontent.com';

            document.onreadystatechange = function () {
                var state = document.readyState
                if (state == 'complete') {
                    setTimeout(function(){
                        document.getElementById('interactive');
                        document.getElementById('loading-overplay').style.opacity ="0";
                    },500);

                    setTimeout(function(){
                        document.getElementById('loading-overplay').style.display ="none";
                        document.getElementById('loading-overplay').style.opacity ="1";
                    },1000);
                }
            }
    </script>
</head>
<body>
    <div class="loading-overplay" id="loading-overplay"><div class='loader loader1'><div><div><div><div><div><div></div></div></div></div></div></div></div></div>
    <?=$template['body']?>

    <script type="text/javascript" src="<?=BASE?>assets/js/moment.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/plugins/izitoast/js/iziToast.min.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/js/landing-page.js"></script>
    <script type="text/javascript" src="<?=BASE?>assets/js/main.js"></script>
    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</html>

