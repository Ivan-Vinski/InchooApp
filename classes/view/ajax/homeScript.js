  		$(document).ready(function(){
    		$('#myCarousel').carousel({
      		interval: 1500
    		})
  		});

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
			xhttp.open("GET", "home.php?count=true", true);
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
/*
		function login(){
			var usernameInput = document.getElementById("usernameInput").value;
			var passwordInput = document.getElementById("passwordInput").value;
			var xhttp;
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if(this.readyState == 4 && this.status==200){
					if(this.responseText == "success"){
						window.location.href = "error";
					}
					emptyFields(this.responseText);
				}
			}
			xhttp.open("POST", "home", true)
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("usernameInput="+usernameInput+"&passwordInput="+passwordInput);

		
		}


		function emptyFields(msg){
				toastr.options = {
      				'closeButton': true,
      				'positionClass': 'toast-top-center'
      				}
    			toastr['error'](msg, 'Login')
		}
*/

