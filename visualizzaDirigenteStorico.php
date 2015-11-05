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

$titolo_pagina = "Pannello di Controllo Direttore - Visualizzazione Straordinari - Provincia di Prato";

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
$utente = new Dirigente();
$ruolo = new Ruolo();

//ruolo=2 -> dirigente
if ((ctrl_login_boolean()) && ($_SESSION['idRuolo'] == "2")) {

	?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<!-- Colonna centrale-SX -->
			<div class="col-xs-12 col-sm-8">
				<h2 class="text-danger"> Visualizzazione richieste </h2>

					<div class="table-responsive">

						<table class="table table-bordered">
							<thead>
							<tr>
                                <th>Dipendente</th>
                                <th>Data straordinario</th>
                                <th>Ora inizio</th>
                                <th>Ora fine</th>
                                <th>Motivazione</th>
                                <th>Pagamento/Recupero</th>
                                <th>Approvazione</th>
                                <th>Data approvazione</th>
                                <th>Note/Commenti</th>
                                <th>Area</th>
							</tr>
							</thead>
							<tbody>

							<?

							$utente = unserialize($_SESSION['utente']);
														//$utente = new Dirigente();
							$ArrayStraordinariDipendenti = $utente->prelevaIdStraordinarioTrattatiDalDB();

							if (is_array($ArrayStraordinariDipendenti)) {
							foreach ($ArrayStraordinariDipendenti as $id_straordinario) {
								$straordinario = new Straordinario();
								$straordinario->setIdStraordinario($id_straordinario);
								$straordinario->caricaDalDB();

								if ($straordinario->seApprovato()) {
									//$primaRiga = "<a href='".$percorso_relativo."modifica.php?id=".$straordinario->getIdStraordinario()."'> ".$straordinario->getDataRichiesta()." </a>";
									$primaRiga = $straordinario->getDataRichiesta();
									$class = "success";
								}
								else {
									$primaRiga = $straordinario->getDataRichiesta();
									$class = "danger";
								}


								?>
								<tr class="<?=$class?>">
									<td> <?=$straordinario->getObjUtente()->getCognomeNome()?> </td>
									<td> <?=$primaRiga?> </td>
									<td> <?=$straordinario->getOraInizio()?> </td>
									<td> <?=$straordinario->getOraFine()?></td>
									<td> <?=$straordinario->getMotivazione()?></td>
									<td> <?=$straordinario->getPagamentoRecupero()=="p"?"Pagamento":"Recupero Ore"?></td>
									<td> <?=$straordinario->getApprovato()=="S"?"Approvato":"Permesso Negato"?></td>


									<td> <?=$straordinario->getDataApprovazione()=="0000-00-00"?"In Attesa":$straordinario->getDataApprovazione()?></td>
                                    <td><textarea rows='3' cols='20' readonly name='note_dirigente'><?=$straordinario->getNoteDirigente()?></textarea></td>
									<td> <?=$straordinario->getObjArea()->getArea()?></td>
								</tr>
							<?
							}
							?>


				<?
				}
                ?>
                            </tbody>
						</table>
					</div>
				<a href="pannelloUtente.php" class="btn btn-success">Torna al Pannello di Controllo</a>

			</div>
		</div>
		<br><br><br>
	</div>

<?php

}

include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
