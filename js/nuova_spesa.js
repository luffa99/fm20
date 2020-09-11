window.onload = function () {  
  var d  = new Date();
  var YY = d.getFullYear();
  var MO = (d.getMonth())+1; // getMonth starts at 0
    if (MO < 10) {MO = '0'+MO;}
  var DD = d.getDate();
    if (DD < 10) {DD = '0'+DD;}
  var HH = d.getHours();
    if (HH < 10) {HH = '0'+HH;}
  var MM = d.getMinutes();
    if (MM < 10) {MM = '0'+MM;}
  
  var dataora = YY+"-"+MO+"-"+DD+"T"+HH+":"+MM;
    
  document.getElementById("dataora").defaultValue = dataora;
  
  var veradata = new Date(dataora);
  var euro  = new Date('2019-07-29T11:00');  // Strasburgo EUR
  var polo  = new Date('2019-08-08T19:00');  // Poznan PLN  
  var ungh  = new Date('2019-08-13T08:00');  // Budapest HUF  
  var prag  = new Date('2019-08-16T08:00');  // Praga CZK 
  var nori  = new Date('2019-08-18T13:00');  // Norimberga EUR  
  var zuri  = new Date('2019-08-19T20:00');  // Zurigo CHF
  
  if (veradata > zuri) {document.getElementById("valuta").value = "CHF";}
  else if (veradata > nori) {document.getElementById("valuta").value = "EUR";}
  else if (veradata > prag) {document.getElementById("valuta").value = "CZK";}
  else if (veradata > ungh) {document.getElementById("valuta").value = "HUF";}
  else if (veradata > polo) {document.getElementById("valuta").value = "PLN";}
  else if (veradata > euro) {document.getElementById("valuta").value = "EUR";}
  else {document.getElementById("valuta").value = "CHF";}
  
  var c_CHF = 1;
  var c_EUR = 0;
  var c_CZK = 0;
  var c_HUF = 0;
  var c_PLN = 0;
  
  var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var myObj = JSON.parse(this.responseText);
        c_EUR = 1/(myObj.rates.EUR);
        c_CZK = 1/(myObj.rates.CZK);
        c_HUF = 1/(myObj.rates.HUF);
        c_PLN = 1/(myObj.rates.PLN);
      }
    };
    xmlhttp.open("GET", "https://api.exchangeratesapi.io/latest?base=CHF", true);
    xmlhttp.send();
    
  document.getElementById("spesa_totale").oninput = function(){ 
    var valuta_locale = document.getElementById("valuta").value;
    var nome_cambio = 'c_'+valuta_locale;
    var cambio = eval(nome_cambio);
    var valore_totale = document.getElementById("spesa_totale").value;
    document.getElementById("spesa_totale_chf").value = (cambio*valore_totale).toFixed(2);
    document.getElementById("cambio").value = cambio.toFixed(10);
    conti();
  }
  document.getElementById("valuta").oninput = function(){ 
    var valuta_locale = document.getElementById("valuta").value;
    var nome_cambio = 'c_'+valuta_locale;
    var cambio = eval(nome_cambio);
    var valore_totale = document.getElementById("spesa_totale").value;
    document.getElementById("spesa_totale_chf").value = (cambio*valore_totale).toFixed(2);
    document.getElementById("cambio").value = cambio.toFixed(10);
  }
  
}

function conti() {
  var valore_totale = document.getElementById("spesa_totale").value; 
  var spese = document.getElementsByClassName("spese");
  var controllo = document.getElementById("controllo");
  var tot_somme = 0;
  for(var i = 0; i < spese.length; i++)
  {
    tot_somme = tot_somme + Number(spese[i].value);
  }
  
  var diff = valore_totale - tot_somme;
  if (valore_totale == tot_somme) {
    controllo.innerHTML = "<h4><span class='dot corretto'></span>Tutto ok</h4>";
  } else if (diff < 1 && diff > -1) {
     controllo.innerHTML = "<h4><span class='dot piccolo'></span>Piccolo errore ("+diff.toFixed(2)+")</h4>";
  } else {
     controllo.innerHTML = "<h4><span class='dot sbagliato'></span>Errore ("+diff.toFixed(2)+")</h4>";
  } 
}

function romana() {
  azzera();
  var valore_totale = document.getElementById("spesa_totale").value;
  if (valore_totale > 0) {
    var spese = document.getElementsByClassName("spese");
    var divisori = spese.length;
    var atesta = valore_totale/divisori;  
    for(var i = 0; i < divisori; i++)
    {
      spese[i].value = atesta.toFixed(2);
    }
    controllo.innerHTML = "<h4><span class='dot corretto'></span>Tutto ok (romana)</h4>";
  } else {
    alert("La spesa totale non può essere 0!");
  }
}

function romana_sei() {
  azzera();
  var valore_totale = document.getElementById("spesa_totale").value;
  if (valore_totale > 0) {
    var spese = document.getElementsByClassName("spese");
    var divisori = 7;
    var atesta = valore_totale/6;  
    for(var i = 0; i < divisori; i++)
    {
	  if (i != 5) {
      spese[i].value = atesta.toFixed(2);
	  }
	}
    controllo.innerHTML = "<h4><span class='dot corretto'></span>Tutto ok (romana)</h4>";
  } else {
    alert("La spesa totale non può essere 0!");
  }
}

function romana_cinque() {
  azzera();
  var valore_totale = document.getElementById("spesa_totale").value;
  if (valore_totale > 0) {
    var spese = document.getElementsByClassName("spese");
    var divisori = 7;
    var atesta = valore_totale/5;  
    for(var i = 0; i < divisori; i++)
    {
	  if (i != 5) {
		if (i != 2) {
    	  spese[i].value = atesta.toFixed(2);
	  	}
	  }
	}
    controllo.innerHTML = "<h4><span class='dot corretto'></span>Tutto ok (romana)</h4>";
  } else {
    alert("La spesa totale non può essere 0!");
  }
}

function azzera() {
  var spese = document.getElementsByClassName("spese");
  var divisori = spese.length;
  for(var i = 0; i < divisori; i++)
  {
      spese[i].value = '';
  }
  conti();
}