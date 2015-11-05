<?php
/**
 * Created by Maurizio Proietti
 * User: mproietti
 * Date: 31/10/13
 * Time: 14.15
 */
?>
<!--
/**
 * Created by Maurizio Proietti
 * User: mproietti
 * Date: 31/10/13
 * Time: 14.15
 */
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>

    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

    <!-- La seguente stringa Ã¨ necessaria x jquery su IE8 sennÃ² da errore
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Servizio di registrazione nell'elenco delle imprese per l'invito a procedure negoziate e di cottimo  fiduciario relative a lavori di importo fino ad un milione di euro.">
    <meta name="author" content="Maurizio Proietti">
    <meta name=â€�keywordsâ€� content="elenco ditte prato imprese " />
    <meta http-equiv="content-language" content="it" />


    <!-- Bootstrap core CSS -->
    <link href="<?=$percorso_relativo?>grafica/bootstrap301/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?=$percorso_relativo?>grafica/bootstrap301/css/offcanvas.css" rel="stylesheet">
    <link href="<?=$percorso_relativo?>grafica/maox.css" rel="stylesheet">

    <!--[if IE 7]>
    <link href="/grafica/bootstrap301/css/ie7/css/bootstrap-ie7.css" rel="stylesheet">
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="<?=$percorso_relativo?>/script/html5shiv.js"></script>
    <script src="<?=$percorso_relativo?>/script/html5shiv-printshiv.js"></script>
    <script src="<?=$percorso_relativo?>/script/respond.min.js"></script>
    <![endif]-->




<!-------------------------------------------------------------------------------------------->

    <script src="<?=$percorso_relativo?>/script/jquery-1.10.2.min.js"></script>
    <script src="<?=$percorso_relativo?>/script/jquery-migrate-1.2.1.min.js"></script>

    <script type="text/javascript" src="<?=$percorso_relativo?>grafica/bootstrap301/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?=$percorso_relativo?>script/jscript.js"></script>

    <script src="<?=$percorso_relativo?>/script/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?=$percorso_relativo?>/script/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?=$percorso_relativo?>/script/additional-methods.min.js"></script>
    <script type="text/javascript" src="<?=$percorso_relativo?>/script/messages_it.js"></script>


    <script type="text/javascript">

        jQuery.validator.setDefaults ({
        // debug: true,
        success: "valid"
        });

        $(document).ready(function() {
          /*  $("#formRegistrazione").validate({
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "cat[]" || element.attr("id") == "cat" ) {
                        error.insertAfter("#checkError");
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


			$("#myForm").validate({
				errorPlacement: function(error, element) {
					error.insertAfter(element);
				}
			});*/


        });

    </script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?=$percorso_relativo?>grafica/bootstrap301/js/moment-with-langs.min.js"></script>
<script type="text/javascript" src="<?=$percorso_relativo?>grafica/bootstrap301/js/bootstrap-datetimepicker.min.js"></script>

<!-- <script type="text/javascript" src="percorsofile.js"></script>  -->
<link rel="stylesheet" href="<?=$percorso_relativo?>grafica/bootstrap301/css/bootstrap-datetimepicker.min.css" />


<!-------------------------------------------------------------------------------------------->



    <title> <?=$titolo_pagina ?> </title>
</head>

