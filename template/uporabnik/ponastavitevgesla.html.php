<?php ob_start()?>

<div class="container">
	<div class="row">
	    <div class="col-sm">
	    	<h1><i class="fas fa-unlock-alt"></i> Ponastavitev gesla</h1>
	    	<?php
	    		$user = new Uporabnik();
	    		if (!$user->preveriPonastavitevGesla($_GET['k'])){
	    			echo "<div class='sporocilo'>Napačna povezava. Znova preverite elektronsko pošto ali zahtevajte novo geslo.</div>";
	    		} else {
	    			if (isset($_POST['geslo'])){
						$user->PonastavitevGesla($_POST['geslo1'], $_POST['geslo2'], $_GET['k']);
						echo "<div class='sporocilo'>" . $user->get_sporocilo() . "</div>";
					}

					?>
					<form method="post">
					  <div class="form-group">
					    <label for="password1">Novo geslo</label>
					    <input type="password" class="form-control" id="password1" name="geslo1">
					  </div>
					  <div class="form-group">
					    <label for="password2">Ponovite novo geslo</label>
					    <input type="password" class="form-control" id="password2" name="geslo2">
					  </div>
					  <button type="submit" class="btn btn-primary" name="geslo">Ponastavi geslo</button>
					</form>
					<?php
	    		}
				
	    	?>
	      
	    </div>
	    <div class="col-sm">
	      <p>Ponastavitev gesla.</p>
	    </div>
  	</div>
</div>



<?php
$vsebina=ob_get_clean();

require "template/layout.html.php";

?>
