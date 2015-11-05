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

$titolo_pagina = "Pannello di Controllo Admin - Visualizzazione Straordinari - Provincia di Prato";

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




        $sql=" SELECT utenti.cognome_nome, utenti.id_utente
        FROM utenti
        WHERE utenti.id_ruolo='1'";


       // echo $sql;

        $rs = $db->query($sql);


	?>
	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<!-- Colonna centrale-SX -->
			<div class="col-xs-12 col-sm-8">
				<h2 class="text-danger">Richieste per Dipendente</h2>
				<form role="form" name='myForm' class="form-horizontal"  id='myForm' action="visualizzaUffPersonaleSingoloDip2.php" method="post">

                    <div class='well'>
                        <div class="col-md-2">
                            <b>Data richieste:</b>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="da" class="label-info">DA</label>
                                <div class='input-group date' id="da">

                                    <input type='text' class="form-control" name="da" data-format="YYYY-MM-DD" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#da').datetimepicker({
                                    pickTime: false,
                                    language:'it'
                                });
                            });
                        </script>
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="a" class="label-info">A</label>
                                <div class='input-group date' id='a'>
                                    <input type='text' class="form-control" name="a" data-format="YYYY-MM-DD" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $(function () {
                                $('#a').datetimepicker({
                                    pickTime: false,
                                    language:'it'
                                });
                            });
                        </script><br>

                        <div class="row">

                        </div>
                        <div class="col-md-4">
                            <b>Pagamento/Recupero:</b>
                        </div>
                        <div class="col-md-4">
                            <input type="radio" name="optrecupero" id="p" value="p" >
                            Pagamento
                        </div>

                        <div class="col-md-4">
                            <input type="radio" name="optrecupero" id="r" value="r" >
                            Recupero ore
                        </div>


                        <div class="row">

                        </div>
                        <br>
                        <div class="col-md-4">
                            <b>Approvazione:</b>
                        </div>
                        <div class="col-md-4">
                            <input type="radio" name="approvato" id="s" value="S" >
                            Approvate
                        </div>

                        <div class="col-md-4">
                            <input type="radio" name="approvato" id="n" value="N" >
                            Negate
                        </div><br><br>


                      <div class="col-md-3">
                          <b>Scegli dipendente</b>
                      </div>
                      <div class="col-md-4">
                          <select name="dipendenti" class="form-control">

<?php
                              while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) { ?>

                              <option value="<?=$row['id_utente'] ?>"> <?=$row['cognome_nome'] ?> </option>
<?php
                              }
?>

                          </select>
                      </div><br><br><br>
                  </div>
					<center><button type="submit" class="btn btn-info">Ok</button></center>
				</form>


			</div>
		</div>
		<br><br><br>
	</div>

<?php

}

include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
