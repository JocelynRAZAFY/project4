const mymap = L.map('issMap').setView([0, 0], 1); // [51.505, -0.09], 13
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1Ijoiam9yYXoiLCJhIjoiY2thbGV6eDM2MGF6NjJybXZ4c3N0djcwOSJ9.A8AGCZLfRmUO9qJpGdspVg'
}).addTo(mymap);

// Make a marker with custom icon
const issIcon = L.icon({
    iconUrl: '../../img/iss200.png',
    iconSize: [50, 32],
    iconAnchor: [25, 16]
});
const maker = L.marker([0, 0]).addTo(mymap);

const apiUrl = 'https://api.wheretheiss.at/v1/satellites/25544'
//const maker = L.marker([0, 0], {icon: issIcon}).addTo(mymap);

getISS()
setInterval(getISS, 1000)
let firtTime = true

function getISS(){
        fetch(apiUrl)
        .then(response => {
            return response.json();
        }).then(data => {
            const {latitude, longitude} = data
            document.getElementById('lat').textContent = latitude.toFixed(2)
            document.getElementById('lon').textContent = longitude.toFixed(2)
            maker.setLatLng([latitude,longitude])
            if(firtTime){
                mymap.setView([latitude,longitude],2)
                firtTime = false
            }

        })
}

