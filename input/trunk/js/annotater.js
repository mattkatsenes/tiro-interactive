window.onload = init;

function init()
{
	var words = document.getElementsByClassName( 'word', $('span') );
	words.each(function(word){
			
		Event.observe(word, 'click', function(){
			if(word.hasClassName('defined') )
				{
				defineMe(word,false);
				}
			else
				{
				defineMe(word,true);
				}
			});
			
		});
}

function defineMe(term, yesNo)
{
	var url = 'php/define.php';
	
	if (yesNo == true)
	{
		$('main').hide();
		$('glossary').hide();
		$('definition_container').show();
		
		new Ajax.Updater('definition_container', url, {parameters: {term: term.innerHTML, target: term.readAttribute('name')}});
	}
	else
	{
		new Ajax.Updater('glossary', 'php/removeDef.php', {parameters: {target: term.readAttribute('name')},
			onComplete: new Ajax.Updater('main','php/updateText1.php') });
	}

	
}

function chooseDef(num)
{
	$('definition_container').hide()
	$('main').show();
	$('glossary').show();
	
	var definition = $('def_choice_' + num.toString()).serialize();
	new Ajax.Updater('glossary','php/addDef.php',{parameters: definition} );
	new Ajax.Updater('main','php/updateText1.php');
	
	Event.unloadCache();
	init();
}
