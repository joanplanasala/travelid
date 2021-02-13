class Country {
	constructor(iso, name, continent, pop_density, pos_rate, n_cases_pm, n_deaths_pm, percent_vaccin, stringency) {
		this.iso = iso;
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

function insertDataFromCountry(country) {
	document.getElementById("pop_density").innerHTML = country.pop_density;
}

function countrysearched(form) {
	const xhttp = new XMLHttpRequest();
	let url = "http://localhost:8080/travelid/index.php/".concat(document.getElementById(country).value);
	console.log(url);
	xhttp.open('GET', url, true);
	xhttp.send();
  	return false;

  	xhttp.onreadystatechange = function(){
	if(this.readyState ==4 && this.status == 200){
		let data = JSON.parse(this.responseText);
	}	
}

function displaytable() {
	var x = document.createElement("TABLE");
	x.setAttribute("id", "myTable");
  	document.body.appendChild(x);
}


