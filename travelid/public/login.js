
var button_login = document.getElementById("button_login");
var user_loged = "";

button_login.onclick = function(){
	const xhttp = new XMLHttpRequest();
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value
	if(username != "" && password != ""){  
		let url = "http://localhost/travelid/travelid/login.php/"+username+"?"+password;
		console.log(url);
		xhttp.open('GET', url, true);
		xhttp.send();
		xhttp.onreadystatechange = function(){
			if(this.readyState ==4 && this.status == 200){
				user_loged = this.responseText;
			}
		}
	}
}

function get_user_loged(){
	return user_loged;
}	
