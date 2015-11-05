function seleziona_altro(obj_select, id_text) {
	if (obj_select.value == "ALTRO") {
		oggetto = document.getElementById(id_text);
		oggetto.disabled=false;
	}
	else {
		oggetto = document.getElementById(id_text);
		oggetto.disabled=true;
	}
};

function enable_disable(id_campo) {
	oggetto = document.getElementById(id_campo);
	//alert(oggetto.disabled);
	if (oggetto.disabled==false) {
		oggetto.disabled=true;
		//alert('ENABLE->DISABLE');
	}
	else if (oggetto.disabled==true) {
		oggetto.disabled=false;
		//alert('DISABLE->ENABLE');
	}
}

function disabilita(id_campo) {
		oggetto = document.getElementById(id_campo);
		oggetto.disabled=true;
	
	};

function abilita(id_campo) {
		oggetto = document.getElementById(id_campo);
		oggetto.disabled=false;
	};

function tp_pratica(campo, campo_vis) {
	if ((campo.value == "autorizzazione") || (campo.value == "autorizzazione_attingimento")) {
		campo_vis.disabled=true;
	}
	else {
		campo_vis.disabled=false;
	}
	return true;
	};

function apri(indirizzo, xwindow, ywindow) {
	str = 'resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=nostatus=no,menubar=nocopyhistory=no';
	if (xwindow != "" && ywindow != "") {str = str + ',width='+xwindow+',height='+ywindow; }
	//nuovo = window.open(indirizzo,'mywindow','resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=nostatus=no,menubar=nocopyhistory=no');
	//alert (str);
	nuovo = window.open(indirizzo,'mywindow',str);
	return (nuovo);
	};

function apri2(indirizzo, xwindow, ywindow) {
	//str = 'resizable=yes,scrollbars=yes,toolbar=no,location=no,directories=nostatus=no,menubar=nocopyhistory=no';
	//if (xwindow != "" && ywindow != "") {str = str + ',width='+xwindow+',height='+ywindow; }
	//nuovo = window.open(indirizzo,'mywindow',str);
	//return (nuovo);
	//return MOOdalBox.open( // case matters
	//	indirizzo, // the link URL
	//	indirizzo, // the caption (link's title) - can be blank
	//	"850 850" // width and height of the box - can be left blank
	//	);
	//tb_show("TITOLO",indirizzo + '?height=' + ywindow + '&width=' + xwindow, 'page');
	//Modalbox.show(indirizzo, {title: this.title, width: xwindow}); return false;
	Modalbox.show(indirizzo, {width: xwindow, height: 500}); return false;
		
	};


function ricarica(indirizzo) {
	nuovo = window.open(indirizzo,'_self','');
	return (nuovo);
	};


function ControllaDate(datactrl) {
if (datactrl.value.substring(4,5) != "-" ||
   datactrl.value.substring(7,8) != "-" ||
   isNaN(datactrl.value.substring(0,4)) ||
   isNaN(datactrl.value.substring(5,7)) ||
   isNaN(datactrl.value.substring(8,10))) {
      alert("Inserire nascita in formato AAAA-MM-GG");
      datactrl.value = "";
      datactrl.focus();
      return false;
} else if (datactrl.value.substring(0,4) < 1900) {
	alert("Impossibile utilizzare un valore inferiore a 1900 per l'anno");
      datactrl.select();
   return false;
} else if (datactrl.value.substring(5,7) > 12) {
   alert("Impossibile utilizzare un valore superiore a 12 per i mesi");
   datactrl.value = "";
   datactrl.focus();
   return false;
} else if (datactrl.value.substring(8,10) > 31) {
   alert("Impossibile utilizzare un valore superiore a 31 per i giorni");
   datactrl.value = "";
   datactrl.focus();
   return false;
}
return true;
};

