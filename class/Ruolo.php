<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 04/04/14
 * Time: 10.06
 */

class Ruolo {

	protected $idRuolo;
	protected $ruolo;

	/**
	 * @param mixed $idRuolo
	 */
	public function setIdRuolo($idRuolo)
	{
		$this->idRuolo = $idRuolo;
	}

	/**
	 * @return mixed
	 */
	public function getIdRuolo()
	{
		return $this->idRuolo;
	}

	/**
	 * @param mixed $ruolo
	 */
	public function setRuolo($ruolo)
	{
		$this->ruolo = $ruolo;
	}

	/**
	 * @return mixed
	 */
	public function getRuolo()
	{
		return $this->ruolo;
	}



	public function setRuoloFromIDRuolo() {

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
					ruoli.ruolo
					FROM
					ruoli
					WHERE
					ruoli.id_ruolo = '".$this->getIdRuolo()."';";


		$rs = $db->query($sql);

		if ( $rs->numRows() > 0 ) {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			$this->setRuolo($row['ruolo']);
			$result = true;
		}
		elseif ($rs->numRows() == 0 ) {
			$result = false;
		}
		return $result;

	}




} 