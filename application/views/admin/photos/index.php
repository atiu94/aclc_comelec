<?php
if($albums->num_rows())
{
	?>
	<form method="post">
		<?php
		// Add the CSS class table-list to make it sortable with search and pagination.
		// To prevent a column from sorting, add the class skip-sort in the column.
		?>
		<table class="table-list table-striped table-bordered">
			<thead>
				<tr>
					<th class="checkbox skip-sort"><input type="checkbox" class="select-all" value="alb_ids" /></th>
					<th>Album Name</th>		
					<th style="width: 100px;">Photos</th>		
				</tr>
			</thead>
			<tbody>
		<?php
		foreach($albums->result() as $album)
		{
			?>
			<tr>
				<td class="center"><input type="checkbox" name="alb_ids[]" value="<?php echo $album->alb_id; ?>" /></td>			
				<td><a href="<?php echo site_url('admin/photos/album/' . $album->alb_id); ?>"><?php echo $album->alb_name; ?></a></td>		
				<td class="center">
					<?php
					$directory = BASEPATH . '../uploads/images/albums/' . $album->alb_slug;
					if (glob($directory . "/*.*") != false)
					{
						echo count(glob($directory . "/*.*"));
					}
					else
					{
						echo 0;
					}
					?>
				</td>		
			</tr>
			<?php
		}
		?>
			</tbody>
		</table>
		<?php echo $albums_pagination; ?>
		<div class="choose-select">
			With selected: 
			<select name="form_mode" class="select-submit">
				<option value="">choose...</option>
				<option value="delete">Delete Albums</option>
			</select>
		</div>
	</form>
	<?php
}
else
{
	?>
	No albums found.
	<?php
}
?>