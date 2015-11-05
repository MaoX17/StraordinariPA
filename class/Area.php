<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 31/03/14
 * Time: 10.39
 */

class Area {

	protected $idArea;
	protected $area;
	protected $objDirigente;
	protected $note;
	protected $abilitato;
	protected $titolare_area;

	/**
	 * @param mixed $titolare_area
	 */
	public function setTitolareArea($titolare_area)
	{
		$this->titolare_area = $titolare_area;
	}

	/**
	 * @return mixed
	 */
	public function getTitolareArea()
	{
		return $this->titolare_area;
	}


	/**
	 * @param mixed $abilitato
	 */
	public function setAbilitato($abilitato)
	{
		$this->abilitato = $abilitato;
	}

	/**
	 * @return mixed
	 */
	public function getAbilitato()
	{
		return $this->abilitato;
	}

	/**
	 * @param mixed $area
	 */
	public function setArea($area)
	{
		$this->area = $area;
	}

	/**
	 * @return mixed
	 */
	public function getArea()
	{
		return $this->area;
	}

	/**
	 * @param mixed $idArea
	 */
	public function setIdArea($idArea)
	{
		$this->idArea = $idArea;
	}

	/**
	 * @return mixed
	 */
	public function getIdArea()
	{
		return $this->idArea;
	}

	/**
	 * @param mixed $note
	 */
	public function setNote($note)
	{
		$this->note = $note;
	}

	/**
	 * @return mixed
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * @param mixed $objDirigente
	 */
	public function setObjDirigente($objDirigente)
	{
		$this->objDirigente = $objDirigente;
	}

	/**
	 * @return mixed
	 */
	public function getObjDirigente()
	{
		return $this->objDirigente;
	} //S o N


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
		$dirigente = new Dirigente();

		$sql =
			"UPDATE aree SET
			area ='".$this->getArea()."',
			id_dirigente = '".$this->getObjDirigente()->getIdUtente()."',
			note = '".$this->getNote()."',
           	abilitato = '".$this->getAbilitato()."'
           	WHERE
            id_area=".$this->getIdArea().";";

		//echo $sql;


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
		$dirigente = new Dirigente();

		$sql =
			"INSERT INTO aree SET
			area ='".$this->getArea()."',
			id_dirigente = '".$this->getObjDirigente()->getIdUtente()."',
			note = '".$this->getNote()."',
           	abilitato = '".$this->getAbilitato()."';";

		//echo $sql;

