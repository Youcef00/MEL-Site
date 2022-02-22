<?php

 ?>

 <!DOCTYPE html>
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
   <head>
     <meta charset="UTF-8" />
     <title>Créer un utilisateur</title>
     <link rel="stylesheet" type="text/css" href="styles/createUser.css" />
     <link rel="icon" href="images/favicon.ico">
     <script src="js/fetchUtils.js"></script>
     <script src="js/createUser.js"></script>
   </head>


   <body>


  <section id="main">
    <div class="signup__container">
      <div class="container__child signup__thumbnail">
        <div class="thumbnail__logo">
          <img src="images/logo-mel-01.png" alt="logo MEL">

        </div>
        <div class="thumbnail__content text-center">
          <h1 class="heading--primary">S'inscrire</h1>
          <h2 class="heading--secondary">C'est rapide et facile</h2>
        </div>

        <div class="signup__overlay"></div>
      </div>
      <div class="container__child signup__form">
        <form id="authent" action="" method="post" class="register">
          <div class="form-group">
            <label for="nom">Nom de famille</label>
            <input class="form-control" type="text" name="nom" id="nom" required />
          </div>
          <div class="form-group">
            <label for="prenom">Prénom</label>
            <input class="form-control" type="text" name="prenom" id="prenom"  required />
          </div>
          <div class="form-group">
            <label for="login">Login</label>
            <input class="form-control" type="text" name="login" id="login" required />
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="********" required />
          </div>

          <div class="m-t-lg">
            <ul class="list-inline">
              <li>
                <input class="btn btn--form" type="submit" value="S'inscrire" id="toggle" />
              </li>
            </ul>
          </div>
          <a href="index.php">Page d'acceuil</a>
        </form>
      </div>
    </div>

    <div id="popup1" class="overlay">
	<div class="popup">
		<h2>Notification</h2>
		<a class="close" href="#">&times;</a>
		<div id="content">
			
		</div>
    <a class="acceuil" href="index.php">Acceuil</a>
	</div>
</div>
  </section>
   </body>
 </html>
