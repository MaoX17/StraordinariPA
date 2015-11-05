<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 04/11/13
 * Time: 18.08
 */

$_SESSION = array();
session_destroy();

$percorso_relativo = "./";
require ($percorso_relativo."include.inc.php");

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

$titolo_pagina = "Gestione Straordinari - Provincia di Prato";

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");


//require_once $percorso_relativo.'class/Ditta.php';
//require_once $percorso_relativo.'class/Categoria.php';


?>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <!-- Colonna centrale-SX -->
        <div class="col-xs-12 col-sm-9">


            <div class="well">

                <h2 class="text-danger">Login </h2>
                <form role="form" name='myForm' id='myForm' action="login02.php" method="post">

                <?
                include ($percorso_relativo."forms/formLogin.php");
                ?>

                <button type="submit" class="btn btn-default">Accedi</button>

                </form>
            </div>
        </div>
    </div>
</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>

