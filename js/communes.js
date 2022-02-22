
window.addEventListener('load',initForm);
function initForm(){

  fetchFromJson('services/getTerritoires.php')
  .then(processAnswer)
  .then(makeOptions);

  fetchFromJson('services/getRecensement.php')
  .then(processAnswer)
  .then(makeOptionsRecens);

  document.forms.form_communes.addEventListener("submit", sendForm);

  // décommenter pour le recentrage de la carte :
  document.forms.form_communes.territoire.addEventListener("change",function(){
  centerMapElt(this[this.selectedIndex]);
  });


}

function processAnswer(answer){
  if (answer.status == "ok")
    return answer.result;
  else
    throw new Error(answer.message);
}


function makeOptions(tab){
  for (let territoire of tab){
    let option = document.createElement('option');
    option.textContent = territoire.nom;
    option.value = territoire.id;
    document.forms.form_communes.territoire.appendChild(option);
    for (let k of ['min_lat','min_lon','max_lat','max_lon']){
      option.dataset[k] = territoire[k];
    }
  }
}

function makeOptionsRecens(tab){

  for(let year of tab){
    let option = document.createElement('option');
    option.textContent = year.recensement;
    option.value = year.recensement;
    document.forms.form_communes.recensement.appendChild(option);

  }
}


function sendForm(ev){ // form event listener

  ev.preventDefault();
  let args = new FormData(this);
  let queryString = new URLSearchParams(args) ;
  let url = 'services/getCommunes.php?'+queryString ;

  fetchFromJson(url)
  .then(processAnswer)
  .then(makeCommunesItems);
}


function makeCommunesItems(tab){

 liste_communes = document.getElementById("liste_communes");
 liste_communes.innerHTML = "";
 for (let commune of tab) {
   let li = document.createElement('li');
   li.textContent = commune.nom;

   for (let k of ['insee', 'lat', 'lon', 'min_lat', 'min_lon', 'max_lat', 'max_lon']){
     li.dataset[k] = commune[k];
   }

   span = document.createElement('span');

   span.className = "fa fa-star";

   li.appendChild(span);
   liste_communes.appendChild(li);

   li.addEventListener("mouseover", function(){ centerMapElt(this) } );
   li.addEventListener('click', function(){ fetchCommune(this) } );
   span.addEventListener('click', function(){ addRemoveFavori(this) } );
 }
 getFavoris();
}

function fetchCommune(elt){
  //console.log('services/getDetails.php?insee='+elt.dataset.insee);
  fetchFromJson('services/getDetails.php?insee='+ elt.dataset.insee)
  .then(processAnswer)
  .then(displayCommune);

}

function displayCommune(commune){
  if(document.querySelector('#details table') != null){
    document.querySelector('#details table').remove();}


  details = document.getElementById('details');
  details.appendChild(document.createElement('table'));


  table = document.querySelector('#details table');
  table.appendChild(document.createElement('thead'));

  thead = document.querySelector('#details table thead');
  thead.appendChild(document.createElement('tr'));

  tr = document.querySelector('#details table thead tr');
  tr.appendChild(document.createElement('th'));

  th = document.querySelector('#details table thead tr th');
  th.textContent = commune.nom;
  th.setAttribute("colspan", "2");

  document.querySelector('#details table').appendChild(document.createElement('tbody'));
  nomDetail = ['Insee', 'Nom du territoire', 'Surface', 'Périmètre', 'Population (2016)', 'Latitude', 'Longtitude'];
  k = 0;
for (let detail in commune){
  if (detail != 'nom' && detail != 'geo_shape') {
    let tr = document.createElement('tr');
    let td = tr.appendChild(document.createElement('td'));
    td.textContent = nomDetail[k]; k++;
    let td2 = tr.appendChild(document.createElement('td'));
    td2.textContent = commune[detail] ;

    element = document.querySelector('#details table tbody');
    element.appendChild(tr);
  }

  if(document.querySelector('#details div.map') != null){
    document.querySelector('#details div.map').remove();}
  let tmp = document.createElement('div');
  tmp.className = 'map';
  details.appendChild(tmp);
  createDetailMap(commune);
}

}

/**
 * Recentre la carte principale autour d'une zone rectangulaire
 * elt doit comporter les attributs dataset.min_lat, dataset.min_lon, dataset.max_lat, dataset.max_lon,
 */
function centerMapElt(elt){
  let ds = elt.dataset;
  map.fitBounds([[ds.min_lat,ds.min_lon],[ds.max_lat,ds.max_lon]]);
}



// Login #################################################################


function addRemoveFavori(elt){

    if (elt.className == 'fa fa-star'){
      addFavori(elt.parentNode);
    }
    else if (elt.className == 'fa fa-star checked') {
      removeFavori(elt.parentNode);
    }


}

function addFavori(elt){

  fetchFromJson('services/addFavori.php?insee='+elt.dataset['insee'])
  .then(processAnswer)
  .then(makeCheck);
}

function makeCheck(result){
  liList = document.querySelectorAll('#liste_communes li');
  for (let li of liList){
    if (li.dataset['insee'] == result){
      li.children[0].className = 'fa fa-star checked';
      li.children[0].style.color = 'gold';
      li.children[0].style.textContent = '\f005';
    }
  }
}

function removeFavori(elt){
  fetchFromJson('services/removeFavori.php?insee='+elt.dataset['insee'])
  .then(processAnswer)
  .then(takeCheck);

}

function takeCheck(result){
  liList = document.querySelectorAll('#liste_communes li');
  for (let li of liList){
    if (li.dataset['insee'] == result){
      li.children[0].className = 'fa fa-star';
      li.children[0].style.color = 'black';
      li.children[0].style.textContent = '\f006';
    }
  }
}

function getFavoris(){
  fetchFromJson('services/getFavoris.php')
  .then(processFavAnswer)
  .then(makeListFavoris);

}

function processFavAnswer(answer){
  if (answer.status == "ok") {
    return answer.result
  }
}


function makeListFavoris(tab){

  if (tab != null && tab != undefined) {
    tab = tab[0].favoris;
    tab = tab.substring(1, tab.length-1);
    tab = tab.split(',');

    liList = document.querySelectorAll('#liste_communes li');

    for (let li of liList){

      if (tab.find(element => element == li.dataset['insee']) != undefined ) {
        li.children[0].className = 'fa fa-star checked';
        li.children[0].style.color = 'gold';
        li.children[0].style.textContent = '\f005';
      }
    }
  }
}
function sendFav(tab){
  tab = tab[0].favoris;
  tab = tab.substring(1, tab.length-1);
  tab = tab.split(',');
  return tab;
}
function selectFavoris(){
  return fetchFromJson('services/getFavoris.php')
  .then(processFavAnswer)
  .then( (value) => {return (value[0].favoris);});
}
