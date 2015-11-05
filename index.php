<?php
$percorso_relativo = "./";
require ($percorso_relativo."include.inc.php");

//include('manutenzione_on.php');

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

$titolo_pagina = "Gestione Straordinari - Provincia di Prato";

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");

?>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <!-- Colonna centrale-SX -->
        <div class="col-xs-12 col-sm-9">

            <div class="jumbotron">
                <h2>Gestione Straordinari - Provincia di Prato</h2>
                <p>Benvenuti nel servizio di gestione straordinari della provincia di Prato.</p>
                <a href="login.php" class="btn btn-success" role="button">Accedi</a>
                <a href="" class="btn btn-primary" role="button">FaQ</a>
				<a href="" class="btn btn-danger" role="button">Pannello</a>
            </div>
        </div>
        <!-- /Colonna centrale-SX -->




    </div><!--/row-->


</div><!--/.container-->


<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
