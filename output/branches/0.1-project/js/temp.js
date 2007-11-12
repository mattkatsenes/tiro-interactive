//Temporary CSS rules, will be moved to seperate files
function getCSSRule(ruleName, deleteFlag) {               // Return requested style obejct
   ruleName=ruleName.toLowerCase();                       // Convert test string to lower case.
   if (document.styleSheets) {                            // If browser can play with stylesheets
      for (var i=0; i<document.styleSheets.length; i++) { // For each stylesheet
         var styleSheet=document.styleSheets[i];          // Get the current Stylesheet
         var ii=0;                                        // Initialize subCounter.
         var cssRule=false;                               // Initialize cssRule. 
         do {                                             // For each rule in stylesheet
            if (styleSheet.cssRules) {                    // Browser uses cssRules?
               cssRule = styleSheet.cssRules[ii];         // Yes --Mozilla Style
            } else {                                      // Browser usses rules?
               cssRule = styleSheet.rules[ii];            // Yes IE style. 
            }                                             // End IE check.
            if (cssRule)  {                               // If we found a rule...
               if (cssRule.selectorText.toLowerCase()==ruleName) { //  match ruleName?
                  if (deleteFlag=='delete') {             // Yes.  Are we deleteing?
                     if (styleSheet.cssRules) {           // Yes, deleting...
                        styleSheet.deleteRule(ii);        // Delete rule, Moz Style
                     } else {                             // Still deleting.
                        styleSheet.removeRule(ii);        // Delete rule IE style.
                     }                                    // End IE check.
                     return true;                         // return true, class deleted.
                  } else {                                // found and not deleting.
                     return cssRule;                      // return the style object.
                  }                                       // End delete Check
               }                                          // End found rule name
            }                                             // end found cssRule
            ii++;                                         // Increment sub-counter
         } while (cssRule)                                // end While loop
      }                                                   // end For loop
   }                                                      // end styleSheet ability check
   return false;                                          // we found NOTHING!
}                                                         // end getCSSRule 

function killCSSRule(ruleName) {                          // Delete a CSS rule   
   return getCSSRule(ruleName,'delete');                  // just call getCSSRule w/delete flag.
}                                                         // end killCSSRule

function addCSSRule(ruleName) {                           // Create a new css rule
   if (document.styleSheets) {                            // Can browser do styleSheets?
      if (!getCSSRule(ruleName)) {                        // if rule doesn't exist...
         if (document.styleSheets[0].addRule) {           // Browser is IE?
            document.styleSheets[0].addRule(ruleName, null,0);      // Yes, add IE style
         } else {                                         // Browser is IE?
            document.styleSheets[0].insertRule(ruleName+' { }', 0); // Yes, add Moz style.
         }                                                // End browser check
      }                                                   // End already exist check.
   }                                                      // End browser ability check.
   return getCSSRule(ruleName);                           // return rule we just created.
} 



/*
Object to hold test data information

key properties:  text, parent->line, timeSpent, id;

key methods:	getNotes, get/setTimeSpent, get/setID, get/setParentLine, getLineTextBox;
*/

tiroTestBlank = Class.create();
tiroTestBlank.prototype = {

	initialize:  function (parentLine)
{
	this.parentLine=parentLine;
	this.id = "textareabox-"+this.parentLine;
	this.timeSpent =  0;
	this.text = "";
	
	this.time_start =0;
	this.time_end = 0;
	
	this.lineTextBox = document.createElement("textarea");
		this.lineTextBox.id 			= this.id;
		this.lineTextBox.name	= this.id;
		this.lineTextBox.className="textbox-test";
		this.lineTextBox.value		="";
},

	textEditIn: function()
	{
	this.time_start = new Date().getTime();
	this.time_end = 0;
	//console.log(this.id + ": EditingText");
	},
	
	textEditOut: function()
	{
	this.time_end = new Date().getTime();
	this.timeSpent += this.time_end - this.time_start;
	
	//console.log(this.id + ": SaveText");
	return (this.time_end - this.time_start);
	},

	testing: function()
	{
	}
	
	
	
};

