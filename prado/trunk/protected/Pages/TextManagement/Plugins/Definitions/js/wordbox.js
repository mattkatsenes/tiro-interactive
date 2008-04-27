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
	var mySplash 	= document.createElement("div");
	mySplash.id 		= "splash";
	location.appendChild(mySplash);					
	$('splash').setStyle({
	border: "1px solid black",
	backgroundImage: "url('/frontend/images/grey.png')",
	padding:"5px",
	position:"absolute", 
	top:	$$('body')[0].offsetTop, 
	left:	$$('body')[0].offsetLeft,
	width: $$('body')[0].clientWidth,
	height: $$('body')[0].clientHeight,
	overflow: "auto",
	});
	var A = document.createElement("img");
		A.setStyle({position: "absolute", top: $$('body')[0].getHeight()/2, left: ($$('body')[0].getWidth()/2)-100});
		A.src="/frontend/images/ajax-loader.gif";
		A.id = "splashImg";
		$('splash').appendChild(A);
						
		if(location == null){location = document.body;}
		if(objFunction == null) {objFunction=function(){};};
		new Ajax.Request("/frontend/protected/Pages/TextManagement/Plugins/Definitions/xmlForm.php", 
				{ 
					method: 'GET', 
					parameters: "word="+word,
					onComplete: function(req)
					{
						$('splashImg').remove();
						var 	myRoot 	= document.createElement("div");
						myRoot.id 	= "root_wordbox";
						myRoot.innerHTML = req.responseText;
						if($$("#root_wordbox").length > 0)
						{
							for(i =0; i<$$("#root_wordbox").length; i++)
								$$("#root_wordbox")[i].remove();
						}
						location.appendChild(myRoot);
						console.log($('wordbox'));
						$('wordbox').action="javascript:sendParse("+objFunction+",'"+id_text+"');$('splash').remove();";
						centerWordBox();  //See below
					},
					onFailure:	function(req)
					{
					$('splash').remove();
					alert("ajax request failed");
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

function centerWordBox()
{
$('root_wordbox').setStyle({
	border: "1px solid black",
	background: "white", 
	padding:"5px",
	position:"absolute", 
	top:	$('guts').offsetTop-1, 
	left:	$('guts').offsetLeft+1,
	width: $('guts').clientWidth+9,
	height: $('guts').clientHeight-11,
	overflow: "auto"
	});
	
close_button = document.createElement("span");	
close_button.id="close_button";
close_button.setStyle({cssFloat: "right"});
close_button.innerHTML="[X]";
Event.observe(close_button,'click',function(){$('root_wordbox').remove();$('splash').remove();});
$('root_wordbox').insertBefore(close_button,$('root_wordbox').childNodes[0]);
}