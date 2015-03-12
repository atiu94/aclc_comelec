<?php
ob_start();
phpinfo();
$phpinfo = ob_get_contents();
ob_end_clean();

// Remove phpinfo's CSS
$phpinfo = str_replace('<style', '<!-- <style', $phpinfo);
$phpinfo = str_replace('</style>', '</style> -->', $phpinfo);
?>
<style>
.phpinfo table {
	width: 100%;
	table-layout: fixed;
}
.phpinfo table td {
	word-wrap: break-word;
}
</style>
<div class="phpinfo">
	<?php echo $phpinfo; ?>
</div>
	