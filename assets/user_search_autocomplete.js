// GOOGLE MAP API AUTOCOMPLETE FOR USER SEARCH//
let autocomplete;
let addressField;
let lngField;
let latField;

function initAutocomplete() {
  addressField = document.querySelector("#city");
  latField = document.getElementById('lat');
  lngField = document.getElementById('lng');

  autocomplete = new google.maps.places.Autocomplete(addressField, {
    componentRestrictions: { country: ["fr"] },
    fields: ["address_components", "geometry"],
    types: ["(cities)"], // Recherche uniquement des villes
  });

  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  const place = autocomplete.getPlace();
  let address1 = "";
//   let postcode = "";
//   let city = "";
  let lng = place.geometry.location.lng();
  let lat = place.geometry.location.lat();

  console.log(place.address_components);

  for (const component of place.address_components) {
    const componentType = component.types[0];

    switch (componentType) {
      case "locality": {
        address1 = component.short_name;
        break;
      }

      case "administrative_area_level_1": {
        address1 = address1 +', ' + component.short_name;
        break;
      }

      case "country": {
        address1 = address1 +', ' + component.short_name;
        break;
      }
    }
  }

  addressField.value = address1;
  lngField.value = lng;
  latField.value = lat;
}

window.initAutocomplete = initAutocomplete;
