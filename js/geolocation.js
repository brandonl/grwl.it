  var geocoder;
  var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);
  var map;
  var infowindow = new google.maps.InfoWindow();
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var myOptions = {
    	zoom: 6,
    	mapTypeId: 'roadmap'

    };
  	map = new google.maps.Map(document.getElementById("_geo_map"), myOptions);
  	map.setCenter(newyork);
  	//loadGeoPins(uname);
  }



  function codeLatLng(lat,lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
                            var country;
                            var state;
                            var locality;
                                $.each(results[0].address_components, function(){
                                if($.inArray("country",this.types) > -1) country = this.long_name;
                                else if($.inArray("administrative_area_level_1",this.types) > -1) state = this.short_name;
                                else if($.inArray("locality",this.types) > -1) locality = this.long_name;
                                });
          if( country == "United States" )
          {
          $('#loc').val(state);
          }
          else{
          $('#loc').val(country);
          }
          $('#subloc').val(locality);
          $('#geo_btn').replaceWith('<p>This is where you be: '+$('#subloc').val()+','+$('#loc').val()+'</p>');
          map.setCenter(latlng);
          map.setZoom(10);
  			infowindow.setContent("You Are Here.");
  			infowindow.setPosition(latlng);
  			infowindow.open(map);
        } else {
          alert("No results found");
        }
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });
  }
  
  function getGeolocation(){
    $('#geo_btn').replaceWith('<p id="geo_btn"><img src="/images/loading.gif"></p>');
  // Try W3C Geolocation method (Preferred)
  if(navigator.geolocation) {
    browserSupportFlag = true;
    navigator.geolocation.getCurrentPosition(function(position) {
      initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
      $('#lat').val(initialLocation.lat());
      $('#lng').val(initialLocation.lng());
	  codeLatLng(initialLocation.lat(),initialLocation.lng());
    }, function() {
      handleNoGeolocation(browserSupportFlag);
    });
  } else {
    // Browser doesn't support Geolocation
    browserSupportFlag = false;
    handleNoGeolocation(browserSupportFlag);
  }
}

function loadGeoPins(_uname){
	/*$.ajax({
		type:"POST",
		url: "handler.php",
		data: "map_user="+_uname,
		success: function(msg){
		//stuff but its not getting the array...
		alert(msg);
		$.each(msg,function(){
		//alert(this);
		});
   		}
	});*/
}


function handleNoGeolocation(errorFlag) {
  if (errorFlag == true) {
    //initialLocation = newyork;
    contentString = "Error: The Geolocation service failed.";
    alert(contentString);
  } else {
    //initialLocation = siberia;
    contentString = "Error: Your browser doesn't support geolocation. Are you in Siberia?";
    alert(contentString);
  }
	$('#geo_btn').replaceWith('<button id="geo_btn" onclick="getGeolocation()" type="button">Add your location</button>');
}