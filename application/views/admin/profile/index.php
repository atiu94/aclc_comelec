<table class="table-form table-bordered">
	<tr>
		<th>Username</th>
		<td><?php echo $account->acc_username; ?></td>
	</tr>
	<tr>
		<th>Account Type</th>
		<td><?php echo $account->acc_type; ?></td>
	</tr>
	<tr>
		<th>Password</th>
		<td><a href="<?php echo site_url('admin/profile/change_password'); ?>">Change Password</a></td>
	</tr>
</table>