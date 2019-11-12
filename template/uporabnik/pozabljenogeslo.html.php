<?php ob_start()?>

<div class="container">
	<div class="row">
	    <div class="col-sm">
	    	<h1><i class="fas fa-unlock-alt"></i> Pozabljeno geslo</h1>
	    	<?php
				if (isset($_POST['geslo'])){
					$user = new Uporabnik();
					$user->PozabljenoGeslo($_POST['eposta']);
					echo "<div class='sporocilo'>" . $user->get_sporocilo() . "</div>";
				}
	    	?>
	      <form method="post">
			  <div class="form-group">
			    <label for="eposta">Vaša elektronska pošta</label>
			    <input type="email" class="form-control" id="eposta" name="eposta">
			  </div>
			  
			  <button type="submit" class="btn btn-primary" name="geslo">Pošlji geslo</button>
			</form>
	    </div>
	    <div class="col-sm">
	      <p>Na vpisan elektronski naslov vam bomo poslali podatke za ponastavitev gesla.</p>
	    </div>
  	</div>
</div>



<?php
$vsebina=ob_get_clean();

require "template/layout.html.php";

?>
