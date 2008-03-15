//Takes an inflected latin word, and adds to the body-doc a new 
// <div id='root_wordbox'>, which contains the wordbox.  When the user
// clicks the submit button, a returnObject is created, and passed to 
// objFunction for processing.

/*
returnObject members:
	returnObject.lemma;				//	Lemma of selected root word
	returnObject.queryword;		//	Word passed to function originally
	returnObject.userdefinition;		//	Definition modified by user
	returnObject.spanContainer;	//	html string of the <span> container for the selected lemma
	returnObject.xml;	//	xml tree of the selected lemma
*/
function newWordBox(word, id_text, objFunction, location)
{
		if(location == null){location = document.body;}
		if(objFunction == null) {objFunction=function(){};};
		
		new Ajax.Request("/frontend/protected/Pages/TextManagement/Plugins/Definitions/xmlForm.php", 
				{ 
					method: 'GET', 
					parameters: "word="+word,
					onComplete: function(req)
					{
						var 	myRoot 	= document.createElement("div");
						myRoot.id 	= "root_wordbox";
						myRoot.innerHTML = req.responseText;
						if($$("#root_wordbox").length > 0)
						{
							for(i =0; i<$$("#root_wordbox").length; i++)
								$$("#root_wordbox")[i].remove();
						}
						location.appendChild(myRoot);
						$('wordbox').action="javascript:sendParse("+objFunction+",'"+id_text+"')";
					}
				});
}


function sendParse( objectFunction, id_text)
{
var returnObject = new Object();

var valid_lemma;
for( var i = 0; i < $$('.lemma').length; i++)
	{
		if($$('.lemma')[i].checked)
			valid_lemma = $$('.lemma')[i];
	}

returnObject.lemma = valid_lemma.value;
returnObject.id_text = id_text;
returnObject.queryword = $('query_word').innerHTML;
returnObject.userdefinition = $('definition_area').value;
returnObject.usertitle = $('definition_area_title').value;
returnObject.spanContainer = valid_lemma.parentNode;
returnObject.xml = $(valid_lemma.value+'-zipxml').innerHTML;

objectFunction(returnObject);
}


function move_trans(input)
{
 $('definition_area').value += input+'; ';
}

function move_lemma(input, clear)
{
html = $(input+'-orth').innerHTML + " ";
html += $(input+'-misc').innerHTML;

$('definition_area_title').value = html;
$('definition_area').value = "";


obj_root = $(input).parentNode.id = input + '-root';
	if((clear == null) || (clear == true))
		$$('.translations').each(function(item){item.checked=false;});
	else
		$(obj_root).getElementsBySelector('.translations').each(function(item){item.checked=true;});
}