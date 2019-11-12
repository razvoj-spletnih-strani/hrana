<?php
include_once "Baza.php";

class Uporabnik{
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

	//https://stackoverflow.com/questions/1846202/php-how-to-generate-a-random-unique-alphanumeric-string
	public function nakljucnaKoda($length){
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[random_int(0, $max-1)];
	    }

	    return $token;
	}

	public function Registracija($eposta, $geslo1, $geslo2, $ime, $priimek){
		$link=open_database_connection();

		$ime = mysqli_real_escape_string($link, $ime);
		$priimek = mysqli_real_escape_string($link, $priimek);
		$eposta = mysqli_real_escape_string($link, $eposta);
		$geslo1 = mysqli_real_escape_string($link, $geslo1);
		$geslo2 = mysqli_real_escape_string($link, $geslo2);

	    if (empty($ime) || empty($priimek) || empty($eposta) || empty($geslo1) || empty($geslo2)){
	    	$this->sporocilo = "Niste vnesli vseh polj.";
	    } else {
	    	if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
				$this->sporocilo = "Nepravilna e pošta.";
			} else {
				if ($geslo1 != $geslo2){
		    		$this->sporocilo = "Gesli se ne ujemata.";
		    	} else {
		    		if ($this->PreveriUporabnika($eposta)){
		    			$this->sporocilo = "Uporabnik s to elektronsko pošto je že registriran.";
		    		} else {
		    			$kodiranValidator = password_hash($this->nakljucnaKoda(40), PASSWORD_DEFAULT);

		    			$kodiranoGeslo = password_hash($geslo1, PASSWORD_DEFAULT);
			    		$sql="INSERT INTO Uporabnik (ime, priimek, eposta, geslo, kodiranValidator) VALUES ('$ime', '$priimek','$eposta', '$kodiranoGeslo', '$kodiranValidator')";
			    		mysqli_query($link,$sql);

			    		//posodobimo tabelo, tako da vstavimo še selektor
						$zadnji_id = mysqli_insert_id($link);
						$selektor = $this->nakljucnaKoda(12) . $zadnji_id; //selektor je kombinacija nakljucne kode in id-ja - mora biti unikaten
						$sql = "UPDATE Uporabnik SET selektor='$selektor' WHERE id='$zadnji_id'";
						mysqli_query($link,$sql);

			    		$this->sporocilo = "Registracija je uspela.";
		    		}
		    	}	
			}
	    	
	    }
	    close_database_connection($link);
	}

	public function PreveriUporabnika($eposta){
		$link=open_database_connection();
		$sql="SELECT id FROM Uporabnik WHERE eposta='$eposta'";
		$rezultat = mysqli_query($link,$sql);
		$st_vrstic=mysqli_num_rows($rezultat);
		close_database_connection($link);

		if ($st_vrstic == 1){
			return true;
		} else {
			return false;
		}	
	}

	public function Prijava($eposta, $geslo, $pomni){
		$link=open_database_connection();

		$eposta = mysqli_real_escape_string($link, $eposta);
		$geslo = mysqli_real_escape_string($link, $geslo);
		
		if (empty($eposta) || empty($geslo)){
	    	$this->sporocilo = "Niste vnesli vseh polj.";
	    } else {
			$sql="SELECT Uporabnik.id, Uporabnik.geslo, Uporabnik.selektor, Nivo.naziv, Uporabnik.aktiviran FROM Uporabnik JOIN Nivo ON Uporabnik.id_nivo = Nivo.id WHERE Uporabnik.eposta='$eposta'";

			$rezultat = mysqli_query($link,$sql);
			$st_vrstic=mysqli_num_rows($rezultat);

			if ($st_vrstic != 1){
				$this->sporocilo = "Uporabnik ne obstaja.";
			} else {
				$vrstica=mysqli_fetch_row($rezultat);

				if (!password_verify($geslo, $vrstica[1])) {
				    $this->sporocilo = "Napačno geslo.";
				} else {
					if ($vrstica[4] == 0){
						$this->sporocilo = "Vaš račun ni aktiviran. Kontaktirajte skrbnika malice.";
					} else {
						$_SESSION['eposta'] = $eposta;
					    $_SESSION['id'] = $vrstica[0];
						$_SESSION['nivo'] = $vrstica[3];
						if ($pomni){
							//ustvarimo nov validator
							$validator = $this->nakljucnaKoda(40);
							$kodiranValidator = password_hash($validator, PASSWORD_DEFAULT);

							//ustvarimo kodo, ki gre v piškotek
							$vrednostpiskotka = $vrstica[2] . $validator;
							$cas = 3600;
							$potece = date("Y-m-d H:i:s", strtotime("+$cas sec"));
							$id_uporabnika = $vrstica[0];
							setcookie("HranaPrijava", $vrednostpiskotka, time()+$cas);
							$sql = "UPDATE Uporabnik SET kodiranValidator='$kodiranValidator', potece='$potece' WHERE id='$id_uporabnika'";
							mysqli_query($link,$sql);

						}
						$this->sporocilo = "Prijava je uspela.";
						header( "refresh:5;url=/" );
					}
				    
				}
			}
	    }
		close_database_connection($link);
	}

	public function SamodejnaPrijava(){
		if (isset($_COOKIE['HranaPrijava']) && !isset($_SESSION['eposta'])){

			//razbijemo vrednost piškotka
			$p_validator = substr($_COOKIE['HranaPrijava'], -40);
			$p_selektor_polje = explode($p_validator, $_COOKIE['HranaPrijava']);
			$p_selektor = $p_selektor_polje[0];
			$link=open_database_connection();

			$sql="SELECT Uporabnik.id, Uporabnik.eposta, Uporabnik.kodiranValidator, Nivo.naziv FROM Uporabnik JOIN Nivo ON Uporabnik.id_nivo = Nivo.id WHERE Uporabnik.selektor='$p_selektor' AND Uporabnik.potece>CURRENT_TIMESTAMP()";

			$rezultat = mysqli_query($link,$sql);
			$st_vrstic=mysqli_num_rows($rezultat);

			if ($st_vrstic == 1){
				$vrstica=mysqli_fetch_row($rezultat);
				if (password_verify($p_validator, $vrstica[2])){
					$_SESSION['eposta'] = $vrstica[1];
				    $_SESSION['id'] = $$vrstica[0];
					$_SESSION['nivo'] = $vrstica[3];
				} 
			}

			close_database_connection($link);
		}
	}

	public function Odjava(){
		
		//ustvarimo nov validator
		$validator = $this->nakljucnaKoda(40);
		$kodiranValidator = password_hash($validator, PASSWORD_DEFAULT);
		$eposta = $_SESSION['eposta'];
		$link=open_database_connection();
		$sql = "UPDATE Uporabnik SET kodiranValidator='$kodiranValidator', potece=CURRENT_TIMESTAMP() WHERE eposta='$eposta'";
		mysqli_query($link,$sql);
		close_database_connection($link);
		setcookie("HranaPrijava", "", time()-1);
		session_destroy();

	}

	public function PozabljenoGeslo($eposta){
		$link=open_database_connection();

		$eposta = mysqli_real_escape_string($link, $eposta);
		if (empty($eposta)){
			$this->sporocilo = "Vpišite elektronski naslov.";
		} else {
			$sql = "SELECT selektor FROM Uporabnik WHERE eposta='$eposta'";
			$rezultat = mysqli_query($link,$sql);
			$st_vrstic=mysqli_num_rows($rezultat);

			if ($st_vrstic != 1){
				$this->sporocilo = "Napačna elektronska pošta";
			} else {
				$vrstica = mysqli_fetch_assoc($rezultat);
				$zeton = $this->nakljucnaKoda(40);
				$zeton = $vrstica['selektor'] . $zeton;
				$sql = "UPDATE Uporabnik SET ponastavitevGesla='$zeton' WHERE eposta='$eposta'";
				$rezultat = mysqli_query($link,$sql);

				$to      = $eposta;
				$subject = 'Hrana - ponastavitev gesla';
				$message = '<p>Pozdravljeni.</p><p>Zahtevali ste ponastavitev gesla na spletni strani Hrana. Za dokončanje procesa kliknite na povezavo http://iss.localhost/index.php?stran=ponastavitevgesla&k=' . $zeton . '</p><p>Ekipa Hrana</p>';
				
				$headers = "From: hrana@hrana.si\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

				mail($to, $subject, $message, $headers);

				$this->sporocilo = "Na vpisan elektronski naslov smo vam poslali navodila za ponastavitev gesla.";
			}
		}
		close_database_connection($link);
	}

	public function preveriPonastavitevGesla($k){
		$link=open_database_connection();
		$k = mysqli_real_escape_string($link, $k);

		$sql = "SELECT eposta FROM Uporabnik WHERE ponastavitevGesla = '$k'";
		$rezultat = mysqli_query($link,$sql);
		$st_vrstic=mysqli_num_rows($rezultat);

		close_database_connection($link);

		if ($st_vrstic == 1){
			return true;
		} else {
			return false;
		}

		
	}

	public function PonastavitevGesla($geslo1, $geslo2, $k){
		$link=open_database_connection();

		$geslo1 = mysqli_real_escape_string($link, $geslo1);
		$geslo2 = mysqli_real_escape_string($link, $geslo2);
		$k = mysqli_real_escape_string($link, $k);

		$sql="SELECT id, selektor FROM Uporabnik WHERE ponastavitevGesla='$k'";
		$rezultat = mysqli_query($link,$sql);
		$st_vrstic=mysqli_num_rows($rezultat);

		if ($st_vrstic != 1){
			$this->sporocilo = "Nepravilen žeton!";
		} else {
			if (empty($geslo1) || empty($geslo2)){
				$this->sporocilo = "Nepravilno geslo";
			} else {
				if ($geslo1 != $geslo2){
					$this->sporocilo = "Gesli se ne ujemata.";
				} else {
					$kodiranoGeslo = password_hash($geslo1, PASSWORD_DEFAULT);
					$vrstica = mysqli_fetch_assoc($rezultat);
					$zeton = $this->nakljucnaKoda(40);
					$zeton = $vrstica['selektor'] . $zeton;
					$id = $vrstica['id'];
					//ustvarimo nov zeton


					$sql="UPDATE Uporabnik SET geslo='$kodiranoGeslo', ponastavitevGesla='$zeton' WHERE id='$id'";
					$rezultat = mysqli_query($link,$sql);
					$this->sporocilo = "Geslo je bilo uspešno spremenjeno.";
					header( "refresh:5;url=/" );
				}
			}
		}

		close_database_connection($link);
	}

	public function vsiUporabniki(){
		$link=open_database_connection();

		$sql="SELECT Uporabnik.id, Uporabnik.ime, Uporabnik.priimek, Uporabnik.eposta, Uporabnik.aktiviran, Nivo.naziv FROM Uporabnik JOIN Nivo ON Uporabnik.id_nivo = Nivo.id ORDER BY Uporabnik.priimek ASC";

		$rezultat = mysqli_query($link,$sql);
		$vse = mysqli_fetch_all($rezultat,MYSQLI_ASSOC);

		close_database_connection($link);

		return $vse;

	}

	public function spremeniAktiviran($id){
		$link=open_database_connection();
		$id = mysqli_real_escape_string($link, $id);

		$sql="SELECT aktiviran FROM Uporabnik WHERE id='$id'";
		$rezultat = mysqli_query($link,$sql);
		$st_vrstic=mysqli_num_rows($rezultat);

		if ($st_vrstic == 1){
			$vrstica = mysqli_fetch_assoc($rezultat);
			if ($vrstica['aktiviran'] == 1){
				$aktiviran = 0;
			} else {
				$aktiviran = 1;
			}
			$sql = "UPDATE Uporabnik SET aktiviran='$aktiviran' WHERE id='$id'";
			mysqli_query($link,$sql);
			header("Location: index.php?stran=admin&podstran=vsiuporabniki");
		}

		close_database_connection($link);	
	}
}
?>