function ControllaCampoNecessario(campoctrl, lunghezza, lunghezza2) {
if (campoctrl.value == "") {
      alert("Attenzione Completare tutti i campi NECESSARI. Campo " + campoctrl.name + " Necessario." );
      //campoctrl.value = "";
      campoctrl.focus();
      campoctrl.select();
      return false;
}
if (lunghezza != 0)
{
	//alert ("XX");
	//alert (campoctrl.value.length);
	if ((campoctrl.value.length != lunghezza) && (campoctrl.value.length != lunghezza2))
	{
		alert("Attenzione Lunghezza errata");
        //campoctrl.value = "";
        campoctrl.focus();
        campoctrl.select();
        return false;
	}
	
}
return true;
};

/*
function indirizzoEmailValido(indirizzo) {
	return (indirizzo.indexOf("@") > 0);
	};
*/

function indirizzoEmailValido(indirizzo) {
	   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	   //var address = document.forms[form_id].elements[email].value;
	   if(reg.test(indirizzo) == false) {
	      return false;
	   }
	   else {
		   return true;
	   }
}
	
function controllaDati() {
		 if (! ControllaDate(document.myForm.dt_nascita_ric)) {
		 	document.mmyForm.dt_nascita_ric.select();
			alert("ATTENZIONE, data di nascita non valido");
			return false;
		 	}
		else
			return true;
		};



/*function controllaDati() {
		 if (! indirizzoEmailValido(document.miomodulo.email.value)) {
		 	document.miomodulo.email.select();
			alert("Sorry, indirizzo email non valido");
			return false;
		 	}
		else
			return true;
		};
*/

function checkAll(field)
{
var checks = document.getElementsByName(field);
for (i = 0; i < checks.length; i++)
	checks[i].checked = true ;
}

function uncheckAll(field)
{
	var checks = document.getElementsByName(field);
	for (i = 0; i < checks.length; i++)
		checks[i].checked = false ;
}

function copiaDati(FromField, ToField)
{
	var from = document.getElementById(FromField);
	var to = document.getElementById(ToField);
	to.value = from.value;
}

function eliminaDati(field)
{
	var delfrom = document.getElementById(field);
	delfrom.value = "";
}


function script_uguale_residenza()
{
	//alert(document.getElementById('uguale_residenza').checked);
	if (document.getElementById("uguale_residenza").checked == true) {
		//alert('ON')
		copiaDati("C_lg_comune_residenza", "C_lg_comune_impianto");
		copiaDati("C_cap", "C_cap_impianto");
		copiaDati("C_indirizzo", "C_indirizzo_impianto");
		copiaDati("C_nr_civico", "C_nr_civico_impianto");
		
		/*
		disabilita("cap_impianto");
		disabilita("lg_comune_impianto");
		disabilita("indirizzo_impianto");
		disabilita("nr_civico_impianto");
		*/
		
	}
	else {
		eliminaDati("C_cap_impianto");
		eliminaDati("C_lg_comune_impianto");
		eliminaDati("C_indirizzo_impianto");
		eliminaDati("C_nr_civico_impianto");
		
		/*
		abilita("cap_impianto");
		abilita("lg_comune_impianto");
		abilita("indirizzo_impianto");
		abilita("nr_civico_impianto");
		*/
	}
	
}


