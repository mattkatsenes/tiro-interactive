<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		<?php __('tiro-interactive:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->charset();
		echo $html->meta('icon');

		echo $html->css('tiro.2col');

		echo $scripts_for_layout;
	?>
</head>
<body>
<div id="container">
	<div id="sidebar">
		<div id="logo">
			<?php echo $html->image('tiro4-apollo.jpg'); ?>
		</div>
		<div id="welcome">
			<?php
				if($_DarkAuth['User'] != '')
					echo "Welcome, ".$_DarkAuth['User']['username'].".  ".$html->link('Logout','/users/logout');
				else
					echo "Please ".$html->link('login',"/users/login").", or ".$html->link('create',"/users/add")." a new username.";
			?>
		</div>
	<div id="sidebar_content">
		<?php echo $this->renderElement('sidebar'); ?>
	</div>
</div>

	<div id="mainColumn">
		<div id="menubar">
			<?php echo $this->renderElement('menubar'); ?>
		</div>
		<div id="guts">
			<?php
				if ($session->check('Message.flash')):
						$session->flash();
				endif;
			?>

			<?php echo $content_for_layout; ?>

		</div>
	</div>
		<div id="credits">
			<ul>
				<li>Copyright 2008 Matthew Katsenes</li>
				<li>Powered By <a target="_blank" href="http://www.pradosoft.com">CakePHP</a>, <a href="http://www.perseus.tufts.edu">Perseus</a>, and <a href="http://www.tei-c.org">TEI</a>.</li>
			</ul>
		</div>
	</div>
	<?php echo $cakeDebug; ?>
</body>
</html>
