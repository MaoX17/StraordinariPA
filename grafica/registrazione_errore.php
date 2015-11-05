<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 07/11/13
 * Time: 17.28
 */


$percorso_relativo = "./";
include ($percorso_relativo."include.inc.php");

/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo."class/ConfigSingleton.php");
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
//********************************************************

require_once $percorso_relativo.'class/Ditta.php';
require_once $percorso_relativo.'class/Categoria.php';

if (isset($_POST['idDitta'])) {
    $idDitta_tmp01 = $_POST['idDitta'];
    $idDitta = $idDitta_tmp01;
}
if (isset($_SESSION['ditta'])) {
    $ditta = new Ditta();
    $ditta = $_SESSION['ditta'];
    $idDitta_tmp02 = $ditta->getIdDitta();
    $idDitta = $idDitta_tmp02;
}

if (isset($idDitta_tmp01) AND (isset($idDitta_tmp02) AND ($idDitta_tmp01 <> $idDitta_tmp02))) {
    error_log("ATTENZIONE!! Presenti 2 IdDitta diversi!!!");
}

if ($ditta->controllaSeEsiste($idDitta) == FALSE) {
    //------------------- SE CI SONO PROBLEMI DI REGISTRAZIONE NEL DB --------------

    $titolo_pagina = "ERRORE!! - Elenco Ditte - Provincia di Prato";

    include($percorso_relativo."grafica/head_bootstrap.php");
    include($percorso_relativo."grafica/body_head_bootstrap.php");
?>
    <div class="container">

        <div class="row row-offcanvas row-offcanvas-right">

            <!-- Colonna centrale-SX -->
            <div class="col-xs-12 col-sm-9">
                <h3>Registrazione nuova ditta - ERRORE</h3>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Attenzione!!!</b></h3>
                    </div>
                    <div class="panel-body">
                        Procedura NON si e' conclusa a cause di un errore interno.<br>
                        Si prega di Riprovare.<br>
                        Se l'errore dovesse ripresentarsi si prega di darne al pi&ugrave presto comunicazione all'indirizzo: <br>
                        <a class="btn btn-danger" href="mailto:elencoditte@provincia.prato.it?subject=Elenco Ditte...">elencoditte@provincia.prato.it</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include($percorso_relativo."grafica/body_foot_bootstrap.php");
}
?>
