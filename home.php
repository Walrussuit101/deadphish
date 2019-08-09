<?php
include('header.php');
include('methods/data/homedb.php');
include('methods/display/homedisplay.php');

unset($_SESSION["selectedDate"]);
?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/home.css">
		<title>deadphish | Home</title>
		<link rel="shortcut icon" href="styles/images/icon.png" />
		<script type="text/javascript" src="scripts.js"></script>  
	</head>

	<body>
		<nav class="navbar navbar-expand navbar-dark fixed-top">
			<a href="home.php">
				<img src="styles/images/dead.png" class="logo img-thumbnail">
				<img src="styles/images/phish.png" class="logo img-thumbnail">
			</a>
			
			<ul class="nav navbar-nav ml-auto mr-4">
				<form class=" ml-auto" action="home.php" method="post" style="color: white;"> 
					<div style="float: left;" class="mr-4">
						<label>Dead</label>
						<input type="checkbox" class="form-control" onChange="this.form.submit()" name="_searchByDead"></button>
					</div>
					<div style="float: left;">
						<label>Phish</label>
						<input type="checkbox" class="form-control" onChange="this.form.submit()" name="_searchByPhish"></button>
					</div>
				</form>
			</ul>
			
			<ul class="nav navbar-nav" style="float: right;">
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
			$results = _getShowsByDate($conn, $_POST['searchDate']);
			_displayResults($conn, $results);	
}else if(isset($_POST['_searchByDead'])){
			$results = _getShowsByDead($conn);
			_displayResults($conn, $results);
}else if(isset($_POST['_searchByPhish'])){
			$results = _getShowsByPhish($conn);
			_displayResults($conn, $results);
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
	
}else if(isset($_POST['_goToShow'])){
	$_SESSION['selectedDate'] = $_POST['_goToShow'];
	header("Location: show.php");
	exit();
}else{
	_displayAddForm();
}
		?>	
		</div>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>