function controlla_e_submit() {
	var tutti = document.getElementsByTagName('INPUT');
	var espressione = /^C_dt\w*/;
	var espressione_data = /(\d{4})-(\d{2})-(\d{2})/;
	var pass = document.getElementById('P_password');
	var pass2 = document.getElementById('P2_password');
	var email = document.getElementById('C_email');
	var controllo = true;
	
	if ((email != null) && (indirizzoEmailValido(email.value) == false)) {
	 	alert("Indirizzo email non valido");
	 	controllo = false;
	}
	
	if ((pass != null) && (pass2 != null) && ((pass.value != pass2.value) || (pass.value == "") || (pass.value.length < 8))) {
		alert("I campi password sono diversi o vuoti o la password e' inferiore agli 8 caratteri");
		controllo = false;
	}
	for (i = 0; i < tutti.length; i++) 
	{
		if ((espressione.test(tutti[i].id)) && (!espressione_data.test(tutti[i].value))) {
			alert("Formato DATA non valido. Si prega di usare il calendario per completare il campo data: "+tutti[i].id);
			//alert("Attenzione Completare tutti i campi NECESSARI. Campo " + tutti[i].name + " Necessario." );
			tutti[i].focus();
			tutti[i].select();
			controllo = false;
			break;	
		}
		if (tutti[i].id=="C_"+tutti[i].name) {
			if (tutti[i].value=="") {
				alert("Attenzione Completare tutti i campi NECESSARI. Campo " + tutti[i].name + " Necessario." );
				//alert(tutti[i].id);
				tutti[i].focus();
				controllo = false;
				break;
			}	
			
		}
	}	
	if (controllo==true) {
		document.myForm.submit();
	}
		
	
}








// Title: Timestamp picker
// Description: See the demo at url
// URL: http://us.geocities.com/tspicker/
// Script featured on: http://javascriptkit.com/script/script2/timestamp.shtml
// Version: 1.0
// Date: 12-05-2001 (mm-dd-yyyy)
// Author: Denis Gritcyuk <denis@softcomplex.com>; <tspicker@yahoo.com>
// Notes: Permission given to use this script in any kind of applications if
//    header lines are left unchanged. Feel free to contact the author
//    for feature requests and/or donations

