<!DOCTYPE html>
<html>
<head>
    <title><?=get_option("website_title", "X-Pload - Social Marketing Tool")?></title>
    <meta name="description" content="<?=get_option("website_description", "save time, do more, manage multiple social networks at one place")?>" />
    <meta name="keywords" content="<?=get_option("website_keyword", 'social marketing tool, social planner, automation, social schedule')?>"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?=get_option("website_favicon", BASE.'assets/img/favicon.png')?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/thankyou.css">
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/css/layout.css">
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery/jquery.min.js"></script>
</head>
<body>
    <?=$template['body']?>    

<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/instagram.js"></script>
<?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</html>