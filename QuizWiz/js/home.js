const arg = ["Agenda","Area Utente","Community","Note","Archivio","Quiz"];
const text = ["Esplora la nostra accurata selezione di eventi, appuntamenti e attivit\u00E0, e preparati a vivere esperienze uniche e coinvolgenti!",
              "Gestisci con facilit\u00E0 tutte le tue informazioni personali e preferenze qui, assicurandoti la massima sicurezza e riservatezza dei tuoi dati.",
              "Trova altri membri della nostra comunit\u00E0 inserendo il loro nome o campo di interesse. Avvia una conversazione direttamente dalla piattaforma e connettiti istantaneamente con chi cerchi.",
              "Scopri una vasta gamma di appunti su svariati argomenti, pronti per essere integrati nel tuo percorso di apprendimento. Cerca il titolo dell'argomento di tuo interesse e accedi a una serie di note preparate dagli altri utenti.",
              "Accedi a un'ampia gamma di annotazioni precedentemente caricate, offrendoti uno spazio comodo per rivedere e organizzare il tuo lavoro.",
              "Scegli il tuo argomento di interesse e il livello di difficolt\u00E0 delle domande che ti verranno proposte. Mettiti alla prova rispondendo con attenzione e precisione, una domanda alla volta."
             ];
const links = ["agenda","areaUtente","community","note","archivio","sceltaQuiz"];
window.onload = ()=>{
  creaSezioni();
};

function creaSezioni(){
  let code = "";
  for(let i = 0;i<arg.length;i++){
      code += "<a href='"+links[i]+".php'><section id='sezione"+i+"'>\
      <div class='colSx' style='background-image:url(img/"+links[i]+".png)'></div>\
      <div class='colDx'><h3>"+arg[i]+"</h3><p>"+text[i]+"</p></div>\
      </section></a>";
	}
  $("#sections").append(code);
}
        
