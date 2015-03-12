<form method="post" action="<?php echo site_url('admin/index'); ?>">
	<table class="span3" style="margin: 0 auto; float: none;">
		<tr>
			<th class="left">Email</th>
		</tr>
		<tr>
			<td class="center"><input type="text" class="span3" name="acc_username" value="" /></td>
		</tr>
		<tr>
			<th class="left">Password</th>
		</tr>
		<tr>
			<td class="center"><input type="password" class="span3" name="acc_password" /></td>
		</tr>
		<?php
		if($show_captcha == true)
		{
		?>
		<tr>
			<th class="left">Type the word below</th>
		</tr>
		<tr>
			<td class="center">
				<p>
					<img id="captcha" src="<?php echo res_url('mythos/securimage/securimage_show.php'); ?>" alt="CAPTCHA Image" /><br />
					<input type="text" name="captcha_code" class="span3" /><br />
					<a href="#" onclick="document.getElementById('captcha').src = '<?php echo res_url('mythos/securimage/securimage_show.php'); ?>?' + Math.random(); return false">Try a different image</a>
				</p>
			</td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td class="center">
				<input type="hidden" value="<?php echo $this->session->flashdata('current_url'); ?>" name="current_url" id="current_url"/>
				<input type="submit" name="submit" value="Login" class="btn btn-primary btn-large" />
			</td>
		</tr>
	</table>
</form>