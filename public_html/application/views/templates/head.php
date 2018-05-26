<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="author" content="Plan B">
		<meta name="description" content="TUTORING WEBSITE">
		
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!--<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>-->
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Indie+Flower">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rammetto+One">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Cookie">
		

		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/utility.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/addition.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/layout.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/stylization.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/style-js/utility.style.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/style-js/fixed-dynamic.style.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/popups.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/config.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/views.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/ajax/actions.ajax.js"></script>
<?php
	if (isset($scripts) && $scripts != null)
		foreach ($scripts as $script)
			echo '<script type="text/javascript" src="'.base_url().$script.'"></script>';
?>		
		<link rel="icon" href="<?php echo base_url(); ?>assets/res/favicon.ico">
		<title>Tutor Center - <?= $title ?></title>
<?php if (isset($scriptAddon) && $scriptAddon !== null) { ?>
		<script type="text/javascript">
			<?php echo $scriptAddon; ?>
		</script>
<?php } ?>
	</head>
	<body class="fillup">
		<div id="wrapper" class="border-boxed expanded fillup">