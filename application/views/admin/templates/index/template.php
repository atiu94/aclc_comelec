<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo template('title'); ?> | Administration Panel</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo res_url('admin/css/styles.css'); ?>" />
	<?php echo template('mythos'); ?>
	<?php echo template('bootstrap'); ?>
	<?php echo template('head'); ?>
	<link rel="shortcut icon" href="<?php echo res_url('admin/images/favicon.ico'); ?>">

</head>
<body class="<?php echo uri_css_class(); ?>">
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container center">
			<img src="<?php echo res_url('admin/images/logo.png'); ?>" />
		</div>
	</div>
</div>
<div class="clearfix" style="height: 50px"></div>
<div class="container">
	<div class="row">
		<div class="span4 offset4">
			<?php echo template('notification'); ?>
			<h1 class="center"><?php echo template('title'); ?></h1>
			<?php echo template('content'); ?>
		</div>
	</div>
</div>
</body>
</html>