<?

include "tei_headword.php";

$word = $_POST['term'];
$target = $_POST['target'];

echo "Our word is: $word \n";

$definitions = shell_exec("../words/words $word");
$lines = preg_split('/\r|\n/',$definitions);

$possible_defs;
$def_count = 0;

$line_num = 0;
$max = count($lines);

while($line_num < $max)
{	
	if(preg_match('/\[[A-Z]{5}\]/',$lines[$line_num]))
	{
		// orth_info[1] = orthographic form
		// orth_info[2] = Part of Speech
		// orth_info[3-4] = Further WORDS info (3=GENDER for nouns)
		// orth_info[5] = [XXXXX]
		// orth_info[6]? = 'NeoLatin Lesser' or other ancillary info
		preg_match('/(.+, [\w\-]+|\w+)? +(\w+)? +(\w+)? +(\w+)? +(\[\w+\]) +(.+)?/',$lines[$line_num],$orth_info);
				
		$possible_defs[$def_count] = new teiHeadword();
		$possible_defs[$def_count]->addParam('orth',$orth_info[1]);
		$possible_defs[$def_count]->addParam('pos',strtolower($orth_info[2]));
		
		if($orth_info[2] == 'N' && isset($orth_info[6]))
		{
			$possible_defs[$def_count]->addParam('gen',strtolower($orth_info[3]));
			$possible_defs[$def_count]->addParam('subc',"$orth_info[6]");
		}
		elseif($orth_info[2] == 'N')
		{
			$possible_defs[$def_count]->addParam('gen',strtolower($orth_info[3]));
		}
		elseif(isset($orth_info[6]))
			$possible_defs[$def_count]->addParam('subc',"$orth_info[3] $orth_info[4] $orth_info[6]");
		else
			$possible_defs[$def_count]->addParam('subc',"$orth_info[3] $orth_info[4]");
			
		// Now extract the definition from $lines
		
		$def_lines = 1;
		$offset=1; //in case we have 2+ head entries on one def.
		$def = "";
		
		while(preg_match('/\[[A-Z]{5}\]/',$lines[$line_num+$offset]))
		{	
				$offset++; 
		}
		
		while(!preg_match('/\[[A-Z]{5}\]/',$lines[$line_num+$offset+$def_lines]) && $line_num+$offset+$def_lines<$max)
			{	$def_lines++; }
		
		for($i = $offset; $i < $offset+$def_lines; $i++)
			{	$def .= $lines[$line_num + $i]; }
		
		$possible_defs[$def_count]->addParam('def',$def);
		
		$def_count++;
	}
	
	$line_num++;
}

$definition_number=0;
foreach($possible_defs as $def)
{
	echo <<<EOT
<form id="def_choice_$definition_number">
<table>
<tr>
	<td>
		<input type="button" value="Choose" onClick="chooseDef($definition_number);" /></td>
	<td>HELLO THIS IS POSSIBLE_DEF $definition_number<br />
EOT;
	$def->prettyOutput();
	echo <<<EOT
<input type="hidden" value="$target" name="target" />
	</td>
</tr>
</table>
</form>
EOT;
$definition_number++;
}
?>
