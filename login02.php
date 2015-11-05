<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 04/11/13
 * Time: 18.40
 */
?>

<?php
$percorso_relativo = "./";
include ($percorso_relativo."include.inc.php");


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

$titolo_pagina = "Pannello di Controllo - Gestione Straordinari - Provincia di Prato";

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");

$username = $_POST['username'];
$password = $_POST['password'];

// Includo tutte le classi
require_once ($percorso_relativo.'class/Utente.php');
require_once ($percorso_relativo.'class/Area.php');
require_once ($percorso_relativo.'class/Ruolo.php');
require_once ($percorso_relativo.'class/Log.php');
require_once ($percorso_relativo.'class/Straordinario.php');

$dirigente = new Dirigente();
$area = new Area();
$uffpersonale= new UffPersonale();
$ruolo = new Ruolo();


/*
 * Richiamo connessione Active Directory per login ***********
 */
require_once ($percorso_relativo.'class/adLDAP/src/adLDAP.php');

try {
	$adldap = new adLDAP();
	}

catch (adLDAPException $e) {
	echo $e;
	exit();
}
$adldap->close();
$adldap->connect();


// Eseguo autenticazione
$authUser = $adldap->user()->authenticate($username, $password);


//SE auth OK
if ($authUser == true) {
	//controllo se è dirigente(idruolo=2) o uff pers(idruolo=3) o dipendente (idruolo=1)

	$sql = "SELECT	ruoli.id_ruolo, utenti.id_utente
					FROM
					utenti
					INNER JOIN ruoli ON utenti.id_ruolo = ruoli.id_ruolo
					WHERE
					utenti.username = '".$username."';";

	//echo $sql;

	$rs = $db->query($sql);
	$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
	$idRuolo = $row['id_ruolo'];

	//Dipendente
	if ($idRuolo == "1") {
		$utente = new Utente();
	}
	//Dirigente
	elseif ($idRuolo == "2") {
		$utente = new Dirigente();
	}
	//UffPersonale
	elseif ($idRuolo == "3") {
        $utente = new UffPersonale();

	}
	//Se non è nel DB - Quindi Dipendente
	else {
		$utente = new Utente();
	}


	//ottengo info da AD
	$info=$adldap->user()->info($username);
	//istanzio utente e compilo valori necessari

	$utente->setUsername($username);
	$utente->setPassword(md5($password));

	//Se utente esiste nel DB
	if ($utente->controllaEsistenza() == true ) {

		//Utente esistente - Compilo campi ed Eseguo aggiornamento
		$utente->setRuoloFromIDUtente();

		$ruolo->setRuolo($utente->getObjRuolo()->getRuolo());
		$ruolo->setIdRuolo($utente->getObjRuolo()->getIdRuolo());

		//Adesso so se dipendente, dirigente o uff_pers

		$utente->caricaDalDB();

		$utente->setUsername($username);
		$utente->setPassword(md5($password));
		$utente->setCognomeNome($info[0]['displayname'][0]);
		$utente->setEmail($info[0]['mail'][0]);
		//TODO: scrivi funzione x interrogare rubrica tel su LDAP
		$utente->setTel("");

		if ($utente->getObjRuolo()->getRuolo == "dirigente") {
			$_SESSION['idArea'] = "";
		}
		elseif ($utente->getObjRuolo()->getRuolo == "Ufficio del Personale") {
			$_SESSION['idArea'] = "";
		}
		//se dipendente
		else {
			$_SESSION['idArea'] = $utente->prelevaLastIdAreaFromDBStraordinari();
		}


		$utente->aggiornaNelDB();
	}
	//Se utente NON esiste nel DB
	else {


		//Utente NON esistente - Eseguo inserimento - Sicuramente non è Dirigente o Uff_Pers perchè già presenti
		//e inseriti in fase di installzione
		$ruolo->setIdRuolo("1");
		$ruolo->setRuoloFromIDRuolo();

		$utente->setUsername($username);
		$utente->setPassword(md5($password));
		$utente->setCognomeNome($info[0]['displayname'][0]);
		$utente->setEmail($info[0]['mail'][0]);
		//TODO: scrivi funzione x interrogare rubrica tel su LDAP
		$utente->setTel("");
		$utente->setObjRuolo($ruolo);

		$utente->creaNelDB();
	}


	$_SESSION['idLogin'] = $utente->getIdUtente();
	$_SESSION['idRuolo'] = $ruolo->getIdRuolo();
	$_SESSION['utente'] = serialize($utente);

}
else {
	// getLastError is not needed, but may be helpful for finding out why:
	$last_error=$adldap->getLastError();
	$_SESSION['idLogin'] = "";

	//echo "User authentication unsuccessful";
}

//*************************************************************


include($percorso_relativo."pannelloUtente.php");
?>