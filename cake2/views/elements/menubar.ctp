<ul>
<?php
	/**
	 * @var array Possible things to go in the menubar.
	 */
	$options = array(
		'Login' => array('controller'=>'users','action'=>'login'),
		'Logout' => array('controller'=>'users','action'=>'logout'),
		'Projects' => array('controller'=>'projects','action'=>'index')
	);
	
	// unset the stuff available to users, OR unset 'Login'
	if(!$_DarkAuth || $_DarkAuth['User'] == '')
		unset($options['Logout'],$options['Projects']);
	else
		unset($options['Login']);	
	foreach($options as $name => $link) {
		echo "<li>".$html->link($name,$link)."</li>";
	}
?>
</ul>