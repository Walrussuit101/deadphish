<?php

function uploadFile($dir, $file){
	try{
		error_log($dir);
		$target_file = $dir . basename($file["file"]["name"]);
		move_uploaded_file($file["file"]["tmp_name"], $target_file);
		header("Location: show.php");
	}catch(Exception $e){
		echo "<script>".$e->getMessage()."</script>";
	}	
}

?>