function show_calendar(str_target, str_datetime, str_percorso) {
	//var pippo = new Date("2007,05,18");
	//alert (pippo);
	//alert (pippo.getDate()); //nr giorno
	var str_percorso = "./";
	
	var arr_months = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
		"Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
	var week_days = ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa"];
	var n_weekstart = 1; // day week starts from (normally 0 or 1)

	//var dt_datetime = (str_datetime == null || str_datetime =="" ?  new Date() : str2dt(str_datetime));
	var dt_datetime
	if (str_datetime == null || str_datetime =="")
	{
		dt_datetime = new Date();
		dt_datetime.setFullYear(1960);
		dt_datetime.setMonth(0);		
		dt_datetime.setDate(1);
	}
	else 
	{
		  dt_datetime = str2dt(str_datetime);
	}
	//alert (dt_datetime);
	var dt_prev_month = new Date(dt_datetime);
	dt_prev_month.setMonth(dt_datetime.getMonth()-1);
	
	var dt_prev_year = new Date(dt_datetime);
	dt_prev_year.setYear(dt_datetime.getFullYear()-1);
	//alert (dt_prev_year);
	
	var dt_next_month = new Date(dt_datetime);
	dt_next_month.setMonth(dt_datetime.getMonth()+1);
	
	var dt_next_year = new Date(dt_datetime);
	dt_next_year.setYear(dt_datetime.getFullYear()+1);
	
	var dt_firstday = new Date(dt_datetime);
	dt_firstday.setDate(1);
	dt_firstday.setDate(1-(7+dt_firstday.getDay()-n_weekstart)%7);
	var dt_lastday = new Date(dt_next_month);
	dt_lastday.setDate(0);
	
	// html generation (feel free to tune it for your particular application)
	// print calendar header
	var str_buffer = new String (
		"<html>\n"+
		"<head>\n"+
		"	<title>Calendar</title>\n"+
		"</head>\n"+
		"<body bgcolor=\"White\">\n"+
		"<table class=\"clsOTable\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n"+
		"<tr><td bgcolor=\"#4682B4\">\n"+
		"<table cellspacing=\"1\" cellpadding=\"3\" border=\"0\" width=\"100%\">\n"+
		
		"<tr>\n	<td bgcolor=\"#4682B4\"><a href=\"javascript:window.opener.show_calendar('"+
		str_target+"', '"+ dt2dtstr(dt_prev_year)+"'+document.cal.time.value,'"+str_percorso+"');\">"+
		"<img src=\""+str_percorso+"grafica/images/prev.gif\" width=\"16\" height=\"16\" border=\"0\""+
		" alt=\"previous month\"></a></td>\n"+
		"	<td align=\"center\" bgcolor=\"#4682B4\" colspan=\"5\">"+
		"<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"
		+dt_datetime.getFullYear()+"</font></td>\n"+
		"	<td bgcolor=\"#4682B4\" align=\"right\"><a href=\"javascript:window.opener.show_calendar('"
		+str_target+"', '"+dt2dtstr(dt_next_year)+"'+document.cal.time.value,'"+str_percorso+"');\">"+
		"<img src=\""+str_percorso+"grafica/images/next.gif\" width=\"16\" height=\"16\" border=\"0\""+
		" alt=\"next month\"></a></td>\n</tr>\n"+
		
		
		"<tr>\n	<td bgcolor=\"#4682B4\"><a href=\"javascript:window.opener.show_calendar('"+
		str_target+"', '"+ dt2dtstr(dt_prev_month)+"'+document.cal.time.value,'"+str_percorso+"');\">"+
		"<img src=\""+str_percorso+"grafica/images/prev.gif\" width=\"16\" height=\"16\" border=\"0\""+
		" alt=\"previous month\"></a></td>\n"+
		"	<td align=\"center\" bgcolor=\"#4682B4\" colspan=\"5\">"+
		"<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"
		+arr_months[dt_datetime.getMonth()]+" </font></td>\n"+
		"	<td bgcolor=\"#4682B4\" align=\"right\"><a href=\"javascript:window.opener.show_calendar('"
		+str_target+"', '"+dt2dtstr(dt_next_month)+"'+document.cal.time.value,'"+str_percorso+"');\">"+
		"<img src=\""+str_percorso+"grafica/images/next.gif\" width=\"16\" height=\"16\" border=\"0\""+
		" alt=\"next month\"></a></td>\n</tr>\n"
	);

	var dt_current_day = new Date(dt_firstday);
	// print weekdays titles
	str_buffer += "<tr>\n";
	for (var n=0; n<7; n++)
		str_buffer += "	<td bgcolor=\"#87CEFA\">"+
		"<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"+
		week_days[(n_weekstart+n)%7]+"</font></td>\n";
	// print calendar table
	str_buffer += "</tr>\n";
	while (dt_current_day.getMonth() == dt_datetime.getMonth() ||
		dt_current_day.getMonth() == dt_firstday.getMonth()) {
		// print row heder
		str_buffer += "<tr>\n";
		for (var n_current_wday=0; n_current_wday<7; n_current_wday++) {
				if (dt_current_day.getDate() == dt_datetime.getDate() &&
					dt_current_day.getMonth() == dt_datetime.getMonth())
					// print current date
					str_buffer += "	<td bgcolor=\"#FFB6C1\" align=\"right\">";
				else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6)
					// weekend days
					str_buffer += "	<td bgcolor=\"#DBEAF5\" align=\"right\">";
				else
					// print working days of current month
					str_buffer += "	<td bgcolor=\"white\" align=\"right\">";

				if (dt_current_day.getMonth() == dt_datetime.getMonth())
					// print days of current month
					str_buffer += "<a href=\"javascript:window.opener."+str_target+
					".value='"+dt2dtstr(dt_current_day)+"'+document.cal.time.value; window.close();\">"+
					"<font color=\"black\" face=\"tahoma, verdana\" size=\"2\">";
				else
					// print days of other months
					str_buffer += "<a href=\"javascript:window.opener."+str_target+
					".value='"+dt2dtstr(dt_current_day)+"'+document.cal.time.value; window.close();\">"+
					"<font color=\"gray\" face=\"tahoma, verdana\" size=\"2\">";
				str_buffer += dt_current_day.getDate()+"</font></a></td>\n";
				dt_current_day.setDate(dt_current_day.getDate()+1);
		}
		// print row footer
		str_buffer += "</tr>\n";
	}
	// print calendar footer
	str_buffer +=
		"<form name=\"cal\">\n<tr><td colspan=\"7\" bgcolor=\"#87CEFA\">"+
		"<font color=\"White\" face=\"tahoma, verdana\" size=\"2\">"+
		"Time: <input type=\"text\" name=\"time\" value=\""+
		"\" size=\"8\" maxlength=\"8\"></font></td></tr>\n</form>\n" +
		"</table>\n" +
		"</tr>\n</td>\n</table>\n" +
		"</body>\n" +
		"</html>\n";

	var vWinCal = window.open("", "Calendar",
		"width=350,height=280,status=no,resizable=yes,top=200,left=200");
	vWinCal.opener = self;
	var calc_doc = vWinCal.document;
	calc_doc.write (str_buffer);
	calc_doc.close();
}
// datetime parsing and formatting routimes. modify them if you wish other datetime format
function str2dt (str_datetime) {
//alert (str_datetime);
	var re_date = /^(\d+)\-(\d+)\-(\d+)$/;
	if (!re_date.exec(str_datetime))
	{
		return alert("Invalid Datetime format: "+ str_datetime);
	}
	return (new Date (RegExp.$1, RegExp.$2-1, RegExp.$3));
}
function dt2dtstr (dt_datetime) {
	var m_tmp;
	var d_tmp;
	m_tmp = (dt_datetime.getMonth()+1);
	d_tmp = (dt_datetime.getDate());
	if (m_tmp <= 9) m_tmp="0"+m_tmp;
	if (d_tmp <= 9) d_tmp="0"+d_tmp;
	
	return (new String (
			dt_datetime.getFullYear()+"-"+(m_tmp)+"-"+d_tmp));
}
function dt2tmstr (dt_datetime) {
	return (new String (
			dt_datetime.getHours()+":"+dt_datetime.getMinutes()+":"+dt_datetime.getSeconds()));
}



