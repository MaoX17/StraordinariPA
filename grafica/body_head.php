<body>
    <div id="box">

        <div id="header">
        	<img src="<?=$percorso_relativo?>grafica/images/provincia_prato_home_full.jpg" alt=""/>
        </div>

        <div id="header2"></div>

        <div id="menu">
	        <ul>
	            <li><a href="<?=$percorso_relativo?>index.php">Home</a></li>
<!--            <li><a href="http://streaming.provincia.prato.it/video-pubblicati/62-elencoprofessionisti">Video Guida </a></li> -->
<!--            <li><a href="<?=$percorso_relativo?>faq_view.php">Leggi FAQ</a></li> -->
<!--            <li><a href="<?=$percorso_relativo?>faq.php">Invia FAQ</a></li> -->
<!--            <li><a href="<?=$percorso_relativo?>modifica_dati00.php">Area Gestione Dati</a></li> -->


<?
//Eseguo il controllo dell'ip sorgente
$IP = $_SERVER['REMOTE_ADDR'];
$IP_TRUNK = substr($IP, 0, 7);
if (($IP_TRUNK == "172.21.") OR ($IP_TRUNK == "172.22." )) {
	//TODO: Spostare login e tutto il necessario x la sez. amministrativa nella cartelle admin
	echo '<li><a href="'.$percorso_relativo.'admin/">Admin</a></li>';
}
?>


	            <li><a href="<?=$percorso_relativo?>logout.php">Logout</a></li>
			</ul>	
        </div>

        <div id="posts">
        	<h2 class="titolo_generale">Gestione straordinari - Provincia di Prato</h2>

					
				
