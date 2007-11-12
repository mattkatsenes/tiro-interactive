Event.observe(window, 'load', init, false);


function loadTempDefinition(term_def_id)
{
var cycle_complete = false;
var tempDefDiv=document.getElementById('tempDefDiv');
var tempDefs = document.getElementsByClassName('tempDef');
	tempDefs.each(function(tempEntry)
	{
		if(tempEntry.id == term_def_id)
		{	
			tempEntry.parentNode.removeChild(tempEntry);
			cycle_complete=true;
		}
		else{};
	})

var defs = document.getElementsByClassName('entry');
	defs.each(function(entry)
	{
		if( (entry.id == term_def_id) && (cycle_complete == false))
				{
				if(tempDefDiv.childNodes.length >= 3)
					tempDefDiv.removeChild(tempDefDiv.childNodes[0]);
				
				
				  var tempDef = entry.cloneNode(true);
				  tempDef.id = tempDef.id;
				  tempDef.className = "tempDef";
					var defBreak = document.createElement('hr');
						defBreak.className = "tempDefHR";
						tempDef.appendChild(defBreak);
					tempDef.getElementsByClassName("part_of_speech")[0].appendChild(document.createElement("br"));
				  Event.observe(tempDef, 'click',function (){loadTempDefinition(tempDef.id);}, false); 
				  tempDefDiv.appendChild(tempDef);
				  }
		else 	{};
	});

};
function clearTempDefinition(def_id)
{
var tempDefDiv=document.getElementById('tempDefDiv');
	if(tempDefDiv.childNodes.length <= 0)
	return 0;
	else{};

tempDefDiv.removeChild(tempDefDiv.lastChild);
}

function assignDefinitionHandlers()
{
terms = document.getElementsByClassName('defined_term');

	terms.each(function(term){
		var myID = $(term).readAttribute('id');
		var defID = $(term).readAttribute('def_id');
		
		Event.observe(term, 'click',function (){loadTempDefinition(defID);}, false); 
		//Event.observe(term, 'mouseout',function (){clearTempDefinition(defID);}, false); 
		//A more effcient way to do this would be to assign the mouseout ONLY when the word has already been clicked on.
		/*term.onmouseover=function (){loadTempDefinition(defID);};*/
	});
}

function init()
{
	var terms;
	terms = document.getElementsByClassName('defined_term');
	
	var defs;
	defs = document.getElementsByClassName('entry');

/* D-082007, rev 090707-switched .insertBefore to .appendChild to right column instead of tossing the new defs on top of the page and moving them */
var tempDefDiv = document.createElement('div');
tempDefDiv.id="tempDefDiv";
document.getElementById("right-col").appendChild(tempDefDiv);
assignDefinitionHandlers();
/*D-091107-Added call to initalization function in temp.js*/
drew_setOnFocusBlur();
/**/

/*	
	terms.each(function(term){
		var myID = $(term).readAttribute('id');
		var defID = $(term).readAttribute('def_id');
		Event.observe(term, 'mouseover', function(this_term){
				new Effect.Highlight($(defID), {startcolor:'#ffffff', endcolor:'#D3D3D3', restorecolor: '#ffffff'});
		}, false); 
	});
*/	

	
	var notes;
	notes = document.getElementsByClassName('noted_term');
	notes.each(function(note){
		var myNote = $(note).readAttribute('note');
		new Insertion.Bottom('notes',myNote + '<br>');
		}, false);
}
