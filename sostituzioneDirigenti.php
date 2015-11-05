

<?php
/**
 * Created by mproietti.
 * User: mproietti
 * Date: 04/04/14
 * Time: 11.38
 */

$percorso_relativo = "./";
include ($percorso_relativo."include.inc.php");


/*
 * Config e chiamo DB *****************************
 */
require_once ('class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
require_once ("class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
//********************************************************

$titolo_pagina = "Pannello di Controllo Admin - sostituzione dirigenti - Provincia di Prato";

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
$utente = new UffPersonale();
$ruolo = new Ruolo();

//ruolo=3 -> uffpersonale
if ((ctrl_login_boolean()) && ($_SESSION['idRuolo'] == "3")) {


?>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <!-- Colonna centrale-SX -->
        <div class="col-xs-12 col-sm-9">

			<div class="breadcrumb">
				<form action="sostituzioneDirigenti2.php" method="post" name="frmDelegheDirigenti">

				<h3>Gestione Deleghe dirigenti - Gestionale degli straordinari - Provincia di Prato</h3>


<?php


	//Elenco le aree e relativo dirigente titolare
	$sql= "select aree.* , utenti.cognome_nome
			from aree
			INNER JOIN utenti on aree.id_dirigente = utenti.id_utente
			where
			aree.abilitato = 'S';";

	//echo $sql;

	$rs = $db->query($sql);
	echo "<p>Situazione attuale - Aree e Dirigenti </p>";
	echo "<ul>";
	while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		echo "<li>".$row['area']." - ".$row['cognome_nome']." - ".$row['note']."</li>";
	}
	echo "</ul>";

	echo "<br> Selezione l'area da delegare: ";

$sql= "select aree.* , utenti.cognome_nome
			from aree
			INNER JOIN utenti on aree.id_dirigente = utenti.id_utente
			where
			aree.abilitato = 'S';";

//echo $sql;

$rs = $db->query($sql);
?>


			<select name="idarea" class="form-control">

<?php
	while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {

    	echo "<option value=\"".$row['id_area']."\">".$row['area']." - ".$row['cognome_nome']." - ".$row['note']."</option>";

	}
?>
			</select>
				<br>

				<input type="submit" class="btn btn-success" value="avanti...">
				</form>
			</div>

		</div>
		<!-- /Colonna centrale-SX -->




	</div><!--/row-->


</div><!--/.container-->


	<?php
//chiudo controllo permessi - Gruppo uffPers
}

include($percorso_relativo."grafica/body_foot_bootstrap.php");


/*
 * TODO: Attenzione - Da controllare: Metodo getIdDirigenteFromDB class Area
 */


?>