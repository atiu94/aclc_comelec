<form method="post">
	<table class="table-form table-bordered">
		<tr>
			<th>Number of Voters</th>
			<td><input type="number" name="set_count" size="30" maxlength="3" value="" /></td>
		</tr>

			<th></th>
			<td>
				
				<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
				<a href="<?php echo site_url('admin/candidates'); ?>" class="btn">Back</a>
			</td>
		</tr>
	</table>
</form>