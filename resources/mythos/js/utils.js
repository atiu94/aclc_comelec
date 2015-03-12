function redirect(url)
{
	window.location = url;
}

function redirect_back()
{
	history.go(-1);
}

function selectCheckboxes(checkedStatus, selector) 
{
	$('input[' + selector + ']').each(function() 
	{
		$(this).prop('checked', checkedStatus);
		this.checked = checkedStatus;
		if(checkedStatus)
		{
			$(this).parent().addClass('checked');
		}
		else
		{
			$(this).parent().removeClass('checked');
		}
	});
}