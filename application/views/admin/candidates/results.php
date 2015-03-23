<?php
if($candidates->num_rows())
{
	?>
<h5>All called candidates of the current round.</h5>
	<form method="post">
		<table class="table-list table-striped table-bordered">
			<thead>
				<tr>
					<th>Name</th>		
					<th>Votes</th>
					<th>Quota</th>
					
					
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($candidates->result() as $candidate)
			{
				?>
				<tr>
					<td><a href="<?php echo site_url('admin/candidates/view/' . $candidate->can_id); ?>"><?php echo $candidate->can_first_name; ?> <?php echo $candidate->can_last_name; ?></a></td>				
					<td><?php echo number_format($candidate->can_votes); ?></td>
					<td>
						<?php if ($candidate->can_quota == true): ?>
							<span class="label label-success">Quota</span>
						<?php else: ?>
							<span class="label label-default">Not Quota</span>
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
	No Called Candidates
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