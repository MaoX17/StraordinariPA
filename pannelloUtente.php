<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 04/04/14
 * Time: 13.02
 */
?>

<?
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

// Includo tutte le classi
require_once ($percorso_relativo.'class/Utente.php');
require_once ($percorso_relativo.'class/Area.php');
require_once ($percorso_relativo.'class/Ruolo.php');
require_once ($percorso_relativo.'class/Log.php');
require_once ($percorso_relativo.'class/Straordinario.php');

$dirigente = new Dirigente();
$area = new Area();
$utente = new Utente();
$ruolo = new Ruolo();
$uffpersonale= new UffPersonale();

$utente = unserialize($_SESSION['utente']);
?>




<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9"> <!-- Colonna centrale-SX -->
            <h3><?=$titolo_pagina?></h3>


<?php

if (ctrl_login_boolean() && $_SESSION['idRuolo']=='1') {
	?>
	<div class="well">
		<strong>Benvenuto <?=$utente->getCognomeNome()?> - <?=$utente->getEmail()?></strong>
		<br><br>
		<a href="inserisci1.php" class="btn btn-info">Inserisci straordinario</a>
		<a href="visualizzaRichieste.php" class="btn btn-success">Consulta stato straordinari richiesti</a>
		<a href="logout.php" class="btn btn-primary">Logout</a>
	</div>
<?

}
elseif (ctrl_login_boolean() && $_SESSION['idRuolo']=='2') {
	?>
	<div class="well">
		<strong>Benvenuto Direttore <?=$utente->getCognomeNome()?> - <?=$utente->getEmail()?></strong>
		<br><br>
		<a href="visualizzaDirigente.php" class="btn btn-info">Vedi richieste straordinari da approvare</a>
		<a href="visualizzaDirigenteStorico.php" class="btn btn-warning">Vedi richieste straordinari gi&agrave; trattate</a>
		<a href="logout.php" class="btn btn-primary">Logout</a>
	</div>
<?

}
//UFFICIO PERSONALE
elseif (ctrl_login_boolean() && $_SESSION['idRuolo']=='3') {
	?>
	<div class="well">
		<strong>Benvenuto Admin <?=$utente->getCognomeNome()?> </strong> <!-- - <?=$utente->getEmail()?> -->
		<br><br>
		<a href="visualizzaUffPersonale.php" class="btn btn-info">Vedi richieste straordinari</a>
		<a href="visualizzaUffPersonaleSingoloDip.php" class="btn btn-success">Vedi richieste singolo Dipendente</a>
		<a href="sostituzioneDirigenti.php" class="btn btn-warning">Delega e sostituzione Dirigenti</a>
		<a href="logout.php" class="btn btn-primary">Logout</a>
	</div>
<?

}
else {
	?>
	<div class="panel-danger">
		<strong>ERRORE: Utente e/o Password errati!!!!!</strong>
		<br><br>
	</div>
<?
}
?>
</div><!-- /Colonna centrale-SX -->
</div><!--/row-->
</div><!--/.container-->

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>