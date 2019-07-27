<?php
function _getShowsByDate($conn, $date){
	$query = "SELECT * FROM shows WHERE date LIKE '%".$date."%' ORDER BY date ASC";
	$result = $conn->prepare($query);
	$result->execute();
	return $result;
}

function _getShowsByDead($conn){
	$query = "SELECT * FROM shows WHERE isDead = 1 ORDER BY date ASC";
	$result = $conn->prepare($query);
	$result->execute();
	return $result;
}

function _getShowsByPhish($conn){
	$query = "SELECT * FROM shows WHERE isPhish = 1 ORDER BY date ASC";
	$result = $conn->prepare($query);
	$result->execute();
	return $result;
}

function _addShow($conn, $date, $isDead, $isPhish, $notes, $link){
	//check if date already exists, if so return false
	
	$query = "SELECT id FROM shows WHERE (date = '".$date."') ";
	$result = $conn->prepare($query);
	$result->execute();
	
	if($result->rowCount() > 0){
		return false;
	}else{
		$query = "INSERT INTO shows (date, link, isDead, isPhish, notes) VALUES ('".$date."', '".$link."', '".$isDead."', '".$isPhish."', '".$notes."') ";
		$result = $conn->prepare($query);
		$result->execute();
		return true;
	}
}
?>