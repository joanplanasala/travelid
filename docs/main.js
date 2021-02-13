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
			covid_data = data.covid_info;
			let country = new Country(covid_data.iso_code, covid_data.location, covid_data.continent, covid_data.population_density, 
				covid_data.positive_rate, covid_data.new_cases_smoothed_per_million, covid_data.new_deaths_smoothed_per_million, 
				covid_data.people_vaccinated_per_hundred, covid_data.stringency_index);

			insertCovidDataFromCountry(country);
		}
	}
}