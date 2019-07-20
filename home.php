<?php
include('header.php');
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

			
			<div class="collapse navbar-collapse">
			<!--
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
				</ul>
			-->
				<ul class="nav navbar-nav ml-auto">
					<form class="form-inline my-2" action="home.php" method="post">
						<input class="form-control" type="text" placeholder="Search Date" name="searchDate">
						<input type="submit" style="display: none;" name="_search">
					</form>
				</ul>
			</div>
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
					
					//handle rows
					
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