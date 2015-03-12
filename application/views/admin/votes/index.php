<?php
if($votes->num_rows())
{
	?>
	<form method="post">
		<table class="table-list table-striped table-bordered">
			<thead>
				<tr>
					<th class="checkbox skip-sort"><input type="checkbox" class="select-all" value="vot_ids" /></th>

					<th style="width: 60px;"></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($votes->result() as $vote)
			{
				?>
				<tr>
					<td class="center"><input type="checkbox" name="vot_ids[]" value="<?php echo $vote->vot_id; ?>" /></td>

					<td class="center"><a href="<?php echo site_url('admin/votes/edit/' . $vote->vot_id); ?>" class="btn">Edit</a></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php echo $votes_pagination; ?>
		<div class="choose-select">
			With selected:
			<select name="form_mode" class="select-submit">
				<option value="">choose...</option>
				<option value="delete">Delete Votes</option>
			</select>
		</div>
	</form>
	<?php
}
else
{
	?>
	No votes found.
	<?php
}
?>