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

$titolo_pagina = "Pannello di Controllo - Gestione Straordinari - Provincia di Prato";

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");

// Includo tutte le classi
require_once ($percorso_relativo.'class/Utente.php');
require_once ($percorso_relativo.'class/Area.php');
require_once ($percorso_relativo.'class/Ruolo.php');
require_once ($percorso_relativo.'class/Log.php');
require_once ($percorso_relativo.'class/Straordinario.php');

if ((ctrl_login_boolean()) && ($_SESSION['idRuolo'] == "2")) {

    $utente = unserialize($_SESSION['utente']);
//print_r($_POST);
    foreach ($_POST as $controllo => $ARRAYvalue) {

        foreach ($ARRAYvalue as $id_straordinario => $value) {
            $straordinario = new Straordinario();
            $log=new Log();
            $straordinario->setIdStraordinario($id_straordinario);

            $straordinario->caricaDalDB();

            if ($controllo == "approvato") {
                //inserisco approvazione

                $straordinario->setApprovato($value);
                $straordinario->setDataApprovazione(date("Y-m-d"));


            }
            if ($controllo == "note_dirigente") {
                //inserisco note

                $straordinario->setNoteDirigente($value);
            }
            //var_dump($straordinario);
            $log->riempiObj($utente, $straordinario, "approvazione dirigente");
            $log->creaNelDB();
            $straordinario->aggiornaNelDB();
            /* if ($controllo == "optrecupero") {
            //inserisco recupero/pagamento
            $straordinario->caricaDalDB();
            $straordinario->setPagamentoRecupero($value);
            $log->riempiObj($utente, $straordinario, "variazione recupero_pagamento dirigente");
            $log->creaNelDB();
            $straordinario->aggiornaNelDB();
             }

 */
        }
    }




	?>


	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<!-- Colonna centrale-SX -->
			<div class="col-xs-12 col-sm-8">
				<h2 class="text-danger">Straordinari Aggiornati correttamente</h2>

				<a href="pannelloUtente.php" class="btn btn-success">Torna al Pannello di Controllo</a>
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
