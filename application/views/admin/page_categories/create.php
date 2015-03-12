<?php 
// Normal form here. Form validation are taken care of by the controller.
// Make sure to name your form elements properly and uniquely.
?>
<form method="post">
	<table class="table-form table-bordered">
		<tr>
			<th>Category Name</th>
			<td><input type="text" name="pct_name" style="width: 100%;" /></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<?php
				// A custom Javascript method redirect is just a shorthand for window.location.
				?>
				<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
				<a href="<?php echo site_url('admin/page_categories'); ?>" class="btn">Back</a>
			</td>
		</tr>
	</table>
</form>
