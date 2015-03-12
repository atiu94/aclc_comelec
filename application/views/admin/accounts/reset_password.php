<form method="post">
	<table class="table-form table-bordered">
		<tr>
			<th>Account</th>
			<td>
				<?php echo $account->acc_first_name . ' ' . $account->acc_last_name; ?> (<?php echo $account->acc_username ?>)
				<input type="hidden" name="acc_username" />
			</td>
		</tr>
		<tr>
			<th>New Password</th>
			<td>
				<?php echo $acc_password; ?>
				<input type="hidden" name="acc_password" value="<?php echo $acc_password; ?>" />
			</td>
		</tr>
		<tr>
			<th></th>
			<td><span class="label label-warning">Please copy the password above.</span></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="submit" name="submit" value="Confirm" class="btn btn-primary" />
				<a href="<?php echo site_url('admin/accounts'); ?>" class="btn">Back</a>
			</td>
		</tr>
	</table>
</form>