factory_tiroTestBlank = Class.create();
factory_tiroTestBlank.prototype = {
	initialize: 	function ()
{
 this.members = [];
 getCSSRule(".textbox-test").style.visibility="hidden";
 },
	add:			function(parentLine)
{
	var new_tiroTestBlank = new tiroTestBlank(parentLine);
	this.members.push(new_tiroTestBlank);
	return new_tiroTestBlank;
},
	remove: 	function(parentLine)
{
	toRemove = this.members.find(function(testblank)
		{	
			if( testblank.id==("textareabox-" + parentLine) || testblank.id == parentLine)
			{
				//console.log("removed");
				return true;
			}
			else
				return false;
		});
	toRemove =this.members.indexOf(toRemove);
	
	this.members[toRemove].lineTextBox.parentNode.removeChild(this.members[toRemove].lineTextBox);
	this.members.splice(this.members[toRemove], 1);
},

	listOut:	function()
	{
	function idTextEntry(id, text)
	{this.id = id; this.text =text;};
	var testEntries = new Array();
	
	for(i = 0; i<this.members.length; i++)
		testEntries[i] = new idTextEntry(this.members[i].id,this.members[i].text);
	
	return testEntries;
	}
};




function CallMe(name)
{
document.getElementById("status-code").innerHTML=name;
};

function drew_setOnFocusBlur()
{

loadAllTestTextBoxes();

Event.observe("addTextAreaButton","click", 
	function()
	{
	var textbox_class = getCSSRule(".textbox-test")
	
	var value = $("addTextAreaButton").innerHTML;
	if(value == "[+]")
		{
		$("addTextAreaButton").innerHTML="[-]";
		textbox_class.style.visibility="visible";
		}
	else
		{
		$("addTextAreaButton").innerHTML="[+]";
		textbox_class.style.visibility="hidden";
		}
	});

Event.observe("pagenotes","focus", function() {CallMe("//Begin Entry-notes");});
Event.observe("pagenotes","blur", function() {CallMe("//End Entry-notes");});

/*
Event.observe("pagenotes","keypress", function(g)
															{
															var code = g.which || g.keyCode; 
															if(code == 13)
																{
																alert($("pagenotes").height);
																alert("enter");
																}
															else
																{
																
																}
															
															});
*/
/*
Event.observe("addTextAreaButton","click",loadAllTestTextBoxes);

Event.observe("pagenotes","focus", function() {CallMe("//Begin Entry-notes"); note_time_s=new Date().getTime();});
Event.observe("pagenotes","blur", function() 
						{	
							note_time_e=new Date().getTime();
							CallMe("//Save Entry-notes - "+(note_time_e-note_time_s) + " ms");
						}
					);   
*/
};

/*
function timerTest(i,old_time, list)
{
if(i==0){old_time = new Date().getTime();};
if(i == 10) {return 0;}else{var newtime = new Date().getTime();setTimeout(function(){i=i+1; timerTest(i,newtime);}, 500);$("status-code").innerHTML+=newtime-old_time + ", ";}
};*/

function loadAllTestTextBoxes()
{
var lines = document.getElementsByClassName("l");
var manager_TestBlanks = new factory_tiroTestBlank();

lines.each	(function (line)
	{
		var lineTextBoxArea = manager_TestBlanks.add(line.id);
		var lineTextBoxAreaDiv = line.appendChild(lineTextBoxArea.lineTextBox);
		
		Event.observe(lineTextBoxAreaDiv,"focus", function() {lineTextBoxArea.textEditIn();CallMe("Starting");});
		Event.observe(lineTextBoxAreaDiv,"blur", function() 
																	{
																	recent_time = lineTextBoxArea.textEditOut();
																	CallMe(recent_time + " ms; total: " + lineTextBoxArea.timeSpent + " ms");
																	}
							);
	} );

//console.log(manager_TestBlanks.members.length);
//manager_TestBlanks.remove("LN-21");
//console.log(manager_TestBlanks.members.length);
	/*
		var lineTextBox = document.createElement("textarea");
		var lineTextBoxName ="textbox-"+line.id;
		
			lineTextBox.id		=lineTextBoxName;
			lineTextBox.name	=lineTextBoxName;
			
			lineTextBox.className="textbox-test";
			lineTextBox.value=" ";
			
			line.appendChild(lineTextBox);
			
		Event.observe(lineTextBoxName,"focus", function() {CallMe("//Begin Entry-notes");});
		Event.observe(lineTextBoxName,"blur", function() {CallMe("//Save Entry-notes");});
		}			);
	*/
};