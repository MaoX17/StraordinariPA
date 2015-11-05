<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 04/04/14
 * Time: 11.38
 */

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

$titolo_pagina = "Pannello di Controllo - Inserimento Straordinari - Provincia di Prato";

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");

// Includo tutte le classi
require_once ($percorso_relativo.'class/Utente.php');
require_once ($percorso_relativo.'class/Area.php');
require_once ($percorso_relativo.'class/Ruolo.php');
require_once ($percorso_relativo.'class/Log.php');
require_once ($percorso_relativo.'class/Straordinario.php');

$dirigente = new Utente();
$area = new Area();
$utente = new Utente();
$ruolo = new Ruolo();
$straordinario = new Straordinario();
$log=new Log();




if ((ctrl_login_boolean()) && ($_SESSION['idRuolo'] == "1")) {

	$utente = unserialize($_SESSION['utente']);

	$ruolo = $utente->getObjRuolo();
	$area->setIdArea($_POST['area']);
	$area->setAreaFromIdFromDB();
	$straordinario->setObjArea($area);
	$straordinario->setApprovato("");
	$straordinario->setDataApprovazione("");
	$straordinario->setDataRichiesta($_POST['data_richiesta']);
	$straordinario->setMotivazione($_POST['motivazione']);
	$straordinario->setObjUtente($utente);
	$straordinario->setOraInizio($_POST['ora_inizio']);
	$straordinario->setOraFine($_POST['ora_fine']);
	$straordinario->setPagamentoRecupero($_POST['optrecupero']);
	$straordinario->setIdStraordinario($_POST['id_straordinario']);

    $log->riempiObj($utente, $straordinario, "modifica richiesta straord");
    $log->creaNelDB();
	$straordinario->aggiornaNelDB();




	?>


	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<!-- Colonna centrale-SX -->
			<div class="col-xs-12 col-sm-8">
				<h2 class="text-danger">Straordinario inserito</h2>


				<?
				include ($percorso_relativo."forms/formVisualSingoloStraordinario.php");
				?>

				<h4>Cliccare sulla data per modificare la richiesta appena inserita</h4>
			</div>
		</div>
		<br><br><br>
	</div>


<?php

}
?>

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
