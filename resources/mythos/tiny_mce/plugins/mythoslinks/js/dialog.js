var RELATIVE_PATH = '../../../../../';

$(function() {
	$('#link_type').change(function() {
		select_link_type();
	});

	$('#insert_link').click(function() {
		var editor = tinymce.activeEditor;
		var pages = $("#pages");		
		var link_type_val = $('#link_type').val();
		var new_href = '';
		
		if(link_type_val == 'int') {
			new_href = '{SITE_URL}' + pages.val();
		}
		else if(link_type_val == 'ext') {
			new_href = $('#ext_url').val();
		}
		
		editor.selection.setContent('<a href="' + new_href + '">' + editor.selection.getContent() + '</a>');
		self.close();
	});

	$('#back_link').click(function() {
		self.close();
	});
	
	get_page_cats(function() {
		select_current_link(function() {
			$("#page_cats").change(function() {
				get_pages();
			});
			
			window.resizeTo(450, 350);
		});
	});
	
	select_link_type();
});

function get_selected_link() {
	var editor = tinymce.activeEditor;
	return editor.dom.getParent(editor.selection.getNode(), "A");
}

function select_current_link(callback) {
	var optional_callback = function() {
		if(callback != null) {
			callback();
		}
	}

	var sel_link = get_selected_link();
	tinymce.activeEditor.selection.select(sel_link);
	
	if(sel_link != null && sel_link.getAttribute("href") != '') {
		var href = sel_link.getAttribute("href");
		var pag_slug = href.replace('{SITE_URL}', '');
		if(pag_slug.length < href.length) {
			$('#link_type').val('int');
			select_link_type();
			
			$.get(RELATIVE_PATH + 'api/pages/get_by_slug/' + pag_slug, function(data) {
				if(data.pag_id == null) {
					$("#pages").val(0);
					optional_callback();
				}
				else {
					$("#page_cats").val(data.pct_id);
					get_pages(function() {
						$("#pages").val(data.pag_slug);
						optional_callback();
					});				
				}
			});
		}
		else {
			$('#link_type').val('ext');
			select_link_type();
			$('#ext_url').val(href);
		}
	}
	else {
		optional_callback();
	}
}

function get_page_cats(callback) {
	var page_cats = $("#page_cats");
	page_cats.find('option').remove();
	
	$.get(RELATIVE_PATH + 'api/page_categories/get_all', function(data) {
		page_cats.append($("<option />").val(0).text('Uncategorized'));
		for(var i = 0; i < data.length; i++) {
			page_cats.append($("<option />").val(data[i].pct_id).text(data[i].pct_name));
		}
		
		if(callback != null) {
			callback();
		}
	}, 'json');
}

function get_pages(callback) {
	var page_cats = $("#page_cats");
	var pct_id = page_cats.val();
	var pages = $("#pages");
	pages.find('option').remove();
	$.get(RELATIVE_PATH + 'api/pages/get_of_category/' + pct_id, function(data) {
		for(var i = 0; i < data.length; i++) {
			pages.append($("<option />").val(data[i].pag_slug).text(data[i].pag_title));
		}
			
		if(callback != null) {
			callback();
		}
	}, 'json');
}

function select_link_type() {
	var val = $('#link_type').val();
	if(val == 'int') {
		$('#fg_ext').hide();
		$('#fg_int').show();
	}
	else if(val == 'ext') {
		$('#fg_int').hide();	
		$('#fg_ext').show();
	}
}