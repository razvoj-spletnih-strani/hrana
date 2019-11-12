<?php ob_start()?>

<div class="container">
	<div class="row">
	    <div class="col-sm">
	    	<h1><i class="fas fa-sign-in-alt"></i> Prijava</h1>
	    	<?php
				if (isset($_POST['prijava'])){
					if (isset($_POST['pomni'])){
						$pomni = true;
					} else {
						$pomni = false;
					}
					$user = new Uporabnik();
					$user->Prijava($_POST['eposta'], $_POST['geslo'], $pomni);
					echo "<div class='sporocilo'>" . $user->get_sporocilo() . "</div>";
				}
	    	?>
	      <form method="post">
			  <div class="form-group">
			    <label for="eposta">Elektronska pošta</label>
			    <input type="email" class="form-control" id="eposta" name="eposta">
			  </div>
			  <div class="form-group">
			    <label for="password">Geslo</label>
			    <input type="password" class="form-control" id="password" name="geslo">
			  </div>
			  <div class="form-group form-check">
			    <input type="checkbox" class="form-check-input" id="pomni" name="pomni">
			    <label class="form-check-label" for="pomni">Ostani prijavljen</label>
			  </div>
			  <button type="submit" class="btn btn-primary" name="prijava">Prijava</button>
			</form>
	    </div>
	    <div class="col-sm">
	      <p>Če ste pozabili geslo ga lahko pridobite <a href="index.php?stran=pozabljenogeslo">tukaj</a>.</p>
	    </div>
  	</div>
</div>



<?php
$vsebina=ob_get_clean();

require "template/layout.html.php";

?>
