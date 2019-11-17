<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title> <?=lang('404_page_not_found')?></title>
<style type="text/css">

body {
	background-color: #eae9e8;
}

#container {
	max-width: 700px;
	margin: auto;
	text-align: center;
}

#container img{
	width: 100%;
	display: inline-block;
}

</style>
</head>
<body>
	<div id="container">
		<a href="<?=PATH?>"><img src="<?=BASE?>assets/img/404.gif"></a>
	</div>
</body>
</html>