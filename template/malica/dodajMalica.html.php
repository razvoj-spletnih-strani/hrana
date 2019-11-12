<?php ob_start()?>

<h2>Dodajanje malice</h2>

<?php
if (isset($_POST['vstavi'])){
	$malica = new Malica();
	$malica->dodajMalica($_POST['datum'], $_POST['vsebina']);
	echo "<div class='sporocilo'>" . $malica->get_sporocilo() . "</div>";
}
?>

<form method="post">
  <div class="form-group">
    <label for="datum">Datum</label>
    <input type="date" class="form-control" id="datum" name="datum" min="1000-01-01" max="3000-12-31">
  </div>
  <div class="form-group">
    <label for="vsebina">Vsebina</label>
    <textarea class="form-control" id="vsebina" name="vsebina"></textarea>
  </div>
  <button type="submit" name="vstavi" class="btn btn-primary">Vstavi</button>
</form>


<?php
$podstran=ob_get_clean();

require "template/admin/admin.html.php";

?>
