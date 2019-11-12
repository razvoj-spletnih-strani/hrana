<?php ob_start()?>

<h2>Uporabniki</h2>

<?php
$user = new Uporabnik();
$vsiUporabniki = $user->vsiUporabniki();

?>
<div class='table-responsive'>
<table class='table table-striped table-sm'>
	<thead>
    <tr>
      <th scope="col">Ime</th>
      <th scope="col">Priimek</th>
      <th scope="col">E pošta</th>
      <th scope="col">Aktiviran</th>
      <th scope="col">Nivo</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach($vsiUporabniki as $uporabnik){
	echo "<tr>";
      echo "<td>" . $uporabnik['ime'] . "</td>";
      echo "<td>" . $uporabnik['priimek'] . "</td>";
      echo "<td>" . $uporabnik['eposta'] . "</td>";
      echo "<td>";
      if ($uporabnik['aktiviran'] == 1){
      	echo "<a href='index.php?stran=admin&podstran=spremeniaktiviran&id=" . $uporabnik['id']. "'><span class='badge badge-success'>da</span></a>";
      } else {
      	echo "<a href='index.php?stran=admin&podstran=spremeniaktiviran&id=" . $uporabnik['id']. "'><span class='badge badge-danger'>ne</span></a>";
      }
      echo "</td>";
      echo "<td>" . $uporabnik['naziv'] . "</td>";
    echo "</tr>";
}
?>
   </tbody>
  </table>
</div>

<?php
$podstran=ob_get_clean();

require "template/admin/admin.html.php";

?>