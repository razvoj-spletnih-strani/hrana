<?php ob_start()?>

 

<?php
$malica = new Malica();
$malice = $malica->vseMalice();

echo "<div class='container'>";
echo "<h2>Jedilnik</h2>";
echo "<div class='row'>";
foreach ($malice as $m){
	echo "<div class='col-sm-4'>";
    echo "<div class='card'>";
      echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $malica->pretvoriDatum($m['datum']) . "</h5>";
        echo "<p class='card-text'>" . nl2br($m['vsebina']) . "</p>";
        if (isset($_SESSION['id'])){
          if ($malica->preveriOdjavo($m['id'])){
            echo "<a href='index.php?stran=jedilnik&podstran=odjavaprijava&id=" . $m['id']. "'><span class='badge badge-danger'>odjavljen(a)</span></a>";
          } else {
            echo "<a href='index.php?stran=jedilnik&podstran=odjavaprijava&id=" . $m['id']. "'><span class='badge badge-success'>prijavljen(a)</span></a>";
          }
        }
      echo "</div>";
    echo "</div>";
  echo "</div>";
}
echo "</div>";
echo "</div>"
?>

<?php
$vsebina=ob_get_clean();

require "template/layout.html.php";

?>