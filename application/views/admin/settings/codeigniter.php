<?php
function recursive_list($array)
{
	$use_table = false;
	foreach($array as $key => $value)
	{
		if(is_array($value) || !is_numeric($key))
		{
			$use_table = true;
			break;
		}
	}
	
	if($use_table)
	{
		$html = '<table class="table-form">';
		foreach($array as $key => $value)
		{
			$html .= '<tr>';
			if(!is_numeric($key) && is_array($value))
			{
				$html .= '<th colspan="2" class="left label">' . $key . '</th></tr><tr>';
			}
			elseif(!is_numeric($key) && !is_array($value))
			{
				$html .= '<th>' . $key . '</th>';
			}
			
			if(is_array($value))
			{
				$html .= '<td>' . recursive_list($value) . '</td>';
			}
			else
			{
				$html .= '<td>';
				if(is_bool($value))
				{
					if($value)
					{
						$html .= 'TRUE';
					}
					else
					{
						$html .= 'FALSE';
					}
				}
				else
				{
					$html .= htmlentities($value);
				}
				$html .= '</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</table>';
	}
	else
	{
		$html = '<ul>';
		foreach($array as $key => $value)
		{
			$html .= '<li>' . htmlentities($value) . '</li>';			
		}
		$html .= '</ul>';
	}
	
	return $html;
}
?>
<style>
ul.config_list li {
	margin: 5px 0;
}
</style>
<h1>CodeIgniter Version <?php echo CI_VERSION; ?></h1>
<?php

foreach($configs as $config => $config_info)
{
	?>
	<h2><?php echo $config; ?></h2>
	<table class="table-form">
	<?php
	if($config == 'mythos')
	{
		?>
		<tr>
			<th>version</th>
			<td><?php echo MYTHOS_VERSION_NAME . ' (' . MYTHOS_VERSION . ')'; ?></td>
		</tr>
		<?php
	}
	
	foreach($config_info as $config_name => $config_value)
	{
		?>
		<tr>
			<th><?php echo $config_name; ?></th>
			<td>
				<?php 
				if(is_array($config_value))
				{
					//echo '<pre>';
					//print_r($config_value);
					//echo '</pre>';
					echo recursive_list($config_value);
				}
				elseif(is_bool($config_value))
				{
					if($config_value)
					{
						echo 'TRUE';
					}
					else
					{
						echo 'FALSE';
					}
				}
				else
				{
					echo htmlentities($config_value); 
				}
				?>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
?>