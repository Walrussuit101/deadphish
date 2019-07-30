function deadPhishButtons(){
	var isDead = document.getElementsByName("isDead")[0];
	var isPhish = document.getElementsByName("isPhish")[0];
	
	if(isDead.checked == true && isPhish.checked == true){
		alert("Please select one artist only");
		isDead.checked = false;
		isPhish.checked = false;
	}	
}

function validateDeadPhishButtons(){
	var isDead = document.getElementsByName("isDead")[0];
	var isPhish = document.getElementsByName("isPhish")[0];
	
	if(isDead.checked == false && isPhish.checked == false){
		alert("Please choose an artist");
		return false;
	}else{
		return true;
	}
}

function audioPlayer(){
	var currentSong = 0;
	$('#audioPlayer')[0].src = $('#playlist li a')[0];
	$('#playlist li a').click(function(e){
		e.preventDefault();
		$('#audioPlayer')[0].src = this;
		$('#audioPlayer')[0].play();
		document.title = $(this).html();
		$('#playlist li a').removeClass('currentSong');
		currentSong = $(this).parent().index();
		$(this).addClass('currentSong');
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