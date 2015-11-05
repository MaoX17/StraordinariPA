<?php

class Utente {
	
	protected $idUtente;
	protected $objRuolo;
	protected $username;
	protected $password;
	protected $cognome_nome;
	protected $email;
	protected $tel;

	/**
	 * @param mixed $objRuolo
	 */
	public function setObjRuolo($objRuolo)
	{
		$this->objRuolo = $objRuolo;
	}

	/**
	 * @return mixed
	 */
	public function getObjRuolo()
	{
		return $this->objRuolo;
	}

	/**
	 * @param mixed $tel
	 */
	public function setTel($tel)
	{
		$this->tel = $tel;
	}

	/**
	 * @return mixed
	 */
	public function getTel()
	{
		return $this->tel;
	}



	/**
	 * @param mixed $cognome_nome
	 */
	public function setCognomeNome($cognome_nome)
	{
		$this->cognome_nome = $cognome_nome;
	}

	/**
	 * @return mixed
	 */
	public function getCognomeNome()
	{
		return $this->cognome_nome;
	}


	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $idUtente
	 */
	public function setIdUtente($idUtente)
	{
		$this->idUtente = $idUtente;
	}

	/**
	 * @return mixed
	 */
	public function getIdUtente()
	{
		return $this->idUtente;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}



	public function controllaEsistenza() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT
					utenti.id_utente
					FROM
					utenti
					WHERE
					utenti.username = '".$this->getUsername()."';";



		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			$this->setIdUtente($row['id_utente']);
			$result = true;
		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
	return $result;

	}

	public function creaNelDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$result = "";

		//ESEGUO INSERIMENTO -- INSERT
		$sql =
			"INSERT INTO utenti SET
			id_ruolo='".$this->getObjRuolo()->getIdRuolo()."',
			username='".$this->getUsername()."',
           	password='".$this->getPassword()."',
           	cognome_nome='".mysql_real_escape_string($this->getCognomeNome())."',
           	tel='".$this->getTel()."',
           	email='".$this->getEmail()."';";


		//echo $sql;
/*
		error_log("------------- CREA NEL DB ---------------- ");
		$tmp = str_replace("\t", " ", $sql);
		$tmp = str_replace("\r\n", " ", $tmp);
		error_log($tmp);
		error_log("----------------------------------------------- ");
*/
		$rs = $db->query($sql);
		if( MDB2::isError($rs) ) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
			$result = FALSE;
			throw new Exception('Errore durante inserimento nel DB');
			//die($rs->getMessage());
		}
		else {
			$result = TRUE;
		}

		//setto il corretto id_anagrafica all'oggetto in base al risultato dell'insert
		$sql = "SELECT LAST_INSERT_ID() FROM utenti";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ORDERED);
		$this->setIdUtente($row[0]);

		return $result;
	}



	public function aggiornaNelDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$result = "";

		//ESEGUO UPDATE
		$sql =
			"UPDATE utenti SET
			id_utente='".$this->getIdUtente()."',
			id_ruolo='".$this->getObjRuolo()->getIdRuolo()."',
			username='".$this->getUsername()."',
           	password='".$this->getPassword()."',
           	cognome_nome='".mysql_real_escape_string($this->getCognomeNome())."',
           	tel='".$this->getTel()."',
           	email='".$this->getEmail()."'
           	WHERE
            id_utente=".$this->getIdUtente().";";

