
<html lang="en">
<head>
	<title><?php echo template('title'); ?> | Administration Panel</title>
	<meta charset="utf-8">	
	<?php //echo template('mythos'); ?>
	<script type="text/javascript" src="<?php echo res_url('mythos/js/jquery.min.js'); ?>"></script>
	
	<script type="text/javascript" src="<?php echo res_url('mythos/js/jquery.floodling.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo res_url('mythos/js/jquery.validate.complete.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo res_url('mythos/js/jquery-ui-1.8.16.custom.min.js'); ?>"></script>	
	<script type="text/javascript" src="<?php echo res_url('mythos/js/utils.js'); ?>"></script>


	<?php echo template('bootstrap'); ?>
	<?php echo template('head'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo res_url('admin/css/styles.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo res_url('admin/css/custom.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo res_url('mythos/css/jquery-ui-1.8.16.custom.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo res_url('mythos/css/jquery-ui-extended.css'); ?>" />


	<link rel="shortcut icon" href="<?php echo res_url('admin/images/Motolite.ico'); ?>">
</head>


<body class="<?php echo uri_css_class(); ?>">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header col-sm-4">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" style="color:white;" href="<?php echo site_url('admin/candidates'); ?>">ACLC COMELEC Voting System</a>
		</div>


		

		<div class="collapse navbar-collapse col-sm-8 pull-right" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">

			<?php if($this->access_control->check_logged_in()):?>

	

			<?php if($this->access_control->check_account_type('admin')):?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;"  data-toggle="dropdown">Candidates <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('admin/candidates/results'); ?>">Voting Results</a></li>
						<li><a href="<?php echo site_url('admin/candidates/called'); ?>">Set Eligibility</a></li>
						<li><a href="<?php echo site_url('admin/candidates'); ?>">Candidate List</a></li>	
						<li><a href="<?php echo site_url('admin/candidates/create'); ?>">Add Candidate</a></li>	

					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;"  data-toggle="dropdown">Votes <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('admin/votes/create'); ?>">Cast Vote</a></li>			
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;"  data-toggle="dropdown">Settings<b class="caret"></b></a>
					<ul class="dropdown-menu">
					<li><a href="<?php echo site_url('admin/settings/votes'); ?>">Set Population</a></li>
						<li><a href="<?php echo site_url('admin/votes/create'); ?>">Cast Votes</a></li>			
					</ul>
				</li>
			<?php endif; ?>
			
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;"  data-toggle="dropdown"><?php echo $this->session->userdata('acc_name'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('admin/profile'); ?>">Profile</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('admin/index/logout'); ?>">Logout</a></li>
					</ul>
				</li>



		    <?php else:?>
			
				<li><a href="<?php echo site_url('admin/login'); ?>" style="color:white;" >Login</a></li>
			<?php endif;?>
			
			</ul>
		</div><!-- /.navbar-collapse -->
	


		
	</div><!-- /.container-fluid -->
</nav>


<div class="wrapper" style="height: 50px"></div>
<div class="container" style="padding-top: 1em">
	
	<?php echo template('notification'); ?>
	<div class="content-header">
		<h1 class="page-title"><?php echo template('title'); ?></h1>
		<?php echo template('page-nav'); ?>
		<div class="clearfix"></div>
	</div>
	<div class="content-body">
		<?php echo template('content'); ?>
	</div>
	
</div>

<footer style="clear: both; position: relative; z-index: 10;height: 3em; margin-top: 2em;">
	<div class="container text-center">
	<p>&copy; 2015 | ACLC Voting System<br>
	Ateneo de Manila University</p>
	</div>
</footer>







</body>
</html>

