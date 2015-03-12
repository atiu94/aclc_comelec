<form method="post">
	<table class="table-form table-bordered">
		<tr>
			<th>First Name</th>
			<td><input type="text" name="can_first_name" size="30" maxlength="30" value="" /></td>
		</tr>
		<tr>
			<th>Middle Name</th>
			<td><input type="text" name="can_middle_name" size="30" maxlength="30" value="" /></td>
		</tr>
		<tr>
			<th>Last Name</th>
			<td><input type="text" name="can_last_name" size="30" maxlength="30" value="" /></td>
		</tr>
		<tr>
			<th>Votes</th>
			<td><input type="text" name="can_votes" size="11" maxlength="11" value="" /></td>
		</tr>
		<tr>
			<th>Quota</th>
			<td><input type="text" name="can_quota" size="1" maxlength="1" value="" /></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
				<a href="<?php echo site_url('admin/candidates'); ?>" class="btn">Back</a>
			</td>
		</tr>
	</table>
</form>