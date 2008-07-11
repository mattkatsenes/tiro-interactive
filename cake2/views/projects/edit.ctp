<?php echo $javascript->link(array('prototype.js','scriptaculous'),false); ?>

<div class="projects edit">

<h2>Edit: <?php echo $this->data['Project']['name']; ?></h2>
<p>Click a section of text to edit it!</p>

<pre>
<?php
	foreach($sections as $id => $section) {
		echo "<div id=\"".$id."\">".$section."</div>";
	}
?>
</pre>

<?php
foreach($sections as $id => $section)
	echo $ajax->editor($id,
						 array('controller'=> 'projects',
						 	   'action' => 'textAdd',
						 	   'id'=>$this->data['Project']['id']),
						 	   array('rows'=> 10,
						 	   		 'cols'=>70)); 

?>



</div>