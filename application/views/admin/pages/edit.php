<?php 
// Normal form here. Form validation are taken care of by the controller.
// Make sure to name your form elements properly and uniquely.
?>
<form method="post">
	<table class="table-form table-bordered">
		<tr>
			<th>Page Title</th>
			<td><input type="text" name="pag_title" class="form-max-width" value="<?php echo $page->pag_title; ?>" maxlength="140" /></td>
		</tr>
		<tr>
			<th>Link</th>
			<td><a href="<?php echo site_url($page->pag_slug); ?>" target="_blank"><?php echo site_url($page->pag_slug); ?></a></td>
		</tr>
		<tr id="category_row">
			<th>Category</th>
			<td>		
				<select name="pct_id" id="pct_id">
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
			</td>
		</tr>
		<?php
		if($this->access_control->check_account_type('dev'))
		{
		?>
		<tr>
			<th>Type</th>
			<td>
				<select name="pag_type" id="pag_type">
					<option value="editable">Editable</option>
					<option value="static">Static</option>
				</select>
			</td>
		</tr>
		<?php
		}
		?>
		<tr id="status_row">
			<th>Status</th>
			<td>
				<select name="pag_status" id="pag_status">
					<option value="published">Published</option>
					<option value="draft">Draft</option>
				</select>
			</td>
		</tr>
		<tr id="date_published_row">
			<th>Date Published</th>
			<td><input type="text" name="pag_date_published" class="date" value="<?php echo format_mysql_date($page->pag_date_published); ?>" /></td>
		</tr>
		<tr id="date_created_row">
			<th>Date Created</th>
			<td><?php echo format_date($page->pag_date_created); ?></td>
		</tr>
		<tr>
			<th>Content</th>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="pag_content" class="tiny-mce" style="width: 100%; height: 400px;"><?php echo $page->pag_content; ?></textarea>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
				<a href="<?php echo site_url('admin/pages'); ?>" class="btn">Back</a>
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
$('#pag_status').change(function() {
	if($(this).val() == 'published') 
	{
		$('#date_published_row').show();
	}
	else 
	{
		$('#date_published_row').hide();
	}
});

$(document).ready(function() {
	$('#pct_id').val('<?php echo $page->pct_id; ?>');
	<?php
	if($this->access_control->check_account_type('dev'))
	{
	?>
	$('#pag_type').val('<?php echo $page->pag_type; ?>');
	<?php
	}
	?>
	$('#pag_status').val('<?php echo $page->pag_status; ?>');
	$('#pag_status').change();
	<?php
	if($page->pct_id == 0 && !$this->access_control->check_account_type('dev'))
	{
	?>
	$('#category_row').hide();
	$('#status_row').hide();
	$('#date_published_row').hide();
	$('#date_created_row').hide();
	<?php
	}
	?>
});
</script>