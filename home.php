<?php
include('header.php');

$query = "SELECT * FROM testtable WHERE id=2";
$result = $conn->prepare($query);
$result->execute();

while($row = $result->fetch()){
	$name = $row['value'];
}

?>
<html>
	<head>
		<title>It Works</title>
	</head>

	<body>
		<h2><?php echo $name; ?></h2
	</body>
</html>