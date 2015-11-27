<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 04/11/13
 * Time: 17.56
 */

?>

<?php
$percorso_relativo = "./";
require ($percorso_relativo."include.inc.php");

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

            <address>
                <strong>C.E.D. della Provincia di Prato</strong><br>
                via Ricasoli, 25<br>
                59100 (PO) Prato<br>
                <abbr title="Phone">P:</abbr> (0574) 534-1
            </address>

            <address>
                <strong>Contatto Email</strong><br>
                <a href="mailto:elencoditte@provincia.prato.it?subject=Elenco Ditte...">elencoditte@provincia.prato.it</a>
            </address>


        </div>
        <!-- /Colonna Centrale-SX -->

    </div><!--/row-->


</div><!--/.container-->


<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
