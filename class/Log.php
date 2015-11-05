<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 31/03/14
 * Time: 10.37
 */

class Log {

	protected $idLog;
	protected $objUtente;
	protected $objStraordinario;
	protected $dataOra;
	protected $operazione;
	protected $ipSorgente;

	/**
	 * @param mixed $dataOra
	 */
	public function setDataOra($dataOra)
	{
		$this->dataOra = $dataOra;
	}

	/**
	 * @return mixed
	 */
	public function getDataOra()
	{
		return $this->dataOra;
	}

	/**
	 * @param mixed $idLog
	 */
	public function setIdLog($idLog)
	{
		$this->idLog = $idLog;
	}

	/**
	 * @return mixed
	 */
	public function getIdLog()
	{
		return $this->idLog;
	}

	/**
	 * @param mixed $ipSorgente
	 */
	public function setIpSorgente($ipSorgente)
	{
		$this->ipSorgente = $ipSorgente;
	}

	/**
	 * @return mixed
	 */
	public function getIpSorgente()
	{
		return $this->ipSorgente;
	}

	/**
	 * @param mixed $objStraordinario
	 */
	public function setObjStraordinario($objStraordinario)
	{
		$this->objStraordinario = $objStraordinario;
	}

	/**
	 * @return mixed
	 */
	public function getObjStraordinario()
	{
		return $this->objStraordinario;
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
	 * @param mixed $operazione
	 */
	public function setOperazione($operazione)
	{
		$this->operazione = $operazione;
	}

	/**
	 * @return mixed
	 */
	public function getOperazione()
	{
		return $this->operazione;
	}

    public function riempiObj($ObjUtente, $ObjStraord, $azione){

    $this->setObjUtente($ObjUtente);
    $this->setObjStraordinario($ObjStraord);
    //$this->setDataOra(time());
    $this->setDataOra(date('Y-m-d H:i:s'));
    $this->setOperazione($azione);
    $this->setIpSorgente($_SERVER['REMOTE_ADDR']);

    }

	public function riempiObjSenzaStraordinario($ObjUtente, $azione){

		$ObjStraord = new Straordinario();
		$this->setObjUtente($ObjUtente);
		$this->setObjStraordinario($ObjStraord);
		//$this->setDataOra(time());
		$this->setDataOra(date('Y-m-d H:i:s'));
		$this->setOperazione($azione);
		$this->setIpSorgente($_SERVER['REMOTE_ADDR']);

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
            "INSERT INTO log SET
            id_utente = '".$this->getObjUtente()->getIdUtente()."',
			id_straord = '".$this->getObjStraordinario()->getIdStraordinario()."',
			data_ora ='".$this->getDataOra()."',
			operazione = '".$this->getOperazione()."',
           	ip_sorgente = '".$this->getIpSorgente()."';";



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
        $sql = "SELECT LAST_INSERT_ID() FROM log";
        $rs = $db->query($sql);
        $row = $rs->fetchRow(MDB2_FETCHMODE_ORDERED);
        $this->setIdLog($row[0]);

        return $result;
    }




}





