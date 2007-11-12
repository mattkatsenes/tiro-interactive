var url = "php/prose_poetry.php";

function choosePoetry()
{
	new Ajax.Updater('main', url, { parameters: {choice: 'poetry'} });
	new Insertion.Bottom('submit_button','<input type="hidden" name="choice" value="poetry" /><input type="button" value="Annotate!" onClick="saveXML();" />');
}

function chooseProse()
{
	new Ajax.Updater('main', url, { parameters: {choice: 'prose'} });
	new Insertion.Bottom('submit_button','<input type="hidden" name="choice" value="prose" /><input type="submit" value="Annotate!" />');
}

function addLine(currentNumber)
{
	$('more_button').remove();
	new Ajax.Request(url, {          
		parameters: {choice: 'poetry_morelines', current_number: currentNumber},
		onSuccess: function(thingy){
			new Insertion.Bottom('main',thingy.responseText);
		}
	} );
}

function saveXML()
{
	var params = $('annotate1').serialize();
	new Ajax.Request('php/step1save.php',{parameters: params, method: 'get',
			onSuccess: function(){
				window.location = 'annotate1.php';
			}
	});
}
