<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  
	<!-- La seguente stringa è necessaria x jquery su IE8 sennò da errore -->
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	
	<script type="text/javascript" src="<?=$percorso_relativo?>script/jscript.js"></script>
	

<!-- <script src="http://code.jquery.com/jquery-latest.js"></script> -->
<script src="<?=$percorso_relativo?>script/jquery-latest.js"></script> 
<script src="<?=$percorso_relativo?>script/jquery.form.js"></script>

<script type="text/javascript" src="<?=$percorso_relativo?>script/jquery-validate/lib/jquery.metadata.js"></script>
<script type="text/javascript" src="<?=$percorso_relativo?>script/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?=$percorso_relativo?>script/jquery-validate/localization/messages_it.js"></script> 

<!-- 
http://dev.jquery.com/view/trunk/plugins/validate/demo/images/checked.gif
http://dev.jquery.com/view/trunk/plugins/validate/demo/images/unchecked.gif
 -->
<script type="text/javascript">
jQuery.validator.setDefaults({
//	debug: true,
	success: "valid"
});;
</script>

<style type="text/css" media="all">@import "<?=$percorso_relativo?>grafica/sito.css";</style> 
	
	<title> <?=$titolo_pagina ?> </title>
</head>

