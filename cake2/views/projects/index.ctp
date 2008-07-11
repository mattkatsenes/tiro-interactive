<div class="projects index">
<h2>Your Projects</h2>
<ul>
	<?php
	foreach($projects as $project)
		echo "<li>".$html->link($project['name'],array('action'=>'view',$project['id']))." (". $html->link('delete',array('action'=>'delete', $project['id'])) .")</li>";
	?>
</ul>
<p>Create a 
<?php
echo $html->link("new Project",array('action'=>'add'));
?>
.</p>
</div>