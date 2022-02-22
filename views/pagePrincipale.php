<?php

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Communes de la MEL</title>
    <link rel="stylesheet" href="styles/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="styles/index.css" />
    <script src="js/fetchUtils.js"></script>
    <script src="js/communes.js"></script>
    <script src="js/carte.js"></script>
    <script src="js/login.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <link rel="icon" href="images/favicon.ico">
  </head>
<body>
<header>
  <div class="logo">
    <img src="images/logo-mel-011.png" alt="Logo MEL" />
  </div>
<h1>
Communes de la MEL
</h1>
<div id="user">

</div>
</header>


<section id="main">
  <div id="choix">
    <form id="form_communes" action="">

      <fieldset>
        <legend>Choix des communes</legend>
        <label>Territoire : </label>
          <select name="territoire">
              <option value=""
                      data-min_lat="50.499" data-min_lon="2.789"
                      data-max_lat="50.794" data-max_lon="3.272">
                Tous
              </option>
              <!-- les autres options seront crées en JS -->
          </select>

          <label>Surface min : </label>
          <input type="int" name="surface_min" value="" placeholder="Surface minimum">

          <label>Population min : </label>
          <input type="float" name="pop_min" value="" placeholder="Population minimum">

          <label>Recensement : </label>
          <select name="recensement">
            <option value="">Tous</option>
          </select>

          <label>Rechercher :</label>
          <input type="text" name="recherche" value="" placeholder="Rechercher...">

        </fieldset>

      <button type="submit">Afficher la liste</button>
    </form>
  </div>
  <div id='carte'></div>
  <div class="navigation">
    <nav>
      <ul id="liste_communes">
      </ul>

    </nav>

  </div>


  <div id="details"></div>
</section>

<footer>
  <div id="popup1" class="overlay">
<div class="popup">
  <h2>Notification</h2>
  <a class="close" href="#">&times;</a>
  <div id="content">

  </div>
</div>
</div>
</footer>
</body>
</html>
