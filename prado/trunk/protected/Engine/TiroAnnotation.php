<?php
/*
 * A class to hold annotation objects.
 * 
 * This will be called by the TiroText class when it is looking up annotations.
 */
class TiroAnnotation
{
	public $id;
	public $type;
	public $content;
	
	/*
	 * string $target holds 'other[ other2]' from <link targets="#THIS-ONE #other[ #other2]"/>
	 */
	public $target;
	
	/*
	 * Build a new TiroAnnotation Object
	 * 
	 * This can be called to build one and then save it, or create the object from existing XML.
	 */
	public function __construct($id,$type,$content,$target)
	{
		$this->id = $id;
		$this->type = $type;
		$this->target = $target;
		
//		echo "annotation created: $id, $type, $target \n";
	}
	
	public function belongsTo($id)
	{
		$targets = explode(' ',$this->target);
		foreach($targets as $possible)
			if($possible == $id)
			{
//				echo "annotation found.\n";
				return true;
			}
		
//		echo "annonation not found.\n";
		return false;
	}
}
?>