
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
			<a class="navbar-brand" style="color:white;" href="<?php echo site_url('admin/dashboard'); ?>">PBI IT Asset Inventory System</a>
		</div>


		

		<div class="collapse navbar-collapse col-sm-8 pull-right" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">

			<?php if($this->access_control->check_logged_in()):?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;" data-toggle="dropdown">Assets<span class="caret"></span></a>
					<ul class="dropdown-menu" style="color:white;" role="menu">
						<li><a href="<?php echo site_url('admin/hardware_assets'); ?>">Manage</a></li>
						
					<?php if($this->access_control->check_account_type('admin')  ):?>
						<li><a href="<?php echo site_url('admin/hardware_assets/create'); ?>">Add</a></li>
						<li><a id="import" href="<?php echo site_url('admin/uploads/hardware_assets'); ?>" role="button" data-toggle="modal">Import CSV</a></li>
					<?php endif; ?>

					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;" data-toggle="dropdown">Employees<span class="caret"></span></a>
					<ul class="dropdown-menu" style="color:white;" role="menu">
						<li><a href="<?php echo site_url('admin/employees'); ?>">Manage</a></li>
						
					<?php if($this->access_control->check_account_type('admin')  ):?>	
						<li><a href="<?php echo site_url('admin/employees/create'); ?>">Add</a></li>
						<li><a href="<?php echo site_url('admin/uploads/employees'); ?>" role="button" data-toggle="modal">Import CSV</a></li>
					<?php endif; ?>

					</ul>
				</li>

			<?php if($this->access_control->check_account_type('admin')):?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;" data-toggle="dropdown">Accounts<span class="caret"></span></a>
					<ul class="dropdown-menu" style="color:white;" role="menu">
						<li><a href="<?php echo site_url('admin/accounts'); ?>">Manage</a></li>
						<li><a href="<?php echo site_url('admin/accounts/create'); ?>">Add</a></li>
					</ul>
				</li>
			<?php endif; ?>
			
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color:white;"  data-toggle="dropdown"><?php echo $this->session->userdata('acc_name'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('admin/profile'); ?>">Profile</a></li>

				<?php if($this->access_control->check_account_type('admin')  ):?>	
					<form  method="post" action="<?php echo site_url("admin/hardware_assets/backup"); ?>" name="backup" id="backup">	
						<li><input type="submit" value="Backup Database" id="backup-li" style="margin-left:-5px;"></li>					
					</form>	
				<?php endif; ?>


						<li class="divider"></li>
						<li><a href="<?php echo site_url('admin/index/logout'); ?>">Logout</a></li>
					</ul>
				</li>
		        <li>
		          <a id="scanbutton" class="btn btn-danger navbar-btn" href="#scanbarcode" role="button" data-toggle="modal" style="color:white; padding:5px; margin-left:25px;">Scan Barcode</a>
		        </li>
		        <li>
		          <a id="findemployee" class="btn btn-danger navbar-btn" href="#findtagged" role="button" data-toggle="modal" style="color:white; padding:5px; margin-left:25px;">Find Employee</a>
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
	<p>&copy; 2014 | Summit Consulting Group<br>
	Ateneo de Manila University</p>
	</div>
</footer>




<div id = "scanbarcode" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<center><h3 class="no-margin exo-font">Scan Barcode</h3></center>
			</div>
			<center><div class = "modal-body">
				<div class="jumbotron">
					<h2 class="exo-font" style="margin-top:10px;">Scan Now...</h2>
					<form  method="post" action="<?php echo site_url("admin/hardware_assets/catch_barcode"); ?>"  name="barcode-form" id="barcode-form">
					    <input id="barcode" class="form-control" name="barcode" type="text">
					</form>
				</div>
			</div></center>
			<div class = "modal-footer">
				<button class = "btn btn-default btn-lg no-border-radius" data-dismiss = "modal" style="background-color: #95a5a6; outline: 0">Close</button>
			</div>
		</div>
	</div>
</div>


<div id = "findtagged" class = "modal fade">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<h3 class="no-margin exo-font">Find Employee</h3>
			</div>
			<center><div class = "modal-body">
				<div class="jumbotron">
					<h4>Find current assets tagged to a specific employee.</h4>
					<form  method="post" action="<?php echo site_url("admin/employees/catch_employee"); ?>"  name="employee-form" id="employee-form">
					    <input id="employee_id" class="form-control" name="employee_id" type="text">
					
				</div>
			</div></center>
			<div class = "modal-footer">
				<input class="btn btn-success btn-lg no-border-radius" name="submit" type="submit" style="border: none; outline: 0;">
					</form>
				<button class = "btn btn-default btn-lg no-border-radius" data-dismiss = "modal" style="background-color: #95a5a6; outline: 0;">Close</button>
			</div>
		</div>
	</div>
</div>




</body>
</html>

