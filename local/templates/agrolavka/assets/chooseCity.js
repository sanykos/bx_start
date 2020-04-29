function redirect_to_domain(TF_LOCATION_CITY_ID, TF_LOCATION_CITY_NAME) {
	console.log(TF_LOCATION_CITY_ID, TF_LOCATION_CITY_NAME)
}

BX.addCustomEvent("onTFLocationSetLocation", function(location)
{
	return;
	
	var cities = {
		'Москва' : 'http://msk.agrolavka-shop.ru',
		'Санкт-Петербург' : 'http://agrolavka-shop.ru',
	}
    $location = $(location);
	console.log($location)
	var city = $location.data('name')
	if (typeof cities[city] != 'undefined') {
		var link = location.href.replace(/http:\/\/.*?\//, cities[city])
		window.location.href = link		
	}
});