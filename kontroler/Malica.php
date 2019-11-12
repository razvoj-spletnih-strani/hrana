<?php
include_once "Baza.php";

class Malica{
	private $sporocilo;

	function __construct() {
        $this->sporocilo = "";
    }

	public function set_sporocilo($sporocilo){
		$this->sporocilo = $sporocilo;
	}

	public function get_sporocilo(){
		return $this->sporocilo;
	}

	public function pretvoriDatum($datum){
		$razbit_datum = explode("-", $datum);
		return ($razbit_datum[2] . ". " . $razbit_datum[1] . ". " . $razbit_datum[0]);
	}


	public function dodajMalica($datum, $vsebina){
		$link=open_database_connection();

		$datum = mysqli_real_escape_string($link, $datum);
		$vsebina = mysqli_real_escape_string($link, $vsebina);

	    if (empty($datum) || empty($vsebina)){
	    	$this->sporocilo = "Niste vnesli vseh polj.";
	    } else {
	    	$razbit_datum = explode("-", $datum);
	    	if (!checkdate($razbit_datum[1], $razbit_datum[2], $razbit_datum[0])){
	    		$this->sporocilo = "Nepravilen format datuma.";
	    	} else {
	    		$sql = "SELECT id FROM Malica WHERE datum = '$datum'";
	    		$rezultat = mysqli_query($link,$sql);
	    		$st_vrstic=mysqli_num_rows($rezultat);

	    		if ($st_vrstic == 1){
	    			$this->sporocilo = "Malica za ta datum je že vnesena.";
	    		} else {
	    			$id = $_SESSION['id'];
		    		$sql="INSERT INTO Malica (datum, vsebina, id_uporabnik) VALUES ('$datum', '$vsebina', '$id')";
		    		mysqli_query($link,$sql);
		    		$prijazen_datum = $this->pretvoriDatum();
					$this->sporocilo = "Malica za datum " . $prijazen_datum . " je vnesena.";
	    		}
	    	}
	    }

	    close_database_connection($link);
	}

	public function vseMalice(){
		$link=open_database_connection();

		$sql="SELECT id, vsebina, datum FROM Malica WHERE datum>=CURRENT_TIMESTAMP() ORDER BY datum ASC";
		$rezultat = mysqli_query($link,$sql);
		$vse = mysqli_fetch_all($rezultat,MYSQLI_ASSOC);

		close_database_connection($link);

		return $vse;
	}

	public function preveriMalico($id){
		$link=open_database_connection();
		
		$sql = "SELECT datum FROM Malica WHERE id = '$id'";
	    $rezultat = mysqli_query($link,$sql);
	   	$st_vrstic=mysqli_num_rows($rezultat);
		
		close_database_connection($link);

		if ($st_vrstic == 1){
			return true;
		} else {
			return false;
		}
	}

	public function dobiMalico($id){
		$link=open_database_connection();
		
		$sql = "SELECT id, datum, vsebina FROM Malica WHERE id = '$id'";
	    $rezultat = mysqli_query($link,$sql);
	    $vrstica = mysqli_fetch_assoc($rezultat);

	    close_database_connection($link);
	    return $vrstica;
	}

	public function urediMalico($datum, $vsebina, $id){
		$link=open_database_connection();

		$datum = mysqli_real_escape_string($link, $datum);
		$vsebina = mysqli_real_escape_string($link, $vsebina);

		if (empty($datum) || empty($vsebina)){
	    	$this->sporocilo = "Niste vnesli vseh polj.";
	    } else {
	    	$razbit_datum = explode("-", $datum);
	    	if (!checkdate($razbit_datum[1], $razbit_datum[2], $razbit_datum[0])){
	    		$this->sporocilo = "Nepravilen format datuma.";
	    	} else {
	    		$sql = "SELECT id FROM Malica WHERE datum = '$datum'";
	    		$rezultat = mysqli_query($link,$sql);
	    		$st_vrstic=mysqli_num_rows($rezultat);

	    		if ($st_vrstic == 1){
	    			$this->sporocilo = "Malica za ta datum je že vnesena.";
	    		} else {
					$sql = "UPDATE Malica SET datum='$datum', vsebina='$vsebina' WHERE id='$id'";
		    		mysqli_query($link,$sql);
		    		$this->sporocilo = "Malica je bila uspešno urejena.";
		    		header( "refresh:5;url=/" );
	    		}
	    		
	    	}
	    }

		close_database_connection($link);
	}

	public function preveriOdjavo($id){
		$link=open_database_connection();

		$id_uporabnik = $_SESSION['id'];
		$sql = "SELECT id FROM Odjava WHERE id_uporabnik = '$id_uporabnik' AND id_malica='$id' AND status='0'";
		$rezultat = mysqli_query($link,$sql);
		$st_vrstic=mysqli_num_rows($rezultat);

		close_database_connection($link);

		if ($st_vrstic == 1){
			return true;
		} else {
			return false;
		}
	}

	public function spremeniStatus($id_malica){
		$link=open_database_connection();
		$id_malica = mysqli_real_escape_string($link, $id_malica);
		$id_uporabnik = $_SESSION['id'];

		$sql="SELECT status FROM Odjava WHERE id_malica='$id_malica' AND id_uporabnik='$id_uporabnik'";
		$rezultat = mysqli_query($link,$sql);
		$st_vrstic=mysqli_num_rows($rezultat);
		if ($st_vrstic == 1){
			$vrstica = mysqli_fetch_assoc($rezultat);
			if ($vrstica['status'] == 1){
				$status = 0;
			} else {
				$status = 1;
			}
			$sql = "UPDATE Odjava SET status='$status', datum_cas=CURRENT_TIMESTAMP() WHERE id_malica='$id_malica' AND id_uporabnik='$id_uporabnik'";
			mysqli_query($link,$sql);
			
		} else {
			$sql = "INSERT INTO Odjava (id_uporabnik, id_malica, status) VALUES ('$id_uporabnik', '$id_malica', 0)";
			mysqli_query($link,$sql);

		}

		header("Location: index.php?stran=jedilnik");
		close_database_connection($link);	
	}

	public function OdjaveMalic($id_uporabnik){
		$link=open_database_connection();
		//$sql="SELECT Uporabnik.id, Uporabnik.ime, Uporabnik.priimek, Uporabnik.eposta, Uporabnik.aktiviran, Nivo.naziv FROM Uporabnik JOIN Nivo ON Uporabnik.id_nivo = Nivo.id ORDER BY Uporabnik.priimek ASC";

		$sql="SELECT Malica.datum FROM Odjava JOIN Malica ON Odjava.id_malica = Malica.id WHERE Odjava.id_uporabnik='$id_uporabnik' ORDER BY Malica.datum DESC";
		$rezultat = mysqli_query($link,$sql);
		$vse = mysqli_fetch_all($rezultat,MYSQLI_ASSOC);

		close_database_connection($link);

		return $vse;
	}

}
?>