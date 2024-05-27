<?php
	class User{
		private $host="localhost";
		private $felhasznalonev="root";
		private $jelszo="";
		private $abNev="pizzahot";
		private $kapcsolat;
    
		//konstuktor
		public function __construct() {
		$this->kapcsolat = new mysqli($this->host, $this->felhasznalonev, $this->jelszo, $this->abNev);//létrehozzuk a kapcsolatot egy példányosításon keresztül a paraméterek beállításával
		if($this->kapcsolat->connect_error)
		{
			$szoveg="<p>Hiba: ".$this->kapcsolat->connect_error."</p>";
		}
		else{
			$szoveg="<p>Sikeres kapcsolódás.</p>";
		}
	
		//ékezetes betűk
		$this->kapcsolat->query("SET NAMES 'UTF8'");
		$this->kapcsolat->query("set character set UTF8");
		//echo $szoveg;//itt jelenítjük meg a kapcsolódás sikerét/stelenségét.
		}

		public function lekerdezes($sql){
			return $this->kapcsolat->query($sql);
		}
		
		/*** for registration process ***/
		public function reg_felhasznalo($nev, $email, $jelszo){
			$jelszo = md5($jelszo);
			$select1="SELECT * FROM felhasznalo WHERE nev='$nev' OR email='$email'";

			//checking if the username or email is available in db
			$check =  $this->lekerdezes($select1) ;
			$count_row = $check->num_rows;

			//if the username is not in db then insert to the table
			if ($count_row == 0){
				$insert1="INSERT INTO felhasznalo(felhAzon, jogAzon, nev, email, jelszo) VALUES (NULL, '2', '$nev', '$email', '$jelszo')";
				$result = $this->lekerdezes($insert1) or die(mysqli_connect_errno()."Data cannot inserted");
    			return $result;
			}
			else { 
				return false;}
		}

		/*** for login process ***/
		public function bejelentkezes($emailNev, $jelszo){

        	$titkosJelszo = md5($jelszo);
			$select2="SELECT felhAzon from felhasznalo WHERE (email = '$emailNev' or nev= '$emailNev') and jelszo = '$titkosJelszo'";
			//checking if the username is available in the table
        	$result = $this->lekerdezes($select2);
        	$count_row = $result->num_rows;

	        if ($count_row == 1) {
	            // this login var will use for the session thing
	            $_SESSION['login'] = true;
				$user_data = $result->fetch_array(MYSQLI_ASSOC);
				$felhAzon = $user_data['felhAzon'];
	            $_SESSION['felhAzon'] = $felhAzon;
				$update1="UPDATE felhasznalo SET bejelentkezett = 1 WHERE felhAzon = $felhAzon";
				$result = $this->lekerdezes($update1);
	            return true;
	        }
	        else{
			    return false;
			}
    	}

    	/*** for showing the username or fullname ***/
    	public function get_nev($felhAzon){
    		$select3="SELECT nev FROM felhasznalo WHERE felhAzon = $felhAzon";
	        $result = $this->lekerdezes($select3);
	        $user_data = $result->fetch_array(MYSQLI_ASSOC);
	        echo $user_data['nev'];
    	}
		
		public function isAdmin($felhAzon){
    		$select3="SELECT j.nev FROM jogosultsag as j
			INNER JOIN felhasznalo as f WHERE j.jogAzon = f.jogAzon and felhAzon = $felhAzon and j.nev = 'admin'";
	        $result = $this->lekerdezes($select3)->num_rows;
	        if ($result == 1){return true;}
			return false;
    	}

    	/*** be van-e jelentkezve ***/
	    public function get_session(){
	        return $_SESSION['login'];
	    }

	    public function kijelentkezes() {
			$felhAzon = $_SESSION['felhAzon'];
			$update2="UPDATE felhasznalo SET bejelentkezett = 0 WHERE felhAzon = $felhAzon";
			$result = $this->lekerdezes($update2);
	        $_SESSION['login'] = FALSE;
	        session_destroy();
	    }
		
		public function aktivok(){
			$sql = "SELECT nev FROM felhasznalo WHERE bejelentkezett = 1";
			return $this->lekerdezes($sql);
		}
		
		public function megjelenit_aktivok($matrix){
			echo "<ul>";
			while ($sor = $matrix->fetch_row()){
				echo "<li>$sor[0]</li>";
			}
			echo "</ul>";
		}

		public function beszur($tabla, $oszlop1, $oszlop2){
			$sql = "INSERT INTO $tabla (kategoriaAzon, ar, nev) VALUES ('NULL','$oszlop1','$oszlop2')";
			return $this->lekerdezes($sql);
		}

		public function megjelenit($tabla, $oszlop1, $oszlop2){
			//<option value=""></option>
			$sql = "SELECT $oszlop1, $oszlop2 FROM $tabla";
			$matrix = $this->lekerdezes($sql);
			while ($sor = $matrix->fetch_row()){
				echo "<option value='$sor[0]'>kategória: $sor[0], ár: $sor[1]</option>";
			}
		}

		public function megjelenitLista($tabla, $oszlop1, $oszlop2, $id){
			$sql = "SELECT $oszlop1, $oszlop2 FROM $tabla WHERE kategoriaAzon = $id";
			$matrix = $this->lekerdezes($sql);
			$sor = $matrix->fetch_array();
			if ($sor != null) {
				$nev = $sor[0];
				$ar = $sor[1];
				$lista = [
					'kategoriaAzon' => $id,
					'nev' => $nev,
					'ar' => $ar
				];
				return $lista;
			}
			else {
				echo null;
			}	
		}

		public function megjelenitMindLista($tabla) {
			$sql = "SELECT * FROM $tabla";
			$matrix = $this->lekerdezes($sql);
			$teljes = [];
			while ($sor = $matrix->fetch_row()) {
				$teljes[] = $sor; 
			}
			return $teljes;
		}


		public function modosit($tabla, $ar, $regi, $uj) {
			$sql = "UPDATE $tabla SET ar = '$ar', nev = '$uj' WHERE nev = '$regi'";
			return $this->lekerdezes($sql);
		}

		public function torles($tabla, $oszlop, $ertek){
			$sql = "DELETE FROM $tabla WHERE $oszlop = '$ertek'";
			return $this->lekerdezes($sql);
		}
	}
?>