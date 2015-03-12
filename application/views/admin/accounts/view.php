<table class="table-form table-bordered">
	<tr>
		<th>Email</th>
		<td><?php echo $account->acc_username; ?></td>
	</tr>
	<tr>
		<th>Name</th>
		<td><?php echo $account->acc_first_name . ' ' . $account->acc_last_name; ?></td>
	</tr>
	<tr>
		<th>Account Type</th>
		<td><?php echo $account->acc_type; ?></td>
	</tr>
	<tr>
		<th>Password</th>
		<td>
			<a href="<?php echo site_url('admin/accounts/reset_password/' . $account->acc_id); ?>">Reset Password</a>
		</td>
	</tr>
</table>