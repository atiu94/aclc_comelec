<?php
if($candidates->num_rows())
{
	?>
	<form method="post">
		<table class="table-list table-striped table-bordered">
			<thead>
				<tr>
					<th>Last Name</th>		
					<th>First Name</th>
					<th>Votes</th>
					<th>Outcome</th>
		
					
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($candidates->result() as $candidate)
			{
				?>
				<tr>
					<td><a href="<?php echo site_url('admin/candidates/view/' . $candidate->can_id); ?>"><?php echo $candidate->can_last_name; ?></a></td>				
					<td><?php echo $candidate->can_first_name; ?></td>
					<td><?php echo number_format($candidate->can_votes); ?></td>
					<td>
						<?php //if (($candidate->can_quota == true) && ($candidate->can_called == true)):

						if (($candidate->can_win == true)):

						 ?>
							<span class="label label-success">Win</span>
							
						<?php else: ?>
							<span class="label label-default">Lose</span>
							
						<?php endif ?>

					</td>
				
					
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php echo $candidates_pagination; ?>
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

<!-- Modal -->
<div class="modal fade" id="resetvotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reset Votes</h4>
      </div>
      <div class="modal-body">
       	<h5> This process involves resetting the votes to 0. Do you want to continue?</h5>
      </div>
      <div class="modal-footer">
		<form  method="post" action="<?php echo site_url("admin/candidates/reset_votes"); ?>">
		
      	<input type="submit" value="Yes" class="btn btn-primary" />
      	</form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>