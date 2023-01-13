import './styles/app.scss';
require('bootstrap');
const $ = require('jquery');
require('select2');

$('select').select2();

const deletePictureMethod = (path, data, element) => {
    fetch(path, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify(data)
    })
    .then(res => res.json())
    .then(data => {
        data.success ? element.closest('.form-img-box').remove() : alert('une erreur est survenue, veuillez réessayer plus tard.')
    })
    .catch(err => {
        console.log("error");
    })
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            const csrfToken = button.getAttribute("csrftoken");
            const path = button.getAttribute("href");
            csrfToken && path && deletePictureMethod(path, { '_token': csrfToken }, button);     
        })
    })
})


// GOOGLE MAP API AUTOCOMPLETE//
let autocomplete;
let addressField;
let cityField;
let postalField;
let lngField;
let latField;

function initAutocomplete() {
  addressField = document.querySelector("#property_address");
  cityField = document.querySelector("#property_city");
  postalField = document.querySelector("#property_postal_code");
  latField = document.getElementById('property_lat');
  lngField = document.getElementById('property_lng');

  autocomplete = new google.maps.places.Autocomplete(addressField, {
    componentRestrictions: { country: ["fr"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });

  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  const place = autocomplete.getPlace();
  let address1 = "";
  let postcode = "";
  let city = "";
  let lng = place.geometry.location.lng();
  let lat = place.geometry.location.lat();

  for (const component of place.address_components) {
    const componentType = component.types[0];

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "locality": {
        city = component.long_name;
        console.log(city);
        break;
      }
    }
  }

  addressField.value = address1;
  postalField.value = postcode;
  cityField.value = city;
  lngField.value = lng;
  latField.value = lat;
}

window.initAutocomplete = initAutocomplete;

