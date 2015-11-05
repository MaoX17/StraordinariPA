<?php
/**
 * Created by Maurizio Proietti
 * User: mproietti
 * Date: 31/10/13
 * Time: 14.14
 */
?>

<body>
<?
$IP = $_SERVER['REMOTE_ADDR'];
$IP_TRUNK = substr($IP, 0, 7);
if ($IP_TRUNK <> "172.21.") {
?>
<!------------------------------------------------------------
<h1>WORK IN PROGRESS!!!</h1>
<?
//exit(0);
}
?>
<!------------------------------------------------------------>


<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
          <a class="navbar-brand" href="<?=$percorso_relativo?>index.php">Straordinari</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
      <!--      <li class="active"><a href="http://elencoditte.provincia.prato.it">Elenco Ditte</a></li>   --> 
            <li>
                <?
            //Eseguo il controllo dell'ip sorgente
            $IP = $_SERVER['REMOTE_ADDR'];
            $IP_TRUNK = substr($IP, 0, 7);
            if (($IP_TRUNK == "172.21.") OR ($IP_TRUNK == "172.22." )) {
                /*
                 * TODO: Spostare login e tutto il necessario x la sez. amministrativa nella cartelle admin
                 */
            //    echo '<a href="'.$percorso_relativo.'admin/" class="list-group-item">Admin</a>';
            }
            ?>
            </li>
            <li><a href="<?=$percorso_relativo?>login.php" class="list-group-item">Accedi</a></li>
            <li><a href="<?=$percorso_relativo?>pannelloUtente.php" class="list-group-item">Entra nel tuo pannello</a></li>
<!--  		<li><a href="<?=$percorso_relativo?>forgotpassword.php" class="list-group-item">Password Dimenticata</a></li> -->
            <li><a href="<?=$percorso_relativo?>logout.php" class="list-group-item">Logout</a></li>
<!--             <li><a href="<?=$percorso_relativo?>contact.php" class="list-group-item">Contact</a></li> -->
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

<!-------------------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------------------->

