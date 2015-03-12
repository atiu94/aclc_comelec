<?php
if($album->alb_description != '')
{
	?>
	<p><?php echo nl2br($album->alb_description); ?></p>
	<?php
}
?>
<form id="fileupload" action="<?php echo site_url('admin/photos/upload/' . $album->alb_slug);?>" method="POST" enctype="multipart/form-data">
	<div class="fileupload-buttonbar">
		<div class="progress progress-success progress-striped hide active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
	<div class="fileupload-loading"></div>
	<br />
	<table class="table table-striped">
		<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
			<tr class="fileupload-buttonbar">
				<td class="checkdel"><input type="checkbox" class="toggle" onclick="selectCheckboxes(this.checked, 'name=\'delete\'');" /></td>
				<td colspan="5">
					<span class="btn fileinput-button">
						<span>Add Files</span>
						<input type="file" name="files[]" multiple>
					</span>
					<button type="submit" class="btn start">
						<span>Start Upload</span>
					</button>
					<button type="reset" class="btn cancel">
						<span>Cancel Upload</span>
					</button>
					<button type="button" class="btn delete">
						<span>Delete Selected</span>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<style>
	td.preview {
		width: 80px;
	}
	td.checkdel {
		width: 13px;
	}
	td.delete {
		width: 62px;
		text-align: right;
	}
	td.start {
		width: 62px;
	}
	td.cancel {
		width: 62px;
	}
</style>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="checkdel"></td>
        <td class="preview"><span class="fade"></span></td>
        <td class="name">
			<span>{%=file.name%}</span>
			<div class="size"><span>{%=o.formatFileSize(file.size)%}</span></div>
			{% if (o.files.valid && !i) { %}
			<div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
			{% } %}
		</td>
        
        {% if (file.error) { %}
            <td class="error"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary"><span>Upload</span></button>
            {% } %}</td>
        {% } else { %}
            <td class="start"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn"><span>Cancel</span></button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td class="checkdel"></td>
            <td class="preview"></td>
            <td class="name">
				<span>{%=file.name%}</span>
				<div class="size"><span>{%=o.formatFileSize(file.size)%}</span></div>
			</td>
            <td class="error"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
			<td class="checkdel"><input type="checkbox" name="delete" value="1"></td>
            <td class="preview">
				{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
				{% } %}
			</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
				<div class="size"><span>{%=o.formatFileSize(file.size)%}</span></div>
            </td>
            <td class="start"></td>
        {% } %}
        <td class="delete">
            <a href="javascript:;" title="Delete Photo" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <span>&times;</span>
            </a>
        </td>
    </tr>
{% } %}
</script>
<?php
echo '<script src="' . res_url('mythos/file_upload/js/jquery.fileupload.required.js') . '"></script>';
echo '<script src="' . res_url('mythos/file_upload/js/jquery.iframe-transport.js') . '"></script>';
echo '<script src="' . res_url('mythos/file_upload/js/jquery.fileupload.js') . '"></script>';
echo '<script src="' . res_url('mythos/file_upload/js/jquery.fileupload-fp.js') . '"></script>';
echo '<script src="' . res_url('mythos/file_upload/js/jquery.fileupload-ui.js') . '"></script>';
echo '<script src="' . res_url('mythos/file_upload/js/locale.js') . '"></script>';
echo '<script src="' . res_url('mythos/file_upload/js/main.js') . '"></script>';
echo '<!--[if gte IE 8]><script src="' . res_url('mythos/file_upload/js/cors/jquery.xdr-transport.js') . '"></script><![endif]-->';