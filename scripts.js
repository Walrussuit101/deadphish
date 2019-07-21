function deadPhishButtons(){
	var isDead = document.getElementsByName("isDead")[0];
	var isPhish = document.getElementsByName("isPhish")[0];
	
	if(isDead.checked == true && isPhish.checked == true){
		alert("Please select one artist only");
		isDead.checked = false;
		isPhish.checked = false;
	}	
}