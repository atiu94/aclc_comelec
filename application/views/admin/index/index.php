
<div style="margin-top: 4em;">


	<form class="form-signin" method="post" action="<?php echo site_url('admin/index'); ?>">
		<div class="jumbotron">
	        <h2 class="form-signin-heading" style="margin-top:10px; color:white;">Please sign in</h2>
	        <input type="email" class="form-control" placeholder="Email address" name="acc_username" required autofocus>
	        <input type="password" class="form-control" placeholder="Password" name="acc_password" required>
	        <div class="checkbox">
	          <label style="color:white;" class="pull-right">
	           <input type="checkbox" value="remember-me"><font size="3"> Remember me</font>
	          </label>
	        </div>

			<?php if($show_captcha == true): ?>
			<label>Type the word below</label>
			<div class="form-group">
					<img id="captcha" src="<?php echo res_url('mythos/securimage/securimage_show.php'); ?>" alt="CAPTCHA Image" /><br />
					<input type="text" name="captcha_code" class="form-control" /><br />
					<a href="#" onclick="document.getElementById('captcha').src = '<?php echo res_url('mythos/securimage/securimage_show.php'); ?>?' + Math.random(); return false">Try a different image</a>
			</div>
			<?php endif; ?>
	        <input type="hidden" value="<?php echo $this->session->flashdata('current_url'); ?>" name="current_url" id="current_url"/>
	        <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Login" />
		</div>

	</form>

</div>
