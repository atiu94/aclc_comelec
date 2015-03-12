<?php
if($accounts->num_rows())
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
					<th class="checkbox skip-sort"><input type="checkbox" class="select-all" value="acc_ids" /></th>
					<th>Email</th>
					<th style="width: 250px;">Name</th>
					<th style="width: 100px;">Account Type</th>
					<th style="width: 80px;">Status</th>
				</tr>
			</thead>
			<tbody>			
		<?php
		foreach($accounts->result() as $account)
		{
			?>
			<tr>
				<td class="center"><input type="checkbox" name="acc_ids[]" value="<?php echo $account->acc_id; ?>" /></td>		
				<td><a href="<?php echo site_url('admin/accounts/view/' . $account->acc_id); ?>"><?php echo $account->acc_username; ?></a></td>
				<td><?php echo $account->acc_first_name . ' ' . $account->acc_last_name; ?></td>		
				<td><?php echo $account->acc_type; ?></td>		
				<td><?php echo $account->acc_status; ?></td>
			</tr>
			<?php
		}
		?>
			</tbody>
		</table>
		<?php echo $accounts_pagination; ?>
		<div class="choose-select">
			With selected: 
			<select name="form_mode" class="select-submit">
				<option value="">choose...</option>
				<option value="delete">Delete Accounts</option>
			</select>
		</div>
	</form>
	<?php
}
else
{
	?>
	No accounts found.
	<?php
}

?>