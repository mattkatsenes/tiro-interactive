<div class="projects index">
<h2>Projects</h2>
<ul>
	<?php
	foreach($projects as $project) {
		
		echo "<li>".$html->link($project['name'],array('action'=>'view',$project['id']))."</li>";
	}
	?>
</ul>