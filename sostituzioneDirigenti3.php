

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
$log = new Log();

$dirigente = new Dirigente();

$idArea = $_POST['idarea'];
$idNuovoDirigente = $_POST['idnuovodirigente'];


//ruolo=3 -> uffpersonale
if ((ctrl_login_boolean()) && ($_SESSION['idRuolo'] == "3")) {



	?>

	<div class="container">

		<div class="row row-offcanvas row-offcanvas-right">

			<!-- Colonna centrale-SX -->
			<div class="col-xs-12 col-sm-9">

				<div class="breadcrumb">
					<form action="sostituzioneDirigenti3.php" method="post" name="frmDelegheDirigenti">

						<h3>Gestione Deleghe dirigenti - Gestionale degli straordinari - Provincia di Prato</h3>


						<!--
						Salvo l'id area x passarlo al prossimo form
						-->
						<input type="hidden" name="idarea" value="<?=$idArea?>">

						<?php

						$area->setIdArea($idArea);
						$area->caricaDalDB();
						$idDirigenteAbilitato = $area->getIdDirigenteFromDB();

						$idDirigenteTitolare = $area->getIdDirigenteTitolareFromDB();

						echo "<p>Area scelta: <b>".$area->getArea()."</b></p> <br>";

						$dirigente->setIdUtente($idDirigenteTitolare);
						$dirigente->caricaDalDBFromID();

						echo "<p>Dirigente Titolare dell'area: <b>".$dirigente->getCognomeNome()."</b></p>";

						$dirigente->setIdUtente($idDirigenteAbilitato);
						$dirigente->caricaDalDBFromID();

						echo "<p>Dirigente Precedentamente associato all'area: <b>".$dirigente->getCognomeNome()."</b></p>";

						echo "<br>";
						echo "<br>";

						$dirigente->setIdUtente($idNuovoDirigente);
						$dirigente->caricaDalDBFromID();
						echo "<p>Dirigente Delegato per la gestione dell'area: <b>".$dirigente->getCognomeNome()."</b></p>";

						echo "<br>";
						echo "<br>";

						//operazioni x associazione nuovo dirigente all'area

						//ho 3 casi:
						//scelgo lo stesso attuale (DEMENTI) non faccio nulla
						if ($idNuovoDirigente == $idDirigenteAbilitato )
						{
							//Non eseguo nulla
						}
						//Se riattribuisco la carica al dirigente titolare devo disabilitare il vecchio (abilitato) e riabilitare il titolare
						elseif ($idNuovoDirigente == $idDirigenteTitolare) {

							$area->setIdArea($idArea);

							//disabilito il vecchio dirigente (la riga dell'area)
							$area->caricaDalDBSoloAbilitate();

							$area->setAbilitato("N");
							$area->setNote("Disabilitato il ".date("Y-m-d"));


							//---- LOG
							$utente->setIdUtente($_SESSION['idLogin']);
							$utente->caricaDalDBFromID();
							$log->riempiObjSenzaStraordinario($utente,"Delega dirigente - Disabilito ".$area->getObjDirigente()->getCognomeNome());
							$log->creaNelDB();
							//---- /LOG

							$area->aggiornaNelDB();

							//Riabilito il titolare
							$area->caricaDalDBConTitolare();
							$area->setAbilitato("S");
							$area->setNote("Ripristino titolare ".$area->getObjDirigente()->getCognomeNome()." in data ".date("Y-m-d"));

							//---- LOG
							$log->riempiObjSenzaStraordinario($utente,"Delega dirigente - Ripristino titolare ".$area->getObjDirigente()->getCognomeNome());
							$log->creaNelDB();
							//---- /LOG

							$area->aggiornaNelDB();

						}
						//Altrimenti se il nuovo dirigente non è il titolare DISABILITO il vecchio e faccio un insert x abilitare il nuovo
						else {

							$area->setIdArea($idArea);
							$area->caricaDalDBSoloAbilitate();

							//disabilito il dirigente attuale e aggiorno
							$area->setAbilitato("N");
							$area->setNote("Disabilitato il ".date("Y-m-d"));

							//---- LOG
							$utente->setIdUtente($_SESSION['idLogin']);
							$utente->caricaDalDBFromID();
							$log->riempiObjSenzaStraordinario($utente,"Delega dirigente - Disabilito ".$area->getObjDirigente()->getCognomeNome());
							$log->creaNelDB();
							//---- /LOG

							$area->aggiornaNelDB();

							$dirigente_prec = new Dirigente();
							$dirigente_prec->setIdUtente($idDirigenteAbilitato);
							$dirigente_prec->caricaDalDBFromID();

							$dirigente->setIdUtente($idNuovoDirigente);
							$dirigente->caricaDalDBFromID();
							$area->setObjDirigente($dirigente);
							$area->setAbilitato("S");
							$area->setNote("Sostituzione di ".$dirigente_prec->getCognomeNome()." in data ".date("Y-m-d"));

							//---- LOG
							$log->riempiObjSenzaStraordinario($utente,"Delega dirigente - Sost di ".$dirigente_prec->getCognomeNome()." con ".$area->getObjDirigente()->getCognomeNome());
							$log->creaNelDB();
							//---- /LOG

							$area->creaNelDB();

						}

						echo "<p>Operazione Eseguita</p>";
	?>

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