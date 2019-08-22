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
				<td><form action='home' method='post'><button class='form-control btn btn-success' type='submit' name='_goToShow' value='".$row['date']."'>Go</button></form></td>
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

function _displayAddForm(){
	echo"	
			<center>
				<form class='addForm' onsubmit='return validateDeadPhishButtons();' action='home.php' method='post' autocomplete='off'>
					<div class='form-row justify-content-center pt-4'>
						<div class='form-group col-md-3'>
							<label>Date (yyyy-mm-dd)</label>
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
