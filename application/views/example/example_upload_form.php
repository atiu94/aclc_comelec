<?php 
echo @$error;
/*
-note that you have to set the type of the form as multipart
-change the multipart parameter to to the controller that will process the form
*/
echo form_open_multipart('/dev/a_example_upload/do_upload/');
?>
<input type="file" name="sample_file" size="20" />
<br /><br />
<input class="btn btn-primary" type="submit" value="upload" />
</form>