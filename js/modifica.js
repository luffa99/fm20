window.onload = function () {  
    document.getElementById("spesa_totale").oninput = function(){ 
      var cambio = document.getElementById("cambio").value;
      var valore_totale = document.getElementById("spesa_totale").value;
      document.getElementById("spesa_totale_chf").value = (cambio*valore_totale).toFixed(2);
      conti();
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

function azzera() {
  var spese = document.getElementsByClassName("spese");
  var divisori = spese.length;
  for(var i = 0; i < divisori; i++)
  {
      spese[i].value = '';
  }
  conti();
}

function cancella(id){
   if (confirm('Sei sicuro di cancellare questa spesa? Tutti i dati (e i soldi) andranno persi.')) {
    window.open("x_cancella_spesa.php?id="+id,"_self")
  } else {
      // Do nothing!
  }
}