<?php ob_start()?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1><i class="fas fa-cogs"></i> Administracija</h1>
		</div>
	    <div class="col-sm-3">
	    	<div class="list-group">
	    		<a href="index.php?stran=admin&podstran=dodajMalica" class="list-group-item list-group-item-action">Dodajanje malice</a>
			  <a href="index.php?stran=admin&podstran=jedilnik" class="list-group-item list-group-item-action">Jedilnik</a>
			  <a href="index.php?stran=admin&podstran=vsiuporabniki" class="list-group-item list-group-item-action">Uporabniki</a>
			  <a href="index.php?stran=admin&podstran=odjavemalic" class="list-group-item list-group-item-action">Odjave malic</a>
			</div>
	    </div>
	    <div class="col-sm-9">
	      <?php
	      	if (isset($podstran)){
	      		echo $podstran;
	      	} else {
	      		echo "<p>Izberite opcijo v meniju.</p>";
	      	}
	      ?>
	    </div>
  	</div>
</div>



<?php
$vsebina=ob_get_clean();

require "template/layout.html.php";

?>
