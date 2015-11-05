function onKeyNumeric(e) {
			// Accetto solo numeri e punto;
			if ( ((e.keyCode >= 46) && (e.keyCode <= 57)) || (e.keyCode == 8) || (e.keyCode == 190) ) {
				return true;
			} else {
				return false;
			}
		}
		
function onMail() {
			var privacy=document.forms["seleziona"].elements["info"].checked;
			var EmailAddr=document.forms["seleziona"].elements["Mail"].value;
			var Nome=document.forms["seleziona"].elements["Nome"].value;
			var Cognome=document.forms["seleziona"].elements["Cognome"].value;
		 	Filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
           
		   if (Nome==''){
		   alert('Nome non inserito');
		   document.forms["seleziona"].elements["Nome"].focus();
		   return false;
		   }
		   
		   if (Cognome==''){
		   alert('Cognome non inserito');
		   document.forms["seleziona"].elements["Cognome"].focus();
		   return false;
		   }
		   
		   if (privacy==false){
		   alert('accettare la privacy');
		   document.forms["seleziona"].elements["info"].focus();
		   return false;
		   }else { 
				if (EmailAddr.match(Filtro)){
					return true;
				}else
					{
						alert("Indirizzo Email non valido. Controllalo, per favore.");
						document.forms["seleziona"].elements["Mail"].focus();
						return false;
					}
		}
}	


function onMailsolo() {
		//	var privacy=document.forms["seleziona"].elements["info"].checked;
			var EmailAddr=document.forms["seleziona"].elements["Mail"].value;
		 	Filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
          	if (EmailAddr.match(Filtro)){
					return true;
				}else
					{
						alert("Indirizzo Email non valido. Controllalo, per favore.");
						document.forms["seleziona"].elements["Mail"].focus();
						return false;
					}
}	


function ShowLength(len){
alert('conta'+len);
//document.getElementById("MostraLunghezza").innerHT ML = "Maximum field lenght: 500, Characters entered: "+len;
}

function contacaratteri(a){
//alert ('ciao'+a);
var maxcar=150;
var b
document.getElementById("MostraLunghezza").innerHTML = "Caratteri utilizzati:  " +a;
b=a-maxcar;
if (b > 0 ){
//alert('superato il numero max di caratteri, i caratteri in eccesso non verranno memorizzati!');
document.getElementById("Tagliati").innerHTML = "Caratteri In eccesso:  " +b;
}else{
	document.getElementById("Tagliati").innerHTML = "Caratteri In eccesso:  0";
	}
}