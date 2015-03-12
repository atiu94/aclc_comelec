$(document).ready(function() {	
	// Enable Bootstrap JS
	$(".alert").alert();
	$('.dropdown-toggle').dropdown();
	$(".collapse").collapse();
	
	// Select all checkbox for a set of checkboxes
	$(".select-all").click(function() {
		selectCheckboxes(this.checked, 'name="' + this.value + '[]"');
	});
	
	$('#confirm-modal').on('hide', function () {
		$('select.select-submit').val('');
	});
	
	$('select.select-submit').change(function() {
		var dropdown = $(this);
		if(dropdown.val() !== '')
		{
			$('#confirm-modal').modal();
			var button = $('#confirm-modal .btn.btn-primary');
			button.unbind('click');
			button.click(function() {
				dropdown.closest("form").submit();
			});
		}
	});
	
	tinyMCE.init({
			// General options
			mode : "textareas",
			theme : "advanced",
			skin : "thebigreason",
			editor_selector : "tiny-mce",
			relative_urls : true,
			remove_script_host : false,
			convert_urls : false,
			accessibility_warnings : false,
			extended_valid_elements : "iframe[src|width|height|name|align|frameborder|scrolling]",
			plugins : "advimage,advlink,autolink,lists,media,table,jbimages,mythoslinks",
			// Theme options
			theme_advanced_buttons1 : "formatselect,|,bold,italic,underline,strikethrough,|,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,mythoslinks,unlink,|,bullist,numlist,outdent,indent,|,jbimages,media,|,removeformat,code",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			content_css : RESOURCES_URL + "admin/css/tinymce.css",
			width: '100%',
			height: '400px'
	});
	
	$('input.datetime').each(function() {
		$(this).hide();
		var target_id = $(this).attr('id');
		if(target_id == null || target_id == '')
		{
			target_id = $(this).attr('name');
			$(this).attr('id', target_id);
		}
		var dt_elems_id = 'dt_' + Math.floor(Math.random() * 1000000000000);
		
		var dt_elems = '';
		dt_elems += '<input type="text" id="' + dt_elems_id + '_date" class="date" />';
		dt_elems += '<input type="text" id="' + dt_elems_id + '_time" class="time" />';
		
		$(this).after(dt_elems);
		
		var dt_update = function(id, target_id) {
			var dt_val = $('#' + id + '_date').val() + ' ' + $('#' + id + '_time').val();
			$('#' + target_id).val(dt_val);
			$('#' + target_id).change();
			$('#' + target_id).blur();
		};
		
		$('#' + dt_elems_id + '_date').change(function() {
			dt_update(dt_elems_id, target_id);
		});
		
		$('#' + dt_elems_id + '_time').change(function() {
			dt_update(dt_elems_id, target_id);
		});
	});

	$('input.time').each(function() {
		$(this).hide();
		var target_id = $(this).attr('id');
		if(target_id == null || target_id == '')
		{
			target_id = $(this).attr('name');
			$(this).attr('id', target_id);
		}
		var val = $(this).val();
		var t_elems_id = 't_' + Math.floor(Math.random() * 1000000000000);
		var t_elems = '';
		
		if(val == '')
		{
			val = '01:00:00';
			$(this).val(val);
		}
		
		t_elems += '<select id="' + t_elems_id + '_hour" class="t-time">';
		for(var i = 1; i <= 12; i++)
		{
			if(i < 10)
			{
				i = '0' + i;
			}
			t_elems += '<option value="' + i + '">' + i + '</option>';
		}
		t_elems += '</select>';
		
		t_elems += '<select id="' + t_elems_id + '_minute" class="t-time">';
		for(var i = 0; i <= 59; i++)
		{
			if(i < 10)
			{
				i = '0' + i;
			}
			t_elems += '<option value="' + i + '">' + i + '</option>';
		}
		t_elems += '</select>';
		
		t_elems += '<select id="' + t_elems_id + '_ampm" class="t-time">';
		t_elems += '<option value="AM">AM</option>';
		t_elems += '<option value="PM">PM</option>';
		t_elems += '</select>';
		
		$(this).after(t_elems);
		
		var time_parts = val.split(':');
		var val_hh = time_parts[0];
		var val_mm = time_parts[1];
		var val_ampm = 'AM';
		if(val_hh >= 12) 
		{
			val_ampm = 'PM';
			val_hh -= 12;
			if(val_hh < 10)
			{
				val_hh = '0' + val_hh;
			}
		}
		$('#' + t_elems_id + '_hour').val(val_hh);
		$('#' + t_elems_id + '_minute').val(val_mm);
		$('#' + t_elems_id + '_ampm').val(val_ampm);
		
		var t_update = function(id, target_id) {
			var hour = $('#' + id + '_hour').val();
			if($('#' + id + '_ampm').val() == 'PM')
			{
				hour = (hour - 1) + 13;
			}
			var t_val = hour + ':' + $('#' + id + '_minute').val() + ':00';
			$('#' + target_id).val(t_val);
			$('#' + target_id).change();
			$('#' + target_id).blur();
		};
		
		$('#' + t_elems_id + '_hour').change(function() {
			t_update(t_elems_id, target_id);
		});
		
		$('#' + t_elems_id + '_minute').change(function() {
			t_update(t_elems_id, target_id);
		});
		
		$('#' + t_elems_id + '_ampm').change(function() {
			t_update(t_elems_id, target_id);
		});
	});
	
	$("input.date").each(function(index) {
		var id = $(this).attr('id');
		var val = $(this).val();
		if(id == null || id == '')
		{
			id = $(this).attr('name');
			$(this).attr('id', id);
		}
		
		if(val == '')
		{
			var today = new Date();
			var dd = today.getDate();
			if(dd < 10)
			{
				dd = '0' + dd;
			}
			var mm = today.getMonth() + 1;
			if(mm < 10)
			{
				mm = '0' + mm;
			}
			var yyyy = today.getFullYear();
			val = yyyy + '-' + mm + '-' + dd;
			$(this).val(val);
		}
		
		$(this).after('<input class="datepicker" type="text" id="' + id + '_datepicker" readonly="readonly" />');
		$('#' + id + '_datepicker').datepicker({
			buttonImage : BASE_URL + 'resources/mythos/images/jquery-ui/ui-calendar.png',
			buttonImageOnly : true,
		    showOn : 'both',
			dateFormat : 'yy-mm-dd',
			altFormat : 'yy-mm-dd',
			altField : '#' + id,
			autoSize : true,
			buttonText : '',
			defaultDate : val,
			onSelect : function(date) {
				$('#' + id).change();
				$('#' + id).blur();
			}
		});
		
		$('#' + id + '_datepicker').datepicker('setDate', val);
		$('#' + id + '_datepicker').datepicker('option', 'dateFormat', 'DD, d M yy');
		$('#' + id + '_datepicker').datepicker('option', 'changeYear', true);
		$('#' + id + '_datepicker').datepicker('option', 'changeMonth', true);
		$('#' + id + '_datepicker').datepicker('option', 'showOtherMonths', true);
		$('#' + id + '_datepicker').datepicker('option', 'selectOtherMonths', true);
		$(this).hide();
	});
	
	// tablesorter
	$("table.table-list").each(function() {
		var skip_json = '';
		var i = 0;
		$(this).find('th').each(function() {
			if($(this).hasClass('skip-sort')) 
			{
				skip_json += ', "' + i + '": { "sorter": false }';
			}
			i++;
		});
		if(skip_json.length >= 2)
		{
			skip_json = skip_json.substring(2);
		}
		
		skip_json = '{ "headers": { ' + skip_json + ' } }';
		var params = jQuery.parseJSON(skip_json);
		
		params.textExtraction = function(node) { 
			var sortText = '';
			$(node).find('.sort-data').each(function() {
				sortText = $(this).html();
			});
			
			if(sortText == '') 
			{
				sortText = $(node).html();
			}
			return sortText; 
		};
		
		$(this).tablesorter(params);
	});
	
	var sidebar_nav = $('.sidebar-nav');
	sidebar_nav.affix();
	sidebar_nav.css('width', sidebar_nav.width());
	
});
