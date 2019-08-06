<?php
include('header.php');

if(!isset($_SESSION['selectedDate'])){
	header("Location: home.php");
	exit();
}

?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/show.css">
		<?php echo "<title>".$_SESSION["selectedDate"]."</title>" ?>
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
			<center>
				<audio src="" controls id="audioPlayer">
				</audio>
				
				<ul id="playlist" style="list-style:none; margin-top:20;">
<?php
				$dir = "music";
				$files = array_diff(scandir($dir), array('..', '.'));
	
				foreach($files as $file){
					$mp3 = strpos($file, ".mp3");
					$filenomp3 = substr($file, 0, $mp3);
					echo "<li><a href='music/".$file."'>".$filenomp3."</a></li>";
				}
?>
				</ul>
				<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
				<script>
					audioPlayer();
				</script>
			</center>
		</div>
	</body>
</html>

<?php
	function shutdown(){
		unset($_SESSION["selectedDate"]);
	}

	register_shutdown_function("shutdown");
?>
