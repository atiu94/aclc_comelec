<table class="table-form table-bordered">
	<tr>
		<th>First Name</th>
		<td><?php echo $candidate->can_first_name; ?></td>
	</tr>
	<tr>
		<th>Middle Name</th>
		<td><?php echo $candidate->can_middle_name; ?></td>
	</tr>
	<tr>
		<th>Last Name</th>
		<td><?php echo $candidate->can_last_name; ?></td>
	</tr>
	<tr>
		<th>Votes</th>
		<td><?php echo number_format($candidate->can_votes); ?></td>
	</tr>
	<tr>
		<th>Quota</th>
		<td><?php echo number_format($candidate->can_quota); ?></td>
	</tr>
	<tr>
		<th></th>
		<td>
			<a href="<?php echo site_url('admin/candidates/edit/' . $candidate->can_id); ?>" class="btn btn-primary">Edit</a>
			<a href="<?php echo site_url('admin/candidates'); ?>" class="btn">Back</a>
		</td>
	</tr>
</table>