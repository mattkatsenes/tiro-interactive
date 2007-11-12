<?php
function getAllPrefs($username)
{
	global $dsn;

	$db =& DB::connect($dsn);
	if (PEAR::isError($db)) {
		die($db->getMessage());
	}

	$res =& $db->query("SELECT * FROM `preferences` WHERE `user_id` =  '$username'");

	$prefs;

	while ($res->fetchInto($row)) {
		$prefs[$row[1]] = $row[2];
	}

	$db->disconnect();

	return $prefs;
}

function showPrefForm($username)
{
//	global $pref_update;

	$pref_update = new HTML_QuickForm('preferences');
	$pref_update->addElement('header','','User Preferences.');

	$user_prefs = getAllPrefs($username);

	foreach($user_prefs as $pref_name => $pref_value)
	{
		if(strstr($pref_name,'dir'))
			unset($user_prefs[$pref_name]);
		else
			$pref_update->addElement('text',$pref_name,$pref_name,array('value' => $pref_value));
	}

	$pref_update->addElement('submit',null,'Update');

	return $pref_update;
}

function updatePrefsDB($username, $pref_arr)
{
	global $dsn;

	$db =& DB::connect($dsn);
	if (PEAR::isError($db)) {
		die($db->getMessage());
	}

	foreach($pref_arr as $key => $value)
	{
		echo "user: $username, pref_name: $key, pref_value: $value";
		$statement = $db->prepare("UPDATE `auth1`.`preferences` SET `pref_value` = '$value' WHERE `preferences`.`user_id` = '$username' AND `preferences`.`pref_id` = '$key' LIMIT 1");
		$db->execute($statement);
	}
}

function updatePrefsOO($username, $pref_arr)
{
	global $prefmanager;

	foreach($pref_arr as $p => $v)
	{
		echo "user: $username, pref_name: $p, pref_value: $v";
		$old = $prefmanager->getPref('matt','email');
		echo "<br>old pref ($p) : $old";
		$prefmanager->setPref($username,$p,$v);
	}
}
?>
