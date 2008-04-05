
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
	var content = "<h2>Annotation type:</h2><p>"+$(tiro_id).innerHTML+"<ul><li><a href=\"javascript:attachDefinition('"+tiro_id+"')\">Definition</a></li><li><a href=\"javascript:attachNote('"+tiro_id+"')\">Textual Note</a></li><li><a href=\"javascript:attachLink('"+tiro_id+"')\">Hyperlink</a></li><li><a href=\"javascript:attachImage('"+tiro_id+"')\">Image</a></li></ul></p>";
	$('annotationBox').update(content);
	$('annotationBox').clonePosition($(tiro_id),{setWidth:false, setHeight:false,offsetLeft:100,offsetTop:-80});
	$('annotationBox').show();
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

};

attachImage = function(tiro_id) {

};