		$rs = $db->query($sql);
		if( MDB2::isError($rs) ) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
			$result = FALSE;
			throw new Exception('Errore creaNelDB - SQL: '.$sql);
			//die($rs->getMessage());
		}
		else {
			$result = TRUE;
		}

		//setto il corretto id_anagrafica all'oggetto in base al risultato dell'insert
		$sql = "SELECT LAST_INSERT_ID() FROM aree";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ORDERED);
		$this->setIdArea($row[0]);


		return $result;
	}



	/**
	 * todo: aggiungere metodo che sostituisca questo sotto (v. modifica)
	 */

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
/*
 * MP MODIFICA: 2014-06-05 Ho modificato la query qui sotto per consentire la visualizzazione delle richieste "storiche"
 * fatte ad un'area disabilitata
 */
		//$sql = "SELECT * FROM aree WHERE id_area=".$this->getIdArea().";";
		$sql = "SELECT aree.*, utenti.*
				FROM aree
				INNER JOIN utenti on aree.id_dirigente = utenti.id_utente
				WHERE
				-- aree.abilitato = 'S' AND
				aree.id_area = ".$this->getIdArea().";";
		//echo $sql;
		$rs = $db->query($sql);
		while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
		{
			$this->setArea($row['area']);
			$this->setAbilitato($row['abilitato']);
			$this->setNote($row['note']);

				$tmpDirigente = new Dirigente();
				$tmpDirigente->setIdUtente($row['id_utente']);
				$tmpDirigente->setPassword($row['password']);
				$tmpDirigente->setUsername($row['username']);
				$tmpDirigente->setEmail($row['email']);
				$tmpDirigente->setCognomeNome($row['cognome_nome']);
				$tmpDirigente->setTel($row['tel']);

			$this->setObjDirigente($tmpDirigente);
		}
	}

	public function caricaDalDBSoloAbilitate() {

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
		/*
		 * MP MODIFICA: 2014-06-05 Ho modificato la query qui sotto per consentire la visualizzazione delle richieste "storiche"
		 * fatte ad un'area disabilitata
		 */
		//$sql = "SELECT * FROM aree WHERE id_area=".$this->getIdArea().";";
		$sql = "SELECT aree.*, utenti.*
				FROM aree
				INNER JOIN utenti on aree.id_dirigente = utenti.id_utente
				WHERE
				aree.abilitato = 'S' AND
				aree.id_area = ".$this->getIdArea().";";
		//echo $sql;
		$rs = $db->query($sql);
		while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
		{
			$this->setArea($row['area']);
			$this->setAbilitato($row['abilitato']);
			$this->setNote($row['note']);

			$tmpDirigente = new Dirigente();
			$tmpDirigente->setIdUtente($row['id_utente']);
			$tmpDirigente->setPassword($row['password']);
			$tmpDirigente->setUsername($row['username']);
			$tmpDirigente->setEmail($row['email']);
			$tmpDirigente->setCognomeNome($row['cognome_nome']);
			$tmpDirigente->setTel($row['tel']);

			$this->setObjDirigente($tmpDirigente);
		}
	}

	public function caricaDalDBConTitolare() {

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
		/*
		 * MP MODIFICA: 2014-06-05 Ho modificato la query qui sotto per consentire la visualizzazione delle richieste "storiche"
		 * fatte ad un'area disabilitata
		 */
		//$sql = "SELECT * FROM aree WHERE id_area=".$this->getIdArea().";";
		$sql = "SELECT aree.*, utenti.*
				FROM aree
				INNER JOIN utenti on aree.id_dirigente = utenti.id_utente
				WHERE
				aree.titolare_area = 'S' AND
				aree.area = '".$this->getArea()."';";
		//echo $sql;
		$rs = $db->query($sql);
		while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
		{
			$this->setIdArea($row['id_area']);
			$this->setAbilitato($row['abilitato']);
			$this->setNote($row['note']);

			$tmpDirigente = new Dirigente();
			$tmpDirigente->setIdUtente($row['id_utente']);
			$tmpDirigente->setPassword($row['password']);
			$tmpDirigente->setUsername($row['username']);
			$tmpDirigente->setEmail($row['email']);
			$tmpDirigente->setCognomeNome($row['cognome_nome']);
			$tmpDirigente->setTel($row['tel']);

			$this->setObjDirigente($tmpDirigente);
		}
	}


	/**
	 * @return il dirigente attualmente abilitato per l'area in esame
	 */
	public function getIdDirigenteFromDB() {

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
					id_dirigente
				FROM aree
				WHERE
					id_area=".$this->getIdArea()." AND
					abilitato = 'S';";
		//echo $sql;
		$rs = $db->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
		return $row['id_dirigente'];
	}


	/**
	 * @return il dirigente titolare per l'area in esame
	 */
	public function getIdDirigenteTitolareFromDB() {

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
					id_dirigente
				FROM aree
				WHERE
					area='".$this->getArea()."' AND
					titolare_area = 'S';";
		//echo $sql;
		$rs = $db->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
		return $row['id_dirigente'];
	}


	public function setAreaFromIdFromDB() {

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
					area
				FROM aree
				WHERE
					id_area=".$this->getIdArea().";";
		//echo $sql;
		$rs = $db->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
		$this->setArea($row['area']);
	}


} 