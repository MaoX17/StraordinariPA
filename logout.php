<?php
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

$_SESSION = array();
session_unset();
session_destroy(); 

session_restart();

$percorso_relativo = "./";

header("Location: ".$percorso_relativo."index.php");