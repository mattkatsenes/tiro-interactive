<div class="annotations form">
<?php echo $form->create('Annotation');?>
	<fieldset>
 		<legend><?php __('Add Annotation');?></legend>
	<?php
		echo $form->input('type');
		echo $form->input('project_id');
		echo $form->input('link_to');
		echo $form->input('text');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Annotations', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Projects', true), array('controller'=> 'projects', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Project', true), array('controller'=> 'projects', 'action'=>'add')); ?> </li>
	</ul>
</div>
