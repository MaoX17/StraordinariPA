var myRequest = null;

function CreateXmlHttpReq2(handler) {
  var xmlhttp = null;
  try {
    xmlhttp = new XMLHttpRequest();
  } catch(e) {
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch(e) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
  xmlhttp.onreadystatechange = handler;
  return xmlhttp;
}

function myHandler2() {
    if (myRequest.readyState == 4 && myRequest.status == 200) {
        e = document.getElementById("ex4result");
        e.innerHTML = myRequest.responseText;
    }
}

function esempio4() {
    var nome = document.f1.nome.value;
    var r = Math.random();
    myRequest = CreateXmlHttpReq(myHandler2);
    myRequest.open("GET","secondo.php?nome="+escape(nome)+"&rand="+escape(r));
    myRequest.send(null);
}

function completa_from_cap() {
    var nome = document.myForm.cap.value;
    var r = Math.random();
    myRequest = CreateXmlHttpReq(myHandler2);
    myRequest.open("GET","secondo.php?nome="+escape(nome)+"&rand="+escape(r));
    myRequest.send(null);
}
