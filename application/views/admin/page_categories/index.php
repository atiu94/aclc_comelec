<?php
if($page_categories->num_rows())
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
					<th class="checkbox skip-sort"><input type="checkbox" class="select-all" value="pct_ids" /></th>
					<th>Category Name</th>		
				</tr>
			</thead>
			<tbody>
		<?php
		foreach($page_categories->result() as $page_category)
		{
			?>
			<tr>
				<td class="center"><input type="checkbox" name="pct_ids[]" value="<?php echo $page_category->pct_id; ?>" /></td>			
				<td><a href="<?php echo site_url('admin/page_categories/edit/' . $page_category->pct_id); ?>"><?php echo $page_category->pct_name; ?></a></td>		
			</tr>
			<?php
		}
		?>
			</tbody>
		</table>
		<?php echo $page_categories_pagination; ?>
		<div class="choose-select">
			With selected: 
			<select name="form_mode" class="select-submit">
				<option value="">choose...</option>
				<option value="delete">Delete Page Categories</option>
			</select>
		</div>
	</form>
	<?php
}
else
{
	?>
	No page categories found.
	<?php
}
?>