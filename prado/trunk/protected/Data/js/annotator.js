
/* --------------------------------- */
/* attachAnnotation - Load up annotation attachment choices for the element with tiro_id. */
function attachAnnotation(tiro_id)
{
	if($(tiro_id).hasClassName('leaf'))
	{
		$(tiro_id).toggleClassName('annotated');
//		new Effect.Shake(tiro_id);
		annotateLeaf(tiro_id);
	}
	else
	{
		$(tiro_id).toggleClassName('annotated_line');
//		new Effect.Shake(tiro_id);
		annotateBranch(tiro_id);
	}
};

annotateLeaf = function(tiro_id){
	var header = "<div style=\"float: right;\" onClick=\"annotationCancel('"+tiro_id+"')\">[X]</div><h2>Annotation Box</h2>";
	var content = header + $(tiro_id).innerHTML+"<ul><li><a href=\"javascript:attachDefinition('"+tiro_id+"')\">Definition</a></li><li><a href=\"javascript:attachNote('"+tiro_id+"')\">Textual Note</a></li><li><a href=\"javascript:attachLink('"+tiro_id+"')\">Hyperlink</a></li><li><a href=\"javascript:attachImage('"+tiro_id+"')\">Image</a></li></ul></p>";
	$('annotationBox').update(content);
	$('annotationBox').clonePosition($(tiro_id),{setWidth:false, setHeight:false,offsetLeft:100,offsetTop:-80});
//	$('annotationBox').show();
	new Effect.BlindDown('annotationBox');
};

annotateBranch = function(tiro_id){
	var content = "<h2>Annotation type:</h2><p>"+$(tiro_id).innerHTML+"<ul><li><a href=\"javascript:attachNote('"+tiro_id+"')\">Textual Note</a></li><li><a href=\"javascript:attachLink('"+tiro_id+"')\">Hyperlink</a></li><li><a href=\"javascript:attachImage('"+tiro_id+"')\">Image</a></li></ul></p>";
	$('annotationBox').update(content);
	$('annotationBox').clonePosition($(tiro_id),{setWidth:false, setHeight:false,offsetLeft:100,offsetTop:-80});
	$('annotationBox').show();
	new Effect.BlindDown('annotationBox');
};

attachDefinition = function(tiro_id) {

};

attachNote = function(tiro_id) {

};

attachLink = function(tiro_id) {
	var path = window.location.pathname.toString();
	var end = path.lastIndexOf('/');
	var tiro_id_number = tiro_id.substr(tiro_id.indexOf('_')+1);
	var newPath = path.substring(0,end) + '/Link';
	new Ajax.Updater('annotationBox',newPath,{
		method: 'get',
		parameters: {
			id_text: tiro_id_number,
			action: 'input'
			}
		});
};

completeLink = function(tiro_id,link_target)
{
	var path = window.location.pathname.toString();
	var end = path.lastIndexOf('/');
	var tiro_id_number = tiro_id.substr(tiro_id.indexOf('_')+1);
	var newPath = path.substring(0,end) + '/Link';
	new Ajax.Updater('annotationBox',newPath,{
		method: 'get',
		parameters: {
			id_text: tiro_id_number,
			link: link_target,
			action: 'attach'
			}
	});
};

attachImage = function(tiro_id) {
	alert("attach image: "+tiro_id);
	
	$('id_text').writeAttribute('value',tiro_id);
	document.forms[0].submit();
	
};

annotationCancel = function(tiro_id)
{
	$(tiro_id).toggleClassName('annotated');
	new Effect.BlindUp('annotationBox');
//	$('annotationBox').hide();
}