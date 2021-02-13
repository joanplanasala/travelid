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

var button_search = document.getElementById("button_search"); 

button_search.onclick = function(){
	const xhttp = new XMLHttpRequest();
	let selection = document.getElementById("country").value;
	console.log(selection);
	let url = "http://localhost/travelid/travelid/server/index.php/".concat(selection);
	console.log(url);
	xhttp.open('GET', url, true);
	xhttp.send();

	xhttp.onreadystatechange = function(){
		if(this.readyState ==4 && this.status == 200){
			let data = JSON.parse(this.responseText);
			console.log(data);
			covid_data = data[0].covid_data;
			console.log(covid_data[0]);
			if(covid_data.length != 0){
				let country = new Country(selection, covid_data[0].continent, covid_data[0].population_density, 
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
		}
	}

	return false;
}
 