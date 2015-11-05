var xmlHttp = getXmlHttpObject();

function loadList(tb, id1){
//alert('formCittaExec.php?table='+tb+'&id='+id1);
xmlHttp.open('GET', 'forms/formCittaExec.php?table='+tb+'&id='+id1, true);
xmlHttp.onreadystatechange = stateChanged;
xmlHttp.send(null);
}
function addOption(select, value, text) {
	//Aggiunge un elemento <option> ad una lista <select>
	var option = document.createElement("option");
	option.value = value,
	option.text = text;
	try {
		select.add(option, null);
	} catch(e) {
		//Per Internet Explorer
		select.add(option);
	}
}
function getSelected(select) {
	//Ritorna il valore dell'elemento <option> selezionato in una lista
	return select.options[select.selectedIndex].value;
	//return document.getElementById(select).options[document.getElementById(select).selectedIndex].value;
}
function stateChanged() {
	if(xmlHttp.readyState == 4) {
		//Stato OK
		if (xmlHttp.status == 200) {
			var resp = xmlHttp.responseText;
			
			if(resp) {
				//Le coppie di valori nella striga di risposta sono separate da ;
				var values = resp.split(';');
				//Il primo elemento è l'ID della lista.
				var listId = values.shift();
				var select = document.getElementById(listId);
				//Elimina i valori precedenti
				while (select.options.length) {
					select.remove(0);
				} 
				
				if(listId == 'regioni') {
					addOption (select, 0, '-- Selezionare regione --');
				}
				if(listId == 'province') {
					addOption (select, 0, '-- Selezionare Provincia --');
				}
				if(listId == 'comuni') {
					addOption (select, 0, '-- Selezionare Comune --');
				}
				var limit = values.length;
				
				for(i=0; i < limit; i++) {
					var pair = values[i].split('|');
					//aggiunge un elemento <option>
					addOption(select, pair[0], pair[1]);
				}
			}
		} else {
			alert(xmlHttp.responseText);
		}
	}
}

function getXmlHttpObject()
{
  var xmlHttp=null;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
  return xmlHttp;
}