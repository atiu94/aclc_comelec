<?php
if($candidates->num_rows())
{
	?>
	<form method="post">
		<table class="table-list table-striped table-bordered">
			<thead>
				<tr>
					<th class="checkbox skip-sort"><input type="checkbox" class="select-all" value="can_ids" /></th>
					<th>First Name</th>
					<th>Middle Name</th>
					<th>Last Name</th>
					<th>Votes</th>
					<th style="width: 60px;"></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($candidates->result() as $candidate)
			{
				?>
				<tr>
					<td class="center"><input type="checkbox" name="can_ids[]" value="<?php echo $candidate->can_id; ?>" /></td>
					<td><a href="<?php echo site_url('admin/candidates/view/' . $candidate->can_id); ?>"><?php echo $candidate->can_first_name; ?></a></td>
					<td><?php echo $candidate->can_middle_name; ?></td>
					<td><?php echo $candidate->can_last_name; ?></td>
					<td><?php echo number_format($candidate->can_votes); ?></td>
					<td class="center"><a href="<?php echo site_url('admin/candidates/edit/' . $candidate->can_id); ?>" class="btn">Edit</a></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php echo $candidates_pagination; ?>
		<div class="choose-select">
			With selected:
			<select name="form_mode" class="select-submit">
				<option value="">choose...</option>
				<option value="delete">Delete Candidates</option>
			</select>
		</div>
	</form>
	<?php
}
else
{
	?>
	No candidates found.
	<?php
}
?>