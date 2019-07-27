<?php
function _displayResults($conn, $results){
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
	
	echo"
					</tbody>
				</table>
			</center>";
	
}
?>