/*		error_log("------------- AGGIORNA NEL DB ---------------- ");
		$tmp = str_replace("\t", " ", $sql);
		$tmp = str_replace("\r\n", " ", $tmp);
		error_log($tmp);
		error_log("----------------------------------------------- ");
*/
		$rs = $db->query($sql);
		if( MDB2::isError($rs) ) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
			$result = FALSE;
			throw new Exception('Errore aggiornaNelDB - SQL: '.$sql);
			//die($rs->getMessage());
		}
		else {
			$result = TRUE;
		}
		return $result;
	}


	public function caricaDalDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT * FROM utenti WHERE username='".$this->getUsername()."';";
		//echo $sql;

		$rs = $db->query($sql);
		while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
		{
			$this->getObjRuolo()->setIdRuolo($row['id_ruolo']);
			$this->setIdUtente($row['id_utente']);
			$this->setPassword($row['password']);
			$this->setTel($row['tel']);
			$this->setEmail($row['email']);
			$this->setCognomeNome($row['cognome_nome']);
		}
	}

	/**
	 * @return carica l'oggetto utente dall'ID (già settato)
	 * @parameter ID
	 */
	public function caricaDalDBFromID() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT * FROM utenti WHERE id_utente='".$this->getIdUtente()."';";
		//echo $sql;

		$rs = $db->query($sql);
		while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
		{
			$this->getObjRuolo()->setIdRuolo($row['id_ruolo']);
			$this->setIdUtente($row['id_utente']);
			$this->setPassword($row['password']);
			$this->setTel($row['tel']);
			$this->setEmail($row['email']);
			$this->setCognomeNome($row['cognome_nome']);
		}
	}


	public function setRuoloFromIDUtente() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT
					ruoli.*
					FROM
					ruoli
					INNER JOIN utenti ON utenti.id_ruolo = ruoli.id_ruolo
					WHERE
					utenti.id_utente = '".$this->getIdUtente()."';";


		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			$tmpRuolo = new Ruolo();
			$tmpRuolo->setIdRuolo($row['id_ruolo']);
			$tmpRuolo->setRuolo($row['ruolo']);
			$this->setObjRuolo($tmpRuolo);

			$result = true;
		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
		return $result;

	}

	public function prelevaTuttiIdStraordinarioDalDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT
					straordinari.id_straordinario
					FROM
					straordinari
					WHERE
					straordinari.id_utente = '".$this->getIdUtente()."'
					ORDER BY straordinari.id_straordinario DESC;";

