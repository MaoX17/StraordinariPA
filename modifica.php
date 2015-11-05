<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 03/04/14
 * Time: 18.28
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

$titolo_pagina = "Pannello di Controllo - Inserimento Straordinari - Provincia di Prato";

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
$utente = new Utente();
$ruolo = new Ruolo();
$straordinario = new Straordinario();



if ((ctrl_login_boolean()) && ($_SESSION['idRuolo'] == "1")) {
	$utente = unserialize($_SESSION['utente']);
    //var_dump($utente);
    //print_r($_SESSION);
	$id_straordinario = $_GET['id'];
	$straordinario->setIdStraordinario($id_straordinario);
	$straordinario->caricaDalDB();


	?>

	<div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<!-- Colonna centrale-SX -->
			<div class="col-xs-12 col-sm-8">
				<h2 class="text-danger">Richiesta straordinario </h2>
				<div class="well">
					<form role="form" name='myForm' id='myForm' action="modifica2.php" method="post">
						<?
						include ($percorso_relativo."forms/formInsStraord.php");
						?>
						<button type="submit" class="btn btn-default">Invia richiesta</button>
                        <button data-straordinario="<?php echo $straordinario->getIdStraordinario($id_straordinario) ?>" class="btn btn-danger col-md-offset-7">Elimina</button>

                    </form>
				</div>
			</div>
		</div>
		<br><br><br>
	</div>

<?
}
?>
<script>
    $("[data-straordinario]").click(function(e){
        e.preventDefault();
        delete_db($(this).data('straordinario'));
    })
    function delete_db(id){
        if(!confirm("Confermi l'eliminazione?"))
            return false;
            $.ajax({
                url: "delete.php",
                type:"get",
                dataType:'json',
                data: {'id' : id},
                success: function(data) {

                 if  (data['result']==true) {
                     alert('Eliminazione avvenuta con successo!');
                     location.href='pannelloUtente.php';
                    }
                   console.log(data);



                }
            });
    }
</script>
<?

include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>

