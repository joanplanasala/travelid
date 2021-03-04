
//OBJECT CLASSES DECLARATION
class Country {
	constructor(name, continent, pop_density, pos_rate, n_cases_pm, n_deaths_pm, percent_vaccin, stringency) {
		this.name = name;
		this.continent = continent;
		this.pop_density = pop_density;
		this.pos_rate = pos_rate;
		this.n_cases_pm = n_cases_pm;
		this.n_deaths_pm = n_deaths_pm;
		this.percent_vaccin = percent_vaccin;
		this.stringency = stringency;
	}
}
class Comments {
    constructor(id, username, comment, date, likes) {
        this.id = id;
        this.username = username;
        this.text = comment;
        this.date = date;
        this.likes = likes;
    }
}

//buttons:
var button_search = document.getElementById("button_search");
var button_login_register_screen = document.getElementById("button_login_register_screen");
var button_login = document.getElementById("button_login");
var button_register = document.getElementById("button_register");
var button_comment = document.getElementById("button_comment");
var title_link = document.getElementById("title_link");

//textboxes:
var comment_textbox = document.getElementById("comment_textbox");
var password_textbox = document.getElementById("show-password");
var username_textbox = document.getElementById("username");

//containers:
var ini_screen = document.getElementById("ini_screen");
var data_div = document.getElementById("data");
var forum = document.getElementById("forum");
var login_div = document.getElementById("register_login_screen");
var config_display_ini = ini_screen.style.display;
var config_display_data = data_div.style.display;
var config_display_login = login_div.style.display;

//variables:
var selection = null;
var user_logged = null;
var country = null;
var comment_id = 0;

data_div.style.display = "none";
login_div.style.display = "none";



// BUTTON EVENTS:
button_login_register_screen.onclick = function(){
	data_div.style.display = "none";
	ini_screen.style.display = "none";
	login_div.style.display = config_display_login;
}

button_login.onclick = function(){
	const xhttp = new XMLHttpRequest();
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;
	if(username != "" && password != ""){
		let url = "http://localhost/travelid/travelid/server/login_easy.php/"+username+"?"+password+"?LOG";
		console.log(url);
		xhttp.open('GET', url, true);
		xhttp.send();
		xhttp.onreadystatechange = function(){
			if(this.readyState ==4 && this.status == 200){
				user_logged = JSON.parse(this.responseText);
				if(user_logged[0] != "ERROR"){
					if(selection == null){
						ini_screen.style.display = config_display_ini;
						login_div.style.display = "none";
						data_div.style.display = "none";
					}
					else{
						ini_screen.style.display = "none";
						login_div.style.display = "none";
						data_div.style.display = config_display_data;
					}
				}
				else{
					alert("Error while logging in! revise your inputs.");
				}
			}
		}
	}
	return false;
}

button_register.onclick = function(){
	const xhttp = new XMLHttpRequest();
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;
	if(username != "" && password != ""){
		let url = "http://localhost/travelid/travelid/server/login_easy.php/"+username+"?"+password+"?REG";
		console.log(url);
		xhttp.open('GET', url, true);
		xhttp.send();
		xhttp.onreadystatechange = function(){
			if(this.readyState ==4 && this.status == 200){
				let user_registered = JSON.parse(this.responseText);
				if(user_registered[0] != "ERROR"){
					if(selection == null){
						ini_screen.style.display = config_display_ini;
						login_div.style.display = "none";
						data_div.style.display = "none";
					}
					else{
						ini_screen.style.display = "none";
						login_div.style.display = "none";
						data_div.style.display = config_display_data;
					}
					user_logged = user_registered;
				}
				else{
					alert("User alredy registered! Try to LOG IN.");
				}
			}
		}
	}
	return false;
}


title_link.onclick = function(){
	ini_screen.style.display = config_display_ini;
	data_div.style.display = "none";
	login_div.style.display = "none";
	password_textbox.value = null;
	username_textbox.value = null;

	return false;
}


button_search.onclick = function() {
	selection = document.getElementById("country").value;
	displayall(selection);
	return false;
}


button_comment.onclick = function(){
	let comment_text = comment_textbox.value;
	const xhttp = new XMLHttpRequest();
	console.log(selection, user_logged);
	if(selection != null && user_logged != null){
		let url = "http://localhost/travelid/travelid/server/index.php/"+country.name+'?'+comment_id+'?'+user_logged+"?C?"+comment_text;
		console.log(url);
		xhttp.open('GET', url, true);
		xhttp.send();
		comment_id ++;
	}
	displayall(selection);
	return false;
}


// FUNCTION FOR DISPLAYING DATA:
function displayall(selection){
	ini_screen.style.display = "none";
	data_div.style.display = config_display_data;
	const xhttp = new XMLHttpRequest();
	let url = "http://localhost/travelid/travelid/server/index.php/".concat(selection);
	console.log(url);
	xhttp.open('GET', url, true);
	xhttp.send();

	xhttp.onreadystatechange = function display_data(){
		if(this.readyState ==4 && this.status == 200){
			let data = JSON.parse(this.responseText);
			covid_data = data[0].covid_data;
			comments = data[1].comments;
			if(covid_data.length != 0){
				country = new Country(selection, covid_data[0].continent, covid_data[0].population_density,
					covid_data[0].positive_rate, covid_data[0].main_cases_smoothed_per_million, covid_data[0].new_deaths_smoothed_per_million,
					covid_data[0].people_vaccinated_per_hundred, covid_data[0].stringencyindex);

				document.getElementById("name").innerHTML = country.name;
				document.getElementById("continent").innerHTML = country.continent;
				document.getElementById("pop_density").innerHTML = country.pop_density;
				document.getElementById("pos_rate").innerHTML = parseFloat(country.pos_rate)*100;
				document.getElementById("pos_rate_meter").value = parseFloat(country.pos_rate)*100;
				document.getElementById("n_cases_pm").innerHTML = country.n_cases_pm;
				document.getElementById("n_cases_pm_meter").value = parseInt(country.n_cases_pm);
				document.getElementById("n_deaths_pm").innerHTML = country.n_deaths_pm;
				document.getElementById("n_deaths_pm_meter").value = parseInt(country.n_deaths_pm);
				document.getElementById("percent_vaccin").innerHTML = country.percent_vaccin;
				document.getElementById("percent_vaccin_meter").value = parseInt(country.percent_vaccin);
				document.getElementById("stringency").innerHTML = country.stringency;
				document.getElementById("stringency_meter").value = parseInt(country.stringency);

			}
			forum.innerHTML = "";
			console.log(comments)
			if(comments.length != 0){
				for (let i = 0; i <= comments.length-1; i++) {
					let comment = new Comments(comments[i].id, comments[i].username, comments[i].comment, comments[i].date, comments[i].likes);
					forum.innerHTML +=`
										<div class="post" style="margin:30px">
					                        	<p>${comment.text} Posted by ${comment.username} on ${comment.date} Likes (${comment.likes})</p>
					                     </div>

									`;
				}

			}
		}
	}

	return false;
}
