/*
$(document).ready(function(){
 	$('#myCarousel').carousel({
    	interval: 1500
   	})
});
*/
function countPhotos(){
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status==200){
			var max = this.responseText; 
			document.getElementById("photoCount").style.visibility = "visible";
			setTimeout( function() { animate(0, max); }, 100);
		}
	};
	xhttp.open("GET", "http://localhost/inchooApp/index/getPhotoCount", true);
	xhttp.send();
}
		

function animate(current, max){
	if (current != max){
		current++;
		document.getElementById("photoCount").innerText = "#".concat(current);
		setTimeout( function() { animate(current, max); }, 1000/max);
	}
	return;				
}


