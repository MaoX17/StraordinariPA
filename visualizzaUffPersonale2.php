

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
 * Config e chiamo DB *****************************
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

//print_r ($_POST);

$where = "";
    

    if ($_POST['da'] <> "")  {
        $da=$_POST['da'];
        $where=" WHERE data_richiesta >= '$da' " ;
    }

    if ($_POST['a'] <> "") {
        if (strlen($where) > 0 ) {
            $where.=" AND ";
        }
        else {
            $where = " WHERE ";
        }
        $a=$_POST['a'];
        $where=$where."data_richiesta <= '$a' " ;
    }

    if (isset($_POST['optrecupero'])){
        if (strlen($where) > 0 ) {
            $where.=" AND ";
        }
        else {
            $where = " WHERE ";
        }
        $pag_recupero=$_POST['optrecupero'];
        $where=$where."pagamento_recupero = '$pag_recupero' ";
    }

    if (isset($_POST['approvato'])){
        if (strlen($where) > 0 ) {
            $where.=" AND ";
        }
        else {
            $where = " WHERE ";
        }
        $approvato=$_POST['approvato'];
        $where=$where." approvato = '$approvato' ";
    }

    if ($_POST['ordina'] == "dipendenti") {
        $ordina=$_POST['ordina'];
        $where=$where."ORDER BY utenti.cognome_nome, data_richiesta DESC " ;
    }
    if ($_POST['ordina'] == "dirigenti") {
        $ordina=$_POST['ordina'];
        $where=$where."ORDER BY aree.id_dirigente, data_richiesta DESC " ;
    }



    $sql= "SELECT straordinari.*, utenti.*, aree.*, dir_utenti.cognome_nome as nominativo_dir
           FROM straordinari INNER JOIN utenti ON straordinari.id_utente=utenti.id_utente
           INNER JOIN aree ON straordinari.id_area=aree.id_area
           INNER JOIN utenti dir_utenti ON dir_utenti.id_utente=aree.id_dirigente "
            .$where;
    //echo $sql;

    echo "
<table class='table table-striped' border=1 align=center id='table'>
    <thead>
        <tr>
            <th>Cognome Nome </th>
            <th>Data straordinario </th>
            <th>Motivazione </th>
            <th>Approvazione</th>
            <th>Data approvazione </th>
            <th>Ora inizio</th>
			<th>Ora fine</th>
            <th>Ore straord </th>
            <th>Pag/Recupero</th>
            <th>Note dirigente</th>
            <th>Dirigente </th>
        </tr>
    </thead>
    <tbody>";
    $array_int= array ("Cognome Nome", "Data straordinario", "Motivazione", "Approvazione", "Data approvazione", "Ora inizio", "Ora fine", "Ore straordinario", "Pag/Recupero", "Note dirigente", "Dirigente");

    $handle = fopen("/var/www/vhosts/personale/straordinari/tmp/RichiesteStraordinari.csv", "w");
    fputcsv($handle, $array_int);

    $i=0;
    $rs = $db->query($sql);
    while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
        $array_id_straord[$i]= $row['id_straordinario'];
        $i++;
    }
    //echo "I = ".$i;
    //print_r ($array_id_straord);

    foreach ($array_id_straord as $i){
        $straordinario=new Straordinario();
        $straordinario->setIdStraordinario($i);
        $straordinario->caricaDalDB();
        $straordinario->visualizzaInTabella();
        $array_ris= array($straordinario->getObjUtente()->getCognomeNome() , $straordinario->getDataRichiesta() , $straordinario->getMotivazione() , $straordinario->getApprovato() , $straordinario->getDataApprovazione() , $straordinario->getOraInizio() , $straordinario->getOraFine() , $straordinario->getNrOre() , $straordinario->getPagamentoRecupero() , $straordinario->getNoteDirigente() , $straordinario->getObjArea()->getObjDirigente()->getCognomeNome() );
        fputcsv($handle, $array_ris);

    }



echo "</tbody></table>";

fclose($handle);
    ?>


    <style type="text/css">
        #link:link    {color: black; text-decoration:underline; font-size: 18pt; background-color:#3dbcf5; border-radius:2px}
        #link:hover   {color: red; font-size: 18pt; text-decoration:none; background-color:#3dbcf5}
    </style>

    <?php
echo "<center><a href='./tmp/RichiesteStraordinari.csv' id='link' > Clicca qui per scaricare! </a><br></center>";
}

include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>
<!--
<script type="text/javascript">
    $("#link").hover(function(){
        $(this).html('Scarica')
    }, function(){
        $(this).html('Clicca qui per scaricare!')
    })
</script>
-->