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

    <script type="text/javascript">

     $(document).ready(function(){
         $("tr[data-straordinario] :radio").click(function(){
           if($(".js-validation-n[data-straordinario="+$(this).data('straordinario')+"]").is(":checked"))
                $("textarea[data-straordinario="+$(this).data('straordinario')+"]").attr('placeholder','Campo obbligatorio');
            else
               $("textarea[data-straordinario="+$(this).data('straordinario')+"]").removeAttr('placeholder');
         })
        $("#myForm").submit(function(event){

           $("tr[data-straordinario]").each(function( index,value ) {
                var checked = $(value).find(".js-validation-n").is(":checked")
                var testo=$.trim($(value).find("textarea").val());
                if(checked && testo ==""){
                    $(value).find("textarea").attr('placeholder','Campo obbligatorio').css('color', 'red');
                    event.preventDefault();
                }
           });

         })
     })

    </script>

	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<!-- Colonna centrale-SX -->
			<div class="col-xs-12 col-sm-8">
				<h2 class="text-danger">Visualizzazione richieste dipendenti</h2>
				<form role="form" name='myForm' id='myForm' action="visualizzaDirigente02.php" method="post">
					<div class="table-responsive">

						<table class="table table-bordered">
							<thead>
							<tr>
								<th>Dipendente</th>
								<th>Data</th>
								<th>Ora inizio</th>
								<th>Ora fine</th>
								<th>Motivazione</th>
								<th>Pagamento/Recupero</th>
								<th>Approvazione</th>
								<th>Note/Commenti</th>
								<th>Area</th>
							</tr>
							</thead>
							<tbody>

							<?

							$utente = unserialize($_SESSION['utente']);
//							$utente = new Dirigente();
							$ArrayStraordinariDipendenti = $utente->prelevaIdStraordinarioDaTrattareDalDB();

							if (is_array($ArrayStraordinariDipendenti)) {
							foreach ($ArrayStraordinariDipendenti as $id_straordinario) {
								$straordinario = new Straordinario();
								$straordinario->setIdStraordinario($id_straordinario);
								$straordinario->caricaDalDB();

								if ($straordinario->seModificabile()) {
									//$primaRiga = "<a href='".$percorso_relativo."modifica.php?id=".$straordinario->getIdStraordinario()."'> ".$straordinario->getDataRichiesta()." </a>";
									$primaRiga = $straordinario->getDataRichiesta();
									$class = "warning";
								}
								else {
									$primaRiga = $straordinario->getDataRichiesta();
									$class = "success";
								}
								if ($straordinario->getApprovato() == "N") {
									$class = "danger";
								}

								?>
								<tr class="<?=$class?>" data-straordinario="<?=$id_straordinario?>">
									<td> <?=$straordinario->getObjUtente()->getCognomeNome()?> </td>
									<td> <?=$primaRiga?> </td>
									<td> <?=$straordinario->getOraInizio()?> </td>
									<td> <?=$straordinario->getOraFine()?></td>
									<td> <?=$straordinario->getMotivazione()?></td>
									<td><?=$straordinario->getPagamentoRecupero()=='p'?'Pagamento':'Recupero ore'?></td>
									<td>
										<?
										$tmp = $straordinario->getApprovato();
										if ($tmp == "S") {
											$chs = "checked";
											$chn = "";
										}
										elseif ($tmp == "N") {
											$chs = "checked";
											$chn = "";
										}
										else {
											$chs = "";
											$chn = "";
										}

										//Modifica - tolto checked="true" qui sotto
										?>
										<input data-straordinario="<?=$id_straordinario?>" type="radio"  name="approvato[<?=$id_straordinario?>]" value="S" <?=$chs?> >
										Approva
										<br>

										<input  data-straordinario="<?=$id_straordinario?>" type="radio" name="approvato[<?=$id_straordinario?>]" class="js-validation-n"  value="N" <?=$chn?> >
										Nega Permesso
									</td>


                                            <td><textarea data-straordinario="<?=$id_straordinario?>" rows='3' cols='40' name="note_dirigente[<?=$id_straordinario?>]"></textarea></td>
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
					<button type="submit" class="btn btn-info">Registra Tutto</button>
				</form>


			</div>
		</div>
		<br><br><br>
	</div>

<?php

}

include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
