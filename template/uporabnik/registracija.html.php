<?php ob_start()?>

<div class="container">
	<div class="row">
	    <div class="col-sm">
	    	<h1><i class="fas fa-user-plus"></i> Registracija</h1>
	    	<?php
				if (isset($_POST['registracija'])){
					$user = new Uporabnik();
					$user->Registracija($_POST['eposta'], $_POST['geslo1'], $_POST['geslo2'], $_POST['ime'], $_POST['priimek']);
					echo "<div class='sporocilo'>" . $user->get_sporocilo() . "</div>";
				}
	    	?>
	      <form method="post">
	      	<div class="form-group">
			    <label for="ime">Ime</label>
			    <input type="text" class="form-control" id="ime" name="ime">
			  </div>
			  <div class="form-group">
			    <label for="priimek">Priimek</label>
			    <input type="text" class="form-control" id="priimek" name="priimek">
			  </div>
			  <div class="form-group">
			    <label for="email">Elektronski naslov</label>
			    <input type="email" class="form-control" id="email" name="eposta">
			  </div>
			  <div class="form-group">
			    <label for="password1">Geslo</label>
			    <input type="password" class="form-control" id="password1" name="geslo1">
			  </div>
			  <div class="form-group">
			    <label for="password2">Ponovite geslo</label>
			    <input type="password" class="form-control" id="password2" name="geslo2">
			  </div>
			  <button type="submit" class="btn btn-primary" name="registracija">Registracija</button>
			</form>
	    </div>
	    <div class="col-sm">
	      <p>Po registraciji mora vaš račun potrditi skrbnik šolske prehrane.</p>
	      <p>Če ste že registrirani se lahko prijavite <a href="index.php?stran=prijava">tukaj</a>.</p>
	    </div>
  	</div>
</div>
<?php

$vsebina=ob_get_clean();

require "template/layout.html.php";

?>
