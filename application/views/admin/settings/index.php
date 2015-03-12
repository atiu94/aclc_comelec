<table class="table-form table-bordered">
	<tr>
		<th>Mythos CMS</th>
		<td><?php echo MYTHOS_CMS_VERSION; ?></td>
	</tr>
	<tr>
		<th>Mythos</th>
		<td><?php echo MYTHOS_VERSION; ?> (<?php echo MYTHOS_VERSION_NAME; ?>)</td>
	</tr>
	<tr>
		<th>PHP</th>
		<td><?php echo phpversion(); ?></td>
	</tr>
	<tr>
		<th>Base Path</th>
		<td><?php echo FCPATH; ?></td>
	</tr>
	<tr>
		<th>Models</th>
		<td>
			<?php
			if(count($models) > 0)
			{
			?>
			<ul>
				<?php
				foreach ($models as $model) 
				{
				?>
				<li><?php echo $model; ?></li>
				<?php
				}
				?>
			</ul>
			<?php
			}
			?>
		</td>
	</tr>
</table>