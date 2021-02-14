
var button_login = document.getElementById("button_login");
var user_loged = "";
var title_link = document.getElementById("title_link");

title_link.onclick = function(){
	location.replace("../docs/index.html");
}

button_login.onclick = function(){
	const xhttp = new XMLHttpRequest();
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value
	if(username != "" && password != ""){  
		let url = "http://localhost/travelid/travelid/server/login_easy.php/"+username+"?"+password;
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
