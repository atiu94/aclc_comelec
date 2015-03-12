<div>
	<select id="pct_filter">
		<option value="">All pages</option>
		<option value="0"><?php echo Page_category_model::UNCATEGORIZED; ?></option>
		<?php
		foreach($page_categories->result() as $page_category)
		{
			?>
			<option value="<?php echo $page_category->pct_id; ?>"><?php echo $page_category->pct_name; ?></option>
			<?php
		}
		?>
	</select>
</div>
<?php
if($pages->num_rows())
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
					<th class="checkbox skip-sort center"><input type="checkbox" class="select-all" value="pag_ids" /></th>
					<th>Title</th>
					<th style="width: 150px;">Category</th>
					<th style="width: 120px;">Date Published</th>
					<th style="width: 80px;">Status</th>
				</tr>
			</thead>
			<tbody>
		<?php
		foreach($pages->result() as $page)
		{
			if($page->pct_id == null)
			{
				$page->pct_name = Page_category_model::UNCATEGORIZED;
			}
			?>
			<tr>
				<td class="center">
					<?php
					if($page->pct_id > 0 || $this->access_control->check_account_type('dev'))
					{
					?>
					<input type="checkbox" name="pag_ids[]" value="<?php echo $page->pag_id; ?>" />
					<?php
					}
					?>
				</td>
				<td><a href="<?php echo site_url('admin/pages/edit/' . $page->pag_id); ?>"><?php echo $page->pag_title; ?></a></td>
				<td>
					<?php 
					echo $page->pct_name; 
					if($this->access_control->check_account_type('dev') && $page->pag_type != 'editable')
					{
						echo ' (' . ucfirst($page->pag_type) . ')';
					}
					?>
				</td>		
				<td>
					<?php echo format_date($page->pag_date_published); ?>
					<!-- sort this column using a value different from the ones displayed -->
					<div class="sort-data" style="display: none;"><?php echo $page->pag_date_published; ?></div>
				</td>
				<td class="center"><?php echo ucfirst($page->pag_status); ?></td>
			</tr>
			<?php
		}
		?>
			</tbody>
		</table>
		<?php echo $pages_pagination; ?>
		<div class="choose-select">
			With selected: 
			<select name="form_mode" class="select-submit">
				<option value="">choose...</option>
				<option value="delete">Delete Pages</option>
			</select>
		</div>
	</form>
	<?php
}
else
{
	?>
	No pages found.
	<?php
}
?>
<script type="text/javascript">
$('#pct_filter').change(function() {
	redirect(SITE_URL + 'admin/pages/index/0/' + $(this).val());
});

$('#pct_filter').val('<?php echo $current_pct_filter; ?>');
</script>