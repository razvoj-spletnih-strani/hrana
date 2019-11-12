<?php ob_start()?>

<div class="jumbotron">
  <h1 class="display-4">Šolska prehrana</h1>
  <p class="lead">Aplikacija Hrana omogoča enostavno prijavo in odjavo na šolsko prehrano.</p>
  <hr class="my-4">
  <p>Uporabniško ime in geslo za prijavo dobite pri skrbniku šolske prehrane na vaši šoli.</p>
  <a class="btn btn-primary btn-lg" href="index.php?stran=prijava" role="button">Prijava</a>
</div>


<?php
$vsebina=ob_get_clean();

require "template/layout.html.php";

?>
