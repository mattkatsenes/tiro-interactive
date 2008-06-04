
<?php
$this->pageTitle = 'Access Restricted';
echo $form->create('DarkAuth',array('url'=>substr($this->here,strlen($this->base))));
echo $form->input('DarkAuth.username');
echo $form->input('DarkAuth.password');


echo $form->input('DarkAuth.remember_me',array(
	'label'=>'Remember Me? (uses cookies)',
	'type'=>'checkbox'
));

echo $form->input('DarkAuth.cookie_expiry',array(
	'options'=>array(
		'now'=>'end of session',
		'+1 week'=>'in a week',
		'+1 Months'=>'in a month',
		'+6 Months'=>'in 6 months',
		),
	'label'=>'If so, for how long?'
));

 echo $form->end('login');
 ?>