//echo $sql;
		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$i = 0;
			while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				$result[$i] = $row['id_straordinario'];
				$i++;
			}

		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
		return $result;

	}



	public function prelevaLastIdAreaFromDBStraordinari() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT
					straordinari.id_area
					FROM
					straordinari
					WHERE
					straordinari.id_utente = '".$this->getIdUtente()."'
					ORDER BY straordinari.id_straordinario DESC
					LIMIT 1;";


		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			$result = $row['id_area'];
		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
		return $result;

	}






















	public function mostraSunto() {
		
		$ARRAY_CAMPI = array("categoria");
	
	$s = "";
    $s .= "
<table border=1>
        \n";
    $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        foreach (get_class_vars(get_class($this)) as $name => $value) {
        	$s .= " \n";
        	
        	if (is_array($this->$name) && ($name == ARRAY_Incarichi)) {
        		$tmp_importo = 0;
        		$tmp_incarichi = 0;
        		foreach ($this->$name as $key1=>$value1) {
        			$tmp_importo = $tmp_importo + $value1->getImporto();
        			$tmp_incarichi ++;
        		}
        		$s .= "<tr>
                		<td>Totale Importo:</td>
                    	<td>".number_format($tmp_importo,2,',','.')."</td>
                    	</tr><tr>
        				<td>Totale Incarichi:</td>
                    	<td>".$tmp_incarichi."</td>
                    	</tr>";
        	}
        if (is_array($this->$name) && ($name == ARRAY_Incarichi_Ente)) {
        		$tmp_importo = 0;
        		$tmp_incarichi = 0;
        		foreach ($this->$name as $key1=>$value1) {
        			$tmp_importo = $tmp_importo + $value1->getImporto();
        			$tmp_incarichi ++;
        		}
        		$s .= "<tr>
                		<td>Totale Importo PRV:</td>
                    	<td>".number_format($tmp_importo,2,',','.')."</td>
                    	</tr><tr>
        				<td>Totale Incarichi PRV:</td>
                    	<td>".$tmp_incarichi."</td>
                    	</tr>";
        	}
        	
        if (($this->$name != "") && (in_array($name, $ARRAY_CAMPI))) {
        	$s .= "
                <tr>
                	<td>$name:</td>
                    <td>";
                    if (is_array($this->$name)) {
						foreach ($this->$name as $key1=>$value1) {
							if (is_object($value1)) {
								$s .= $value1->mostraSunto();
							}
							else
                        		$s .= $value1;
                   		}
                  	}
                    else
                    	$s .= $this->$name;
                    $s .= "</td>
                </tr>
                \n";
                }
        }
        $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        $s .= "
</table>
\n";

        return $s;
		
	}
	

	
	
		
	public function mostraSuntoORIG() {
		
		$ARRAY_CAMPI = array("categoria","ARRAY_Incarichi","ARRAY_Incarichi_Ente");
	
	$s = "";
    $s .= "
<table border=1>
        \n";
    $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        foreach (get_class_vars(get_class($this)) as $name => $value) {
        	$s .= " \n";
        if (($this->$name != "") && (in_array($name, $ARRAY_CAMPI))) {
        	$s .= "
                <tr>
                	<td>$name:</td>
                    <td>";
                    if (is_array($this->$name)) {
						foreach ($this->$name as $key1=>$value1) {
							if (is_object($value1)) {
								$s .= $value1->mostraSunto();
							}
							else
                        		$s .= $value1;
                   		}
                  	}
                    else
                    	$s .= $this->$name;
                    $s .= "</td>
                </tr>
                \n";
                }
        }
        $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        $s .= "
</table>
\n";

        return $s;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function __tostring() {
    $s = "";
    $s .= "
<table border=1>
        \n";
    $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        foreach (get_class_vars(get_class($this)) as $name => $value) {
        	$s .= " \n";

        if ($this->$name != "") {
        	$s .= "
                <tr>
                	<td>$name:</td>
                    <td>";
                    if (is_array($this->$name)) {
						foreach ($this->$name as $key1=>$value1) {
							if (is_object($value1)) {
								$s .= $value1->__tostring();
							}
							else
                        		$s .= $value1;
                   		}
                  	}
                    else
                    	$s .= $this->$name;
                    $s .= "</td>
                </tr>
                \n";
                }
        }
        $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        $s .= "
</table>
\n";

        return $s;
        }
	
        
        
        
	
	
	
	
	
	
    public function __tostringOLD() {
    $s = "";
    $s .= "
<table border=1>
        \n";
    $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        foreach (get_class_vars(get_class($this)) as $name => $value) {
              $s      .= "
        <tr>
                <td>$name:</td>
                <td>" . $name . "</td>
        </tr>
        \n";

        if ($this->$name != "") {

                        $s .= "
                <tr>
                        <td>$name:</td>
                        <td>";
                        if (is_array($this->$name)) {
                                                foreach ($this->$name as $key1=>$value1) {
                                                        $s .= $value1;
                                                }
                                        }
                                        else
                                                $s .= $this->$name;
                        $s .= "</td>
                </tr>
                \n";
                }
        }
        $s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
        $s .= "
</table>
\n";

        return $s;
        }
	
	
	
	
	
	
}



class Dirigente extends Utente {

	function __construct() {
		$tmpRuolo = new Ruolo();
		$tmpRuolo->setIdRuolo(2);
		$tmpRuolo->setRuolo("dirigente");
		$this->setObjRuolo($tmpRuolo);
	}


	public function prelevaTuttiIdStraordinarioDalDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT
					straordinari.id_straordinario
					FROM
					straordinari
					INNER JOIN aree ON straordinari.id_area = aree.id_area
					WHERE
					aree.id_dirigente = '".$this->getIdUtente()."'
					ORDER BY straordinari.id_straordinario DESC;";

//echo $sql;
		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$i = 0;
			while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				$result[$i] = $row['id_straordinario'];
				$i++;
			}

		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
		return $result;

	}


	public function prelevaIdStraordinarioDaTrattareDalDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT
					straordinari.id_straordinario
					FROM
					straordinari
					INNER JOIN aree ON straordinari.id_area = aree.id_area
					WHERE
					aree.id_dirigente = '".$this->getIdUtente()."'
					AND
					straordinari.approvato = ''
					ORDER BY straordinari.id_straordinario DESC;";

