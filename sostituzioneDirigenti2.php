

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

$dirigente = new Dirigente();

$idArea = $_POST['idarea'];


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

						echo "<p>Dirigente Attualmente associato all'area: <b>".$dirigente->getCognomeNome()."</b></p>";

						echo "<br>";
						echo "<br>";

						echo "<p>Sostituire l'attuale dirigente con il seguente: </p>";

						//Elenco le aree e relativo dirigente titolare
						$sql= "select utenti.*
								from utenti
								where utenti.id_ruolo = '2';";

						//echo $sql;

						$rs = $db->query($sql);


						?>


						<select name="idnuovodirigente" class="form-control">

							<?php
							while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {

								echo "<option value=\"".$row['id_utente']."\">".$row['cognome_nome']." - ".$row['email']."</option>";

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