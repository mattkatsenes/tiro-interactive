Event.observe(window, 'load', init, false);

//D-08-18-2007
function defReArrange ()
{
var endOfDefinitions = document.getElementById("notes_heading");
var clearedBr = document.createElement('br');
clearedBr.style.clear="both";
document.getElementById("marginalia").insertBefore(clearedBr,endOfDefinitions);

var definitionSection = document.getElementById("definitions");
		definitionSection.style.visibility = "hidden";
var defCollection=document.getElementsByClassName("entry");

var defColumn1 = new Array();
var defColumn2 = new Array();

	var defHalfway = Math.round(defCollection.length / 2);
	while(defCollection.length > defHalfway)
		defColumn1.push(defCollection.pop());
	while(defCollection.length > 0)
		defColumn2.push(defCollection.pop());

	var newDivCol1 	= document.createElement('div');
newDivCol1.id	= "defCol1";
		while(defColumn2.length > 0 )
	   	newDivCol1.appendChild(defColumn2.pop());
//	newDivCol1.appendChild(document.createElement('br'));	
		
	var newDivCol2 	= document.createElement('div');
newDivCol2.id 	= "defCol2"; 
		while(defColumn1.length > 0 )
	   	newDivCol2.appendChild(defColumn1.pop());
//	newDivCol2.appendChild(document.createElement('br'));
		
definitionSection.appendChild(newDivCol1);
definitionSection.appendChild(newDivCol2);
	definitionSection.appendChild(document.createElement('br'));
definitionSection.style.visibility = "visible";
}



function init()
{
	var terms;
	terms = document.getElementsByClassName('defined_term');
	
	var defs;
	defs = document.getElementsByClassName('entry');

/*  D - 8/18/07 - Removed for new method defReArrange()	
	var halfway = Math.round(defs.size()/2);

	new Insertion.Before( defs.first()  , "<div class=\"entry_col1\">");
	new Insertion.Before( defs[halfway] , "</div><br /><div class=\"entry_col2\"> ");
	new Insertion.After(  defs.last()   , "</div>");
*/
defReArrange();

	
/*	defs.each( function(myDef, index) {
		if(index < total/2)
			myDef.className = 'entry_col1';
		else
			myDef.className = 'entry_col2';
	});
*/	
	
	terms.each(function(term){
		var myID = $(term).readAttribute('id');
		var defID = $(term).readAttribute('def_id');
		Event.observe(term, 'mouseover', function(this_term){
				new Effect.Highlight($(defID), {startcolor:'#ffffff', endcolor:'#D3D3D3', restorecolor: '#ffffff'});
		}, false); 
	});
	

	
	var notes;
	notes = document.getElementsByClassName('noted_term');
	notes.each(function(note){
		var myNote = $(note).readAttribute('note');
		new Insertion.Bottom('notes',myNote + '<br>');
		}, false);
}
