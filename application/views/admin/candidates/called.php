<?php
if($candidates->num_rows())
{
	?>

<div class="alert alert-info">Select the candidates who are <span class="label label-info">called</span> This system assumes that unselected candidates are not called. 
</div>
<form method="post">

	<table class="table-list table-striped table-bordered">
		<thead>
			<tr>
				<th></th>
				<th>Candidate Name</th>		
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($candidates->result() as $candidate)
		{
			?>
			<tr>
				<td class="center"><input type="checkbox" name="can_ids[]" value="<?php echo $candidate->can_id; ?>" /></td>
				<td><a href="<?php echo site_url('admin/candidates/view/' . $candidate->can_id); ?>"><?php echo $candidate->can_first_name; ?> <?php echo $candidate->can_last_name; ?></a></td>	
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>

<br>

	<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
	<a href="<?php echo site_url('admin/votes'); ?>" class="btn">Back</a>
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