<?php
	pr($_DarkAuth);

	if(!empty($_DarkAuth['User'])){
		echo "Some content for logged in people!";
	}
	if($_DarkAuth['Access']['Teacher']){
		echo "You have access to 'Teacher'";
	}else{
		echo "You don't have access to 'Teacher'";
	}

?>