<div class="projects view">
<h2><?php echo $project['Project']['name']; ?></h2>
These are the actions you may perform on this project:

<table class="options">
	<tr>
		<th>Name</th>
		<th>Function</th>
	</tr>
	<tr>
		<td><?php echo $html->link('Edit',array('action' => 'edit',$project['Project']['id'])); ?></td>
		<td>Add or delete text.</td>
	</tr>
	<tr>
		<td><?php echo $html->link('Annotate',array('action' => 'annotate',$project['Project']['id'])); ?></td>
		<td>Add definitions, notes, images, or links.</td>
	</tr>
	<tr>
		<td><?php echo $html->link('Publish',array('action' => 'publish',$project['Project']['id'])); ?></td>
		<td>Combine all these annotations into one document for view online or in print.</td>
	</tr>
</table>
<?php echo $pretty; ?>

</div>
