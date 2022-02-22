
let map;
window.addEventListener('DOMContentLoaded', ()=>{
  map = L.map('carte').fitBounds([[50.5,2.789],[50.795,3.272]]);
  L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
       attribution: '©️ <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map); 

});

function createDetailMap(commune){
 let div = document.querySelector('#details div.map');
 if (div == null){
  div = document.createElement('div');
  document.getElementById('details').appendChild(div);
 }
 div.classList.add('map');
 let dmap = L.map(div);
 L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
       attribution: '©️ <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(dmap);
 let group = L.featureGroup().addTo(dmap);
 let geo = JSON.parse(commune.geo_shape);
 L.geoJSON([geo]).addTo(group);
 dmap.fitBounds(group.getBounds());
}