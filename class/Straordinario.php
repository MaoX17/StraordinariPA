<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 28/03/14
 * Time: 17.39
 */

class Straordinario {

	protected $idStraordinario;
	protected $objUtente;
	protected $objArea;
	protected $dataRichiesta;
	protected $oraInizio;
	protected $oraFine;
	protected $motivazione;
	protected $pagamento_recupero;
	protected $dataApprovazione;
	protected $approvato;
    protected $nr_ore;
    protected $note_dirigente;

    /**
     * @param mixed $note_dirigente
     */
    public function setNoteDirigente($note_dirigente)
    {
        $this->note_dirigente = $note_dirigente;
    }

    /**
     * @return mixed
     */
    public function getNoteDirigente()
    {
        return $this->note_dirigente;
    }

    /**
     * @param mixed $nr_ore
     */
    public function setNrOre($nr_ore)
    {
        $this->nr_ore = $nr_ore;
    }

    /**
     * @return mixed
     */
    public function getNrOre()
    {
        return $this->nr_ore;
    }



	/**
	 * @param mixed $approvato
	 */
	public function setApprovato($approvato)
	{
		$this->approvato = $approvato;
	}

	/**
	 * @return mixed
	 */
	public function getApprovato()
	{
		return $this->approvato;
	}  //S/N



	/**
	 * @param mixed $dataApprovazione
	 */
	public function setDataApprovazione($dataApprovazione)
	{
		$this->dataApprovazione = $dataApprovazione;
	}

	/**
	 * @return mixed
	 */
	public function getDataApprovazione()
	{
		return $this->dataApprovazione;
	}

	/**
	 * @param mixed $dataRichiesta
	 */
	public function setDataRichiesta($dataRichiesta)
	{
		$this->dataRichiesta = $dataRichiesta;
	}

	/**
	 * @return mixed
	 */
	public function getDataRichiesta()
	{
		return $this->dataRichiesta;
	}

	/**
	 * @param mixed $idStraordinario
	 */
	public function setIdStraordinario($idStraordinario)
	{
		$this->idStraordinario = $idStraordinario;
	}

	/**
	 * @return mixed
	 */
	public function getIdStraordinario()
	{
		return $this->idStraordinario;
	}

	/**
	 * @param mixed $motivazione
	 */
	public function setMotivazione($motivazione)
	{
		$this->motivazione = $motivazione;
	}

	/**
	 * @return mixed
	 */
	public function getMotivazione()
	{
		return $this->motivazione;
	}

	/**
	 * @param mixed $objArea
	 */
	public function setObjArea($objArea)
	{
		$this->objArea = $objArea;
	}

	/**
	 * @return mixed
	 */
	public function getObjArea()
	{
		return $this->objArea;
	}


	/**
	 * @param mixed $objUtente
	 */
	public function setObjUtente($objUtente)
	{
		$this->objUtente = $objUtente;
	}

	/**
	 * @return mixed
	 */
	public function getObjUtente()
	{
		return $this->objUtente;
	}

	/**
	 * @param mixed $oraFine
	 */
	public function setOraFine($oraFine)
	{
		$this->oraFine = $oraFine;
	}

	/**
	 * @return mixed
	 */
	public function getOraFine()
	{
		return $this->oraFine;
	}

	/**
	 * @param mixed $oraInizio
	 */
	public function setOraInizio($oraInizio)
	{
		$this->oraInizio = $oraInizio;
	}

	/**
	 * @return mixed
	 */
	public function getOraInizio()
	{
		return $this->oraInizio;
	}

	/**
	 * @param mixed $pagamento_recupero
	 */
	public function setPagamentoRecupero($pagamento_recupero)
	{
		$this->pagamento_recupero = $pagamento_recupero;
	}

	/**
	 * @return mixed
	 */
	public function getPagamentoRecupero()
	{
		return $this->pagamento_recupero;
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
			"INSERT INTO straordinari SET
			id_utente = '".$this->getObjUtente()->getIdUtente()."',
			id_area = '".$this->getObjArea()->getIdArea()."',
			data_richiesta ='".$this->getDataRichiesta()."',
			orainizio = '".$this->getOraInizio()."',
			orafine = '".$this->getOraFine()."',
			motivazione = '".mysql_real_escape_string($this->getMotivazione())."',
			pagamento_recupero = '".$this->getPagamentoRecupero()."',
           	data_approvazione = '".$this->getDataApprovazione()."',
           	approvato = '".$this->getApprovato()."';";



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
		$sql = "SELECT LAST_INSERT_ID() FROM straordinari";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ORDERED);
		$this->setIdStraordinario($row[0]);

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
			"UPDATE straordinari SET
			id_utente = '".$this->getObjUtente()->getIdUtente()."',
			id_area = '".$this->getObjArea()->getIdArea()."',
			data_richiesta ='".$this->getDataRichiesta()."',
			orainizio = '".$this->getOraInizio()."',
			orafine = '".$this->getOraFine()."',
			motivazione = '".mysql_real_escape_string($this->getMotivazione())."',
			pagamento_recupero = '".$this->getPagamentoRecupero()."',
           	data_approvazione = '".$this->getDataApprovazione()."',
           	note_dirigente = '".$this->getNoteDirigente()."',
           	approvato = '".$this->getApprovato()."'
           	WHERE
            id_straordinario=".$this->getIdStraordinario().";";

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



