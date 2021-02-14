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

var user_logged = "EXAMPLE";
var country;
var comment_id = 0;
var button_search = document.getElementById("button_search"); 
var button_comment = document.getElementById("button_comment"); 
var ini_screen = document.getElementById("ini_screen");
var data_div = document.getElementById("data");
var forum = document.getElementById("forum");
var comment_textbox = document.getElementById("comment_textbox");
var title_link = document.getElementById("title_link");
var reg_log_button = document.getElementById("reg_log_button");
var config_display = ini_screen.style.display;

reg_log_button.onclick = function(){
	location.replace("../travelid/public/login.html");
}
title_link.onclick = function(){
	ini_screen.style.display = config_display;
}


button_search.onclick = function(){
	ini_screen.style.display = "none";
	const xhttp = new XMLHttpRequest();
	let selection = document.getElementById("country").value;
	console.log(selection);
	let url = "http://localhost/travelid/travelid/server/index.php/".concat(selection);
	console.log(url);
	xhttp.open('GET', url, true);
	xhttp.send();

	xhttp.onreadystatechange = function display_data(){
		if(this.readyState ==4 && this.status == 200){
			let data = JSON.parse(this.responseText);
			console.log(data);
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
			if(comments.length != 0){
				for (var i = 0; i <= comments.length-1; i++) {
					let comment = new Comments(comments[i].id, comments[i].username, comments[i].comment, comments[i].date, comments[i].likes);
					forum.innerHTML +=`
										<div class="post">
					                        <div class="entry">
					                        	<p>${comment.text}</p>
					                        </div>
					                        <p>Posted by ${comment.username} on ${comment.date}</p>
					                        <p>Likes (${comment.likes})</p> 
					                    </div>
									`;
				}

			}
		}
	}

	return false;
}

button_comment.onclick = function(){
	let comment_text = comment_textbox.value;
	const xhttp = new XMLHttpRequest();
	if(country != null){
		let url = "http://localhost/travelid/travelid/server/index.php/"+country.name+'?'+comment_id+'?'+user_logged+"?C?"+comment_text;
		console.log(url);
		xhttp.open('GET', url, true);
		xhttp.send();
		comment_id ++;
	}
	return false;

}