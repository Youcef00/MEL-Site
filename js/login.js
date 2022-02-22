window.addEventListener('load', initLog);
function initLog(){
  fetchFromJson('services/log.php')
  .then(processLogAnswerAfterLoading);
}


function sendLogForm(ev){

  ev.preventDefault();
  let args = new FormData(this);
  let url = 'services/login.php';

  fetchFromJson(url, {method:"post", body: args})
  .then(processLogAnswer);
}

function disconnect(ev){
  ev.preventDefault();
  let url = 'services/logout.php';
  fetchFromJson(url)
  .then(processLogoutAnswer);
}

function processLogoutAnswer(tab){
  if (tab.status == 'ok') {
    makeAnswerLogIn();
    removeAllFavoris();
  }
}
function processLogAnswerAfterLoading(answer){
  if (answer.status == "ok"){
    makeAnswerLogOut(answer.result);
    updateFavoris();}
  else{

    makeAnswerLogIn();}
}
function processLogAnswer(answer){
  if (answer.status == "ok"){
    makeAnswerLogOut(answer.result);
    updateFavoris();}
  else{
    makeMessageLogin();
    makeAnswerLogIn();}
}
function makeMessageLogin(tab){
  message = document.getElementById("content");
  message.innerHTML = '';
  let msg = document.createElement('p');
  msg.textContent = "Erreur! Login ou Mot de passe incorrect ";
  message.appendChild(msg);
  window.location.href = window.location.href.replace('#', '')+ '#popup1';
  
}
function makeAnswerLogOut(tab){
  header = document.getElementById('user');
  header.innerHTML = '';
  p = document.createElement('p');
  p.textContent = tab.prenom+' '+tab.nom+' ( '+tab.login+' )';
  header.appendChild(p)

  form = document.createElement('form');
  logoutBtn = document.createElement('button');
  logoutBtn.textContent = 'Deconnexion';
  logoutBtn.setAttribute('type', 'submit');
  form.appendChild(logoutBtn);
  header.appendChild(form);
  form.addEventListener("submit", disconnect);}

function makeAnswerLogIn(){

  header = document.getElementById('user');
  header.innerHTML = '';
  form = document.createElement('form');
  form.setAttribute('method', 'post');
  form.setAttribute('action', '');
  fieldset = document.createElement('fieldset');
  form.appendChild(fieldset);
  login = document.createElement('input');
  login.setAttribute('type', 'text');
  login.setAttribute('name', 'login');
  login.setAttribute('placeholder', 'Login');

  password = document.createElement('input');
  password.setAttribute('type', 'password');
  password.setAttribute('name', 'password');
  password.setAttribute('placeholder', 'Mot de passe');

  register = document.createElement('a');
  register.setAttribute('id', 'register');
  register.setAttribute('href', 'register.php');
  register.textContent = "S'inscrire";

  loginBtn = document.createElement('button');
  loginBtn.textContent = 'Connexion';
  loginBtn.setAttribute('type', 'submit');

  fieldset.appendChild(login);
  fieldset.appendChild(password);
  fieldset.appendChild(register);
  form.appendChild(loginBtn)
  header.appendChild(form);

  form.addEventListener("submit", sendLogForm);
}

function removeAllFavoris(){
  liList = document.querySelectorAll('#liste_communes li');
  for (let li of liList){
    li.children[0].className = 'fa fa-star';
    li.children[0].style.color = 'black';
  }
}
function updateFavoris(){

removeAllFavoris();
getFavoris();
}
