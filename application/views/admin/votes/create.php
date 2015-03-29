<script type="text/javascript">
//HARDCODED VOTE LIMIT

var limit = 2;
$('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > limit) {
        $(this).prop('checked', false);
        alert("You are only allowed to vote for "+limit+" candidates.");
    }
});
</script>

<?php
if($candidates->num_rows())
{
	?>


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


<script type="text/javascript">
//HARDCODED VOTE LIMIT
var limit = 7;
$('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > limit) {
        $(this).prop('checked', false);
        alert("You are only allowed to vote for "+limit+" candidates.");
    }
});
</script>