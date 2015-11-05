<?php
/**
 * Created by PhpStorm.
 * User: jcapuozzo
 * Date: 29/04/14
 * Time: 11.53
 */

$percorso_relativo = "./";
include ($percorso_relativo."include.inc.php");
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

$straordinario->setIdStraordinario($_GET['id']);
$utente = unserialize($_SESSION['utente']);
$straordinario->caricaDalDB();
$id=$_GET['id'];
$return['result']=$straordinario->eliminaDalDB($id);

echo json_encode($return);
$log=new Log();
$log->riempiObj($utente, $straordinario, "eliminazione richiesta straord");
$log->creaNelDB();
//echo $result;
?>