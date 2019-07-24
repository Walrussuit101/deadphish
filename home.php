<?php
include('header.php');

function _getShowsByDate($conn, $date){
	$query = "SELECT * FROM shows WHERE date LIKE '%".$date."%' ORDER BY date ASC";
	$result = $conn->prepare($query);
	$result->execute();
	return $result;
}

function _displayResults($conn, $results){
	while($row = $results->fetch(PDO::FETCH_ASSOC)){
		if($row['isDead'] == 1){
			$artist = "Grateful Dead";
		}else{
			$artist = "Phish";
		}
		
		echo "
			<tr>	
				<td>".$row['date']."</td>
				<td><a href='".$row['link']."' target='_blank'>".$row['link']."</a></td>
				<td>".$artist."</td>
				<td>".$row['notes']."</td>
			</tr>
		";
	}	
	
	if($results->rowCount() == 0){
		echo "<tr style='background-color: red;'><td colspan='4'>NO SHOWS FOUND</td></tr>";
	}
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
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/home.css">
		<title>deadphish | Home</title>
		<link rel="shortcut icon" href="styles/images/icon.png" />
		<script type="text/javascript" src="scripts.js"></script>  
	</head>

	<body class="bg-dark">
		<nav class="navbar navbar-expand navbar-dark bg-secondary fixed-top">
			<a href="home.php">
				<img src="styles/images/dead.png" class="logo img-thumbnail">
				<img src="styles/images/phish.png" class="logo img-thumbnail">
			</a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			
			<ul class="nav navbar-nav ml-auto">
				<form class="form-inline my-2" action="home.php" method="post" autocomplete="off">
					<input class="form-control" type="text" placeholder="Search Date" name="searchDate" value="<?php if(isset($_POST['searchDate'])){echo $_POST['searchDate'];}?>" required='required'>
					<input type="submit" style="display: none;" name="_search">
					<script>document.getElementsByName("searchDate")[0].focus();</script>
				</form>
			</ul>
		</nav>
		
		<div class="content">
		<?php
if(isset($_POST['_search'])){			
echo"		<center>
				<table class='dateTable table table-striped table-dark'>
					<thead>
						<tr>
						  <th scope='col'>Date</th>
						  <th scope='col'>Setlist Link</th>
						  <th scope='col'>Artist</th>
						  <th scope='col'>Notes</th>
						</tr>
					</thead>
					<tbody>";
						
						$results = _getShowsByDate($conn, $_POST['searchDate']);
						_displayResults($conn, $results);
					
echo"
					</tbody>
				</table>
			</center>
";
}else if(isset($_POST['_addShowSubmit'])){
	
	$added = null;
	
	if(isset($_POST['isDead'])){
		
		//build dead url,
		//website doesn't allow 05 for month or day, so decide if string parsing needs to happen
		
		$deadBaseLink = 'https://www.cs.cmu.edu/~mleone/gdead/dead-sets/';
		$deadBaseLink .= substr($_POST['date'],2,2) . "/";
		
		if(substr($_POST['date'],5,1) == '0'){
			$deadBaseLink .= substr($_POST['date'],6,1);
		}else{
			$deadBaseLink .= substr($_POST['date'],5,2);
		}
		
		$deadBaseLink .= "-";
		
		if(substr($_POST['date'],8,1) == '0'){
			$deadBaseLink .= substr($_POST['date'],9,1);
		}else{
			$deadBaseLink .= substr($_POST['date'],8,2);
		}
		
		$deadBaseLink .= "-" . substr($_POST['date'],2,2) . ".txt";
		
		$added = _addShow($conn, $_POST['date'], 1, 0, $_POST['notes'], $deadBaseLink);
		
		
	}else{
		
		//build phish url,
		//website doesn't mind 05 for month or day
		
		$phishBaseLink = 'http://phish.net/setlists/';
		$phishBaseLink .= "?year=" . substr($_POST['date'],0,4);
		$phishBaseLink .= "&month=" . substr($_POST['date'],5,2);
		$phishBaseLink .= "&day=" . substr($_POST['date'],8,2);
		
		$added = _addShow($conn, $_POST['date'], 0, 1, $_POST['notes'], $phishBaseLink);
	}
	
	if($added){
		echo "<script>alert('Show: ".$_POST['date']." was succesfully added!'); window.location = 'home.php';</script>";
	}else{
		echo "<script>alert('Show: ".$_POST['date']." already is stored, aborting addition.'); window.location = 'home.php';</script>";
	}
	
}else{
echo"	
			<center>
				<form class='addForm bg-secondary' onsubmit='return validateDeadPhishButtons();' action='home.php' method='post' autocomplete='off'>
					<div class='form-row justify-content-center pt-4'>
						<div class='form-group col-md-3'>
							<label>Date (yyyy/mm/dd)</label>
							<input type='text' name='date' class='form-control' required='required'>
						</div>
					</div>
					<div class='form-row justify-content-center mb-3'>
						<div class='form-group col-md-2'>
							<label>Dead?</label>
							<input type='checkbox' name='isDead' class='form-control' onclick='deadPhishButtons()'>
						</div>
						<div class='form-group col-md-2'>
							<label>Phish?</label>
							<input type='checkbox' name='isPhish' class='form-control' onclick='deadPhishButtons()'>
						</div>
					</div>
					<div class='form-row justify-content-center pb-4'>
						<div class='form-group col-md-6'>
							<label>Notes</label>
							<textarea type='text' name='notes' class='form-control'></textarea>
						</div>
					</div>
					<div class='form-row justify-content-center pb-4'>
						<div class='form-group col-md-6'>
							<input type='submit' name='_addShowSubmit' class='form-control btn btn-success' value='Add Show'>
						</div>
					</div>
				</form>
			</center>
";
}
		?>	
		</div>
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>