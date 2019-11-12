<?php ob_start()?>

<h2>Jedilnik</h2>

<?php
$malica = new Malica();
$malice = $malica->vseMalice();
echo "<div class='row'>";
foreach ($malice as $m){
	echo "<div class='col-sm-6'>";
    echo "<div class='card'>";
      echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $malica->pretvoriDatum($m['datum']) . "</h5>";
        echo "<p class='card-text'>" . nl2br($m['vsebina']) . "</p>";
        echo "<a href='index.php?stran=admin&podstran=uredimalica&id=" . $m['id']. "' class='btn btn-primary'><i class='fas fa-edit'></i> Uredi</a>";
      echo "</div>";
    echo "</div>";
  echo "</div>";
}
echo "</div>";
?>

<?php
$podstran=ob_get_clean();

require "template/admin/admin.html.php";

?>
