<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Create User');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('password');
	?>
		<div class="input required">
			<label for="UserPasswordConfirm">Confirm Password</label>
			<input type="password" id="UserPasswordConfirm" value="" name="data[User][password_confirm]"/>
		</div>
	
	</fieldset>
<?php echo $form->end('Submit');?>