//echo $sql;
		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$i = 0;
			while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				$result[$i] = $row['id_straordinario'];
				$i++;
			}

		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
		return $result;

	}




	public function prelevaIdStraordinarioTrattatiDalDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$sql = "SELECT
					straordinari.id_straordinario
					FROM
					straordinari
					INNER JOIN aree ON straordinari.id_area = aree.id_area
					WHERE
					aree.id_dirigente = '".$this->getIdUtente()."'
					AND
					straordinari.approvato <> ''
					ORDER BY straordinari.id_straordinario DESC;";

//echo $sql;
		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$i = 0;
			while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				$result[$i] = $row['id_straordinario'];
				$i++;
			}

		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
		return $result;

	}






}






class UffPersonale extends Utente {

    function __construct() {
        $tmpRuolo = new Ruolo();
        $tmpRuolo->setIdRuolo(3);
        $tmpRuolo->setRuolo("Ufficio del Personale");
        $this->setObjRuolo($tmpRuolo);
    }


    public function prelevaTuttiIdStraordinarioDalDB() {

        /*
         * Config e chiamo DB *******************************
         */
        require_once ('class/ConfigSingleton.php');
        $cfg = SingletonConfiguration::getInstance ();
        require_once ("class/Db.php");
        $factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
        $factory->setDsn($cfg->getValue('DSN'));
        $db=$factory->createInstance();
        //********************************************************

        $sql = "SELECT
					straordinari.id_straordinario
					FROM
					straordinari
					INNER JOIN aree ON straordinari.id_area = aree.id_area
					WHERE
					aree.id_dirigente = '".$this->getIdUtente()."'
					ORDER BY straordinari.id_straordinario DESC;";

//echo $sql;
        $rs = $db->query($sql);

        if ( $rs->numRows() > 0 ) {
            $i = 0;
            while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
                $result[$i] = $row['id_straordinario'];
                $i++;
            }

        }
        elseif ($rs->numRows() == 0 ) {
            $result = false;
        }
        return $result;

    }


    public function prelevaIdStraordinarioDaTrattareDalDB() {

        /*
         * Config e chiamo DB *******************************
         */
        require_once ('class/ConfigSingleton.php');
        $cfg = SingletonConfiguration::getInstance ();
        require_once ("class/Db.php");
        $factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
        $factory->setDsn($cfg->getValue('DSN'));
        $db=$factory->createInstance();
        //********************************************************

        $sql = "SELECT
					straordinari.id_straordinario
					FROM
					straordinari
					INNER JOIN aree ON straordinari.id_area = aree.id_area
					WHERE
					aree.id_dirigente = '".$this->getIdUtente()."'
					AND
					straordinari.approvato = ''
					ORDER BY straordinari.id_straordinario DESC;";

//echo $sql;
        $rs = $db->query($sql);

        if ( $rs->numRows() > 0 ) {
            $i = 0;
            while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
                $result[$i] = $row['id_straordinario'];
                $i++;
            }

        }
        elseif ($rs->numRows() == 0 ) {
            $result = false;
        }
        return $result;

    }




    public function prelevaIdStraordinarioTrattatiDalDB() {

        /*
         * Config e chiamo DB *******************************
         */
        require_once ('class/ConfigSingleton.php');
        $cfg = SingletonConfiguration::getInstance ();
        require_once ("class/Db.php");
        $factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
        $factory->setDsn($cfg->getValue('DSN'));
        $db=$factory->createInstance();
        //********************************************************

        $sql = "SELECT
					straordinari.id_straordinario
					FROM
					straordinari
					INNER JOIN aree ON straordinari.id_area = aree.id_area
					WHERE
					aree.id_dirigente = '".$this->getIdUtente()."'
					AND
					straordinari.approvato <> ''
					ORDER BY straordinari.id_straordinario DESC;";

//echo $sql;
        $rs = $db->query($sql);

        if ( $rs->numRows() > 0 ) {
            $i = 0;
            while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
                $result[$i] = $row['id_straordinario'];
                $i++;
            }

        }
        elseif ($rs->numRows() == 0 ) {
            $result = false;
        }
        return $result;

    }






}



	

?>
