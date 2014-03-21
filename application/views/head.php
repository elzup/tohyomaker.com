<?php

$title_text = '投票メーカー';
if (isset($title))
{
	$title_text = "$title - $title_text";
}
?>
<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <title><?=$title_text?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href='http://fonts.googleapis.com/css?family=Aldrich' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.0.0/build/cssreset/reset-min.css" />

    <!-- Bootstrap -->
    <link rel="stylesheet" charset="UTF-8" href="<?= base_url('lib/bootstrap/css/bootstrap.min.css') ?>" media="screen" />
    <link rel="stylesheet" charset="UTF-8" href="<?= base_url('lib/bootstrap/css/font-awesome.min.css') ?>" media="screen" />
		<?php $less_filename = 'style/' . (isset($less_name) ? $less_name : 'main') . '.less'; ?>
    <link rel="stylesheet/less" charset="UTF-8" type="text/css" href="<?= base_url($less_filename) ?>" media="screen">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script> <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script> <![endif]-->

  </head>
	<body>
    <div id="wrapper">
			<div id="alert-div">
				<?php get_alert(); ?>
			</div>