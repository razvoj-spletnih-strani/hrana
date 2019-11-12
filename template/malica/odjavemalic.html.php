<?php ob_start()?>

<h2>Odjave malic</h2>
<?php
$user = new Uporabnik();
$vsiUporabniki = $user->vsiUporabniki();
$malica = new Malica();


echo "<div class='row'>";
foreach ($vsiUporabniki as $uporabnik){
  echo "<div class='col-sm-4'>";
    echo "<div class='card'>";
      echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $uporabnik['priimek'] . " " . $uporabnik['ime']. "</h5>";
        echo "<p class='card-text'><small>(" . $uporabnik['eposta'] . "</small>)</p>";
        $odjave = $malica->odjaveMalic($uporabnik['id']);
        echo "<p><small>";
        foreach ($odjave as $m){
          echo $malica->pretvoriDatum($m['datum']) . "</br>";
        }
        echo "</small></p>";
      echo "</div>";
    echo "</div>";
  echo "</div>";
}
echo "</div>";


$podstran=ob_get_clean();

require "template/admin/admin.html.php";

?>