function ostr2dt (str_datetime) {
	var re_date = /^(\d+)\-(\d+)\-(\d+)\s+(\d+)\:(\d+)\:(\d+)$/;
	if (!re_date.exec(str_datetime))
		return alert("Invalid Datetime format: "+ str_datetime);
	return (new Date (RegExp.$3, RegExp.$2-1, RegExp.$1, RegExp.$4, RegExp.$5, RegExp.$6));
}
function odt2dtstr (dt_datetime) {
	return (new String (
			dt_datetime.getDate()+"-"+(dt_datetime.getMonth()+1)+"-"+dt_datetime.getFullYear()+" "));
}
function odt2tmstr (dt_datetime) {
	return (new String (
			dt_datetime.getHours()+":"+dt_datetime.getMinutes()+":"+dt_datetime.getSeconds()));
}

// --------------------------------- FINE CALENDARIO -----------------------------





















/*
function checkAll(ref) {
  var chkAll = document.getElementById('checkAll');
  var checks = document.getElementsByName('del[]');
  var removeButton = document.getElementById('removeChecked');
  var boxLength = checks.length;
  var allChecked = false;
  var totalChecked = 0;
  if ( ref == 1 ) {
    if ( chkAll.checked == true ) {
      for ( i=0; i < boxLength; i++ ) {
        checks[i].checked = true;
      }
    }
    else {
      for ( i=0; i < boxLength; i++ ) {
        checks[i].checked = false;
      }
    }
  }
  else {
    for ( i=0; i < boxLength; i++ ) {
      if ( checks[i].checked == true ) {
        allChecked = true;
        continue;
      }
      else {
        allChecked = false;
        break;
      }
    }
    if ( allChecked == true ) {
      chkAll.checked = true;
    }
    else {
      chkAll.checked = false;
    }
  }
  for ( j=0; j < boxLength; j++ ) {
    if ( checks[j].checked == true ) {
      totalChecked++;
	}
  }
  removeButton.value = "Remove ["+totalChecked+"] Selected";
}
*/
