
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
	var content = "<h2>Annotation type:</h2><p>"+$(tiro_id).innerHTML+"<ul><li>Type 1</li><li>Type 2</li></ul></p>";
	$('annotationBox').update(content);
	$('annotationBox').clonePosition($(tiro_id),{setWidth:false, setHeight:false,offsetLeft:100,offsetTop:-80});
	$('annotationBox').show();
	new Effect.BlindDown('annotationBox');
};

annotateBranch = function(tiro_id){
	var content = "<h2>Annotation type:</h2><p>"+$(tiro_id).innerHTML+"<ul><li>Type 1</li><li>Type 2</li></ul></p>";
	$('annotationBox').update(content);
};