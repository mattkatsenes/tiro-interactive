<?php
$packages = array(
	'prototype' => array('prototype.js'),
	'scriptaculous' => array('scriptaculous/scriptaculous.js',
							 'scriptaculous/builder.js'),
	'effects' => array('scriptaculous/effects.js'),
	'controls' => array('scriptaculous/controls.js'),
	'dragdrop' => array('scriptaculous/dragdrop.js'),
	'slider' => array('scriptaculous/slider.js'),
	'expander' => array('expander.js'),
	'annotator' => array('annotator.js')
);
	
$deps = array(
	'prototype' => array('prototype'),
	'scriptaculous' => array('prototype','scriptaculous'),
	'effects' => array('prototype','scriptaculous','effects'),
	'dragdrop' => array('prototype','scriptaculous','effects','dragdrop'),
	'slider' => array('prototype','scriptaculous','effects','slider'),
	'expander' => array('prototype', 'expander'),
	'annotator' => array('prototype','scriptaculous','effects','annotator')
);

return array($packages,$deps);
?>