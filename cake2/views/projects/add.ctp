<div class="projects form">
<?php echo $form->create('Project');?>
	<fieldset>
 		<legend><?php __('Add Project');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('user_id');
		echo $form->input('xml_text');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Projects', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Annotations', true), array('controller'=> 'annotations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Annotation', true), array('controller'=> 'annotations', 'action'=>'add')); ?> </li>
	</ul>
</div>