  public function eliminaDalDB($id){
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

      //ESEGUO DELETE
      $sql =
          "DELETE FROM straordinari
           WHERE
           id_straordinario=".$id.";";

      $rs = $db->query($sql);
      if( MDB2::isError($rs) ) {
       /*   echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
          $result = FALSE;
          throw new Exception('Errore eliminaNelDB - SQL: '.$sql);
          //die($rs->getMessage()); */
          $result = false;
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

           	$sql = "SELECT straordinari.*, utenti.*, aree.*,
           	    TIMEDIFF(orafine, orainizio) as ore_richiesta
				FROM straordinari
				INNER JOIN utenti ON straordinari.id_utente = utenti.id_utente
				INNER JOIN aree ON straordinari.id_area = aree.id_area
				HAVING straordinari.id_straordinario = '".$this->getIdStraordinario()."';";

		$rs = $db->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);

		$tmpArea = new Area();
		$tmpRuolo = new Ruolo();
		$tmpUtente = new Utente();


		$tmpArea->setIdArea($row['id_area']);
		$tmpArea->setArea($row['area']);
        $tmpArea->caricaDalDB();

		$tmpRuolo->setIdRuolo($row['id_ruolo']);
		$tmpRuolo->setRuoloFromIDRuolo();

		$tmpUtente->setCognomeNome($row['cognome_nome']);
		$tmpUtente->setObjRuolo($tmpRuolo);
		$tmpUtente->setEmail($row['email']);
		$tmpUtente->setIdUtente($row['id_utente']);
		$tmpUtente->setPassword($row['password']);
		$tmpUtente->setTel($row['tel']);
		$tmpUtente->setUsername($row['username']);

		$this->setObjUtente($tmpUtente);
		$this->setDataRichiesta($row['data_richiesta']);
		$this->setDataApprovazione($row['data_approvazione']);
		$this->setPagamentoRecupero($row['pagamento_recupero']);
		$this->setOraInizio($row['orainizio']);
		$this->setOraFine($row['orafine']);
		$this->setApprovato($row['approvato']);
		$this->setMotivazione($row['motivazione']);
		$this->setObjArea($tmpArea);
        $this->setNrOre($row['ore_richiesta']);
        $this->setNoteDirigente($row['note_dirigente']);



	}

    public function visualizzaInTabella(){

        $class="";
            $tmp= $this->getApprovato() ;
                switch ($tmp) {
                case "":
                $class="warning";
                break;
                case 'S':
                $class="success";
                break;
                case 'N':
                $class="danger";
                break;
                }



        echo "<tr class='$class'><td>".$this->getObjUtente()->getCognomeNome()."</td>";
        echo "<td>".$this->getDataRichiesta()."</td>";
        echo "<td>".$this->getMotivazione()."</td>";
        if ($this->getApprovato() == ""){
            echo "<td>"."in Attesa"."</td>";
        }
        else {
            echo "<td>".($this->getApprovato()=='S'?'Approvato':'Permesso Negato')."</td>";
        }


        echo "<td>".($this->getDataApprovazione()=='0000-00-00'?'in Attesa':$this->getDataApprovazione())."</td>";
        echo "<td>".$this->getOraInizio()."</td>";
        echo "<td>".$this->getOraFine()."</td>";
        echo "<td>".$this->getNrOre()."</td>";
        echo "<td>".($this->getPagamentoRecupero()=='p' ? 'Pagamento':'Recupero ore')."</td>";

        echo "<td><textarea rows='3' cols='20' readonly name='note_dirigente'>".$this->getNoteDirigente()."</textarea></td>";
        echo "<td>".$this->getObjArea()->getObjDirigente()->getCognomeNome()."</td></tr>";
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

		$sql = "SELECT straordinari.*
				FROM straordinari
				WHERE straordinari.id_straordinario = '".$this->getIdStraordinario()."';";

		echo $sql;

		$rs = $db->query($sql);
		if ( $rs->numRows() > 0 ) {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			return true;
		}
		else {
			return false;
		}



	}



	public function controllaEsistenzaDaRichiesta() {

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

		$sql = "SELECT straordinari.*
				FROM straordinari
				WHERE
				straordinari.id_utente = '".$this->getObjUtente()->getIdUtente()."'
				AND
				straordinari.data_richiesta = '".$this->getDataRichiesta()."'
				AND
				straordinari.approvato <> 'N';";



		$rs = $db->query($sql);
		if ( $rs->numRows() > 0 ) {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			return true;
		}
		else {
			return false;
		}



	}


	public function controllaDataCorretta() {

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

		$dt_massima_straordinari = new DateTime();
		$dt_massima_straordinari->modify('-1 months');
		//echo $dt_massima_straordinari->format('Y-m-d');
		//echo "Data : ";
		//echo $this->getDataRichiesta();
		//converto in formato data
		//
		//echo "Data Ric: ";
		//echo $dt_richiesta->format('Y-m-d');

		$dt_richiesta = new DateTime($this->getDataRichiesta());
		//echo $dt_richiesta->format('Y-m-d');
		//echo $dt_massima_straordinari->format('Y-m-d');

		if ($dt_richiesta < $dt_massima_straordinari) {

			return false;
		}
		else {
			return true;
		}

	}



	public function seModificabile() {

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

		if ($this->getApprovato() == "") {
			return true;
		}
		else {
			return false;
		}

	}


	public function seApprovato() {

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

		if ($this->getApprovato() == "S") {
			return true;
		}
		elseif ($this->getApprovato() == "N") {
			return false;
		}

	}



}
