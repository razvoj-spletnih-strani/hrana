<?php ob_start()?>

<h2>Urejanje malice</h2>

<?php
$malica = new Malica();
if (!$malica->preveriMalico($_GET['id'])){
  echo "<div class='sporocilo'>Malica ne obstaja.</div>";
} else {
  $m = $malica->dobiMalico($_GET['id']);
  if (isset($_POST['uredi'])){
    $malica->urediMalico($_POST['datum'], $_POST['vsebina'], $_GET['id']);
    echo "<div class='sporocilo'>" . $malica->get_sporocilo() . "</div>";
  }

  ?>
  <form method="post">
    <div class="form-group">
      <label for="datum">Datum</label>
      <input type="date" class="form-control" id="datum" name="datum" min="1000-01-01" max="3000-12-31" value="<?php echo $m['datum']; ?>">
    </div>
    <div class="form-group">
      <label for="vsebina">Vsebina</label>
      <textarea class="form-control" id="vsebina" name="vsebina"><?php echo $m['vsebina']; ?></textarea>
    </div>
    <button type="submit" name="uredi" class="btn btn-primary">Uredi</button>
  </form>
  <?php
}
?>




<?php
$podstran=ob_get_clean();

require "template/admin/admin.html.php";

?>
