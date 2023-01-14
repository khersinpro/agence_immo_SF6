// MAP FOR PROPERTY LOCALISATION SHOW

// Initialize and add the map
const mapContainer = document.getElementById("map");
const position = { lat: parseFloat(mapContainer.getAttribute('data-lat')) , lng: parseFloat(mapContainer.getAttribute('data-lng')) };

if (position.lat && position.lng) {
    function initMap() {
    
        const map = new google.maps.Map(mapContainer, {
            zoom: 13,
            center: position,
        });
    
        const circle = new google.maps.Circle({
            center:position, 
            map: map, 
            radius: 2000, 
            fillColor: "#0000FF", 
            fillOpacity: 0.1, 
            strokeColor: "#FFFFFF", 
            strokeOpacity: 0.1, 
            strokeWeight: 2 ,
    
            });
    }
    window.initMap = initMap;
}
