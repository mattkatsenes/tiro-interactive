Event.observe(window, 'load', init, false);

function init()
{
	branches = $('tiro_').select('div');
	
	branches.invoke('hide');
}

function toggleExpand(branch_id)
{
	children = $(branch_id).childElements();

	children.each(function(child){
		if(child.nodeName == 'A')
			child.descendants().each(function(kiddie){
				if(kiddie.src.search(/east/) > -1)
					kiddie.src = 'http://localhost/frontend/images/south.gif';
				else
					kiddie.src = 'http://localhost/frontend/images/east.gif';
			});
		else
			child.toggle();
	});
	
}

function attach(tiro_id)
{
	$('id_text').writeAttribute('value',tiro_id);
	document.forms[0].submit();
}