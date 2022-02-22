window.addEventListener('load',initForm);

function initForm(){
  document.forms.authent.addEventListener("submit", sendForm);
}

function sendForm(ev){
  ev.preventDefault();
  let args = new FormData(this);

  let url = 'services/createUser.php' ;

  fetchFromJson(url, {method: "post", body: args})
  .then(makeMessage);

}

function makeMessage(tab){
  message = document.getElementById("content");
  message.innerHTML = '';
  let msg = document.createElement('p');
  if (tab.status == 'error') {
    msg.textContent = "Erreur! Le login existe dèja";
    document.getElementsByClassName('acceuil')[0].style.display = "none";
  }
  else if (tab.status == 'ok') {
    msg.textContent = "Compte crée avec succès";
    document.getElementById("authent").reset();
    document.getElementsByClassName('acceuil')[0].style.display = "block";
  }
  else {
    msg.textContent = 'Bug !';
  }
  message.appendChild(msg);
  window.location.href = window.location.href.replace('#', '')+ '#popup1';
}
