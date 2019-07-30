<?php
include('header.php');
include('methods/data/homedb.php');
include('methods/display/homedisplay.php');
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
	
}else{
echo"	
			<center>
				<form class='addForm' onsubmit='return validateDeadPhishButtons();' action='home.php' method='post' autocomplete='off'>
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
		
			<audio src="" controls id="audioPlayer">
			</audio>
			
			<ul id="playlist" style="list-style:none;">
				<li><a href="music/[1] Shakedown.mp3">Shakedown Street</a></li>
				<li><a href="music/[2] Bertha.mp3">Bertha</a></li>
			</ul>
			<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
			<script>
				audioPlayer();
				function audioPlayer(){
					var currentSong = 0;
					$('#audioPlayer')[0].src = $('#playlist li a')[0];
					$('#playlist li a').click(function(e){
						e.preventDefault();
						$('#audioPlayer')[0].src = this;
						$('#audioPlayer')[0].play();
						document.title = $(this).html();
						$('#playlist li').removeClass('currentSong');
						currentSong = $(this).parent().index();
						$(this).parent().addClass('currentSong');
					});
					
					$('#audioPlayer')[0].addEventListener('ended', function(){
						currentSong++;
						if(currentSong == $('#playlist li a').length)
							currentSong = 0;
						$('#playlist li').removeClass('currentSong');
						$('#playlist li:eq('+currentSong+')').addClass('currentSong');
						$('#audioPlayer')[0].src = $('#playlist li a')[currentSong].href;
						$('#audioPlayer')[0].play();
					});
				}
			</script>
		</div>
		
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>