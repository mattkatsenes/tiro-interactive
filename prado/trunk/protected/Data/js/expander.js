
/* ************************************** */
/* toggleExpand - expands or contracts a branch in the div/span tree. */
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
