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
*/
function newWordBox(word, objFunction)
{
		if(objFunction == null) {objFunction=function(){};};
		
		new Ajax.Request("http://www.tiro-interactive.org/frontend/protected/Pages/TextManagement/Plugins/Definitions/xmlForm.php?word=quibus", 
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
						document.body.appendChild(myRoot);
						$('wordbox').action="javascript:sendParse("+objFunction+")";
					}
				});
}


function sendParse( objectFunction)
{
var returnObject = new Object();

var valid_lemma;
for( var i = 0; i < $$('.lemma').length; i++)
	{
		if($$('.lemma')[i].checked)
			valid_lemma = $$('.lemma')[i];
	}

returnObject.lemma = valid_lemma.value;
returnObject.queryword = $('query_word').innerHTML;
returnObject.userdefinition = $('definition_area').value;
returnObject.spanContainer = valid_lemma.parentNode;
alert(returnObject.lemma + ":\n" + returnObject.userdefinition);

objectFunction(returnObject);
}


function move_trans(input)
{
 $('definition_area').value += input+'; ';
}

function move_lemma(input)
{

$html = $(input+'-orth').innerHTML + " ";
$html += $(input+'-misc').innerHTML

$('definition_area_title').innerHTML = $html;

$('definition_area').value = "";
$$('.translations').each(function(item){item.checked=false});
}