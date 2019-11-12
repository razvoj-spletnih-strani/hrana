<?php
//front controller
session_start();

spl_autoload_register(function ($class_name) {
    include 'kontroler/' . $class_name . '.php';
});
$user = new Uporabnik();
$user->samodejnaPrijava();
$malica = new Malica();

if (isset($_GET['stran'])){
  if ($_GET['stran'] == "prijava" && !isset($_SESSION['eposta'])){
    include "template/uporabnik/prijava.html.php";
  } else if($_GET['stran'] == "registracija" && !isset($_SESSION['eposta'])){
  	include "template/uporabnik/registracija.html.php";
  } else if($_GET['stran'] == "pozabljenogeslo" && !isset($_SESSION['eposta'])){
  	include "template/uporabnik/pozabljenogeslo.html.php";
  } else if($_GET['stran'] == "ponastavitevgesla" && !isset($_SESSION['sposta'])){
  	if (isset($_GET['k'])){
  		include "template/uporabnik/ponastavitevgesla.html.php";
  	} else {
  		include "template/error.html.php";
  	}
  } else if($_GET['stran'] == "odjava" && isset($_SESSION['eposta'])){
  	$user = new Uporabnik();
  	$user->Odjava();
  	header('Location: /');
  } else if ($_GET['stran'] == "jedilnik"){
  	if (isset($_GET['podstran'])){
  		if ($_GET['podstran']=='odjavaprijava' && isset($_GET['id'])){
  			$malica->spremeniStatus($_GET['id']);
  		} else {
  			include "template/malica/jedilnik.html.php";
  		}
  	} else {
  		include "template/malica/jedilnik.html.php";
  	}
  	
  } else if($_SESSION['nivo'] == "administrator"){
  	if ($_GET['stran']=="admin"){
  		if (isset($_GET['podstran'])){
  			if ($_GET['podstran'] == "jedilnik"){
				include "template/malica/jedilnikAdmin.html.php";
  			} else if ($_GET['podstran'] == "dodajMalica"){
  				include "template/malica/dodajMalica.html.php";
  			} else if (($_GET['podstran'] == "uredimalica") && isset($_GET['id'])){
  				include "template/malica/urediMalica.html.php";
  			} else if ($_GET['podstran'] == "vsiuporabniki"){
  				include "template/uporabnik/vsiUporabniki.html.php";
  			} else if ($_GET['podstran'] == 'odjavemalic'){ 
  				include "template/malica/odjavemalic.html.php";
  			} else if ($_GET['podstran'] == "spremeniaktiviran" && isset($_GET['id'])){
  				$user->spremeniAktiviran($_GET['id']);
  			}
  		} else {
  			include "template/admin/admin.html.php";
  		}
  	} else {

  	}

  } else {
    include "template/error.html.php";
  }
} else {
  include "template/index.html.php";
}

 ?>