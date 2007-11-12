<?

$choice = $_POST['choice'];

if($choice == 'poetry')
{
	OutputPoetryLines(2,1);
}
elseif($choice == 'prose')
{
	OutputProseChunk(1);
}
elseif($choice == 'poetry_morelines')
	OutputPoetryLines(1,$_POST['current_number']);
else
	echo "we've had an error.  You pressed: " . $choice ;
	


//outputs input field(s) for $number poetry line(s)
function OutputPoetryLines($number, $line_number)
{
	for($count = 1; $count <= $number; $count++)
	{
		echo <<<EOT
{$line_number}: <input name="line_{$line_number}" type="text" size="100" /> <br />
EOT;
		$line_number++;
	}
	
	echo  <<<EOT
	<input type="button" id="more_button" value="More"  onclick="addLine({$line_number});" />
EOT;
}

//outputs input field(s) for $number chunk(s) of prose.
function OutputProseChunk($number)
{
	echo "prosey!";
}

?>
