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
		echo "row returned";
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
			</tr>
		";
	}	
	
	if($results->rowCount() == 0){
		echo "<tr style='background-color: red;'><td colspan='3'>NO SHOWS FOUND</td></tr>";
	}
}

?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/home.css">
		<title>It Works</title>
		<link rel="shortcut icon" href="styles/images/icon.png" />
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
					<input class="form-control" type="text" placeholder="Search Date" name="searchDate" value="<?php if(isset($_POST['searchDate'])){echo $_POST['searchDate'];}?>">
					<input type="submit" style="display: none;" name="_search">
				</form>
			</ul>
		</nav>
		
		<?php
			if(isset($_POST['_search'])){
			
echo"	<center>
			<table class='dateTable table table-striped table-dark'>
				<thead>
					<tr>
					  <th scope='col'>Date</th>
					  <th scope='col'>Setlist Link</th>
					  <th scope='col'>Artist</th>
					</tr>
				</thead>
				<tbody>";
					
					$results = _getShowsByDate($conn, $_POST['searchDate']);
					_displayResults($conn, $results);
					
echo"
				</tbody>
			</table>
		</center>";
			}
		?>
		
		
		
		
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>