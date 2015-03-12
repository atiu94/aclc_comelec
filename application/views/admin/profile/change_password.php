<form method="post">
	<table class="table-form table-bordered">
		<tr>
			<th>Old Password</th>
			<td><input type="password" name="old_password" /></td>
		</tr>
		<tr>
			<th>New Password</th>
			<td><input type="password" name="new_password" /></td>
		</tr>
		<tr>
			<th>Retype New Password</th>
			<td><input type="password" name="new_password2" /></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
				<a href="<?php echo site_url('admin/profile'); ?>" class="btn">Back</a>
			</td>
		</tr>
	</table>
</form>