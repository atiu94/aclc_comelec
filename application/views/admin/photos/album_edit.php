<?php 
// Normal form here. Form validation are taken care of by the controller.
// Make sure to name your form elements properly and uniquely.
?>
<form method="post">
	<table class="table-form table-bordered">
		<tr>
			<th>Album Name</th>
			<td><input type="text" name="alb_name" class="span6" value="<?php echo $album->alb_name; ?>" /></td>
		</tr>
		<tr>
			<th>Description</th>
			<td><textarea name="alb_description" class="span6" rows="5"><?php echo $album->alb_description; ?></textarea></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<?php
				// A custom Javascript method redirect is just a shorthand for window.location.
				?>
				<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
				<a href="<?php echo site_url('admin/photos/album/' . $album->alb_id); ?>" class="btn">Back</a>
			</td>
		</tr>
	</table>
</form>
