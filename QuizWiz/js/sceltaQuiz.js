$(document).ready(function(){
	$("#note").hide();

	var descrizioni = {
    	"note": "Preparati al meglio rivisionando i tuoi appunti! \n\n\nSuccessivamente buttati e affronta il tuo quiz!",
		"archivio": "Quando gli appunti non bastano prova a cercarne altri dalla community! \n\nSuccessivamente buttati e affronta il tuo quiz!"
	};

	$("#dx, #sx").click(function(){
    	var immagineAttuale = $(this).attr("id") === "dx" ? "archivio" : "note";
        var descrizione = descrizioni[immagineAttuale]; 
        $(".descrizione").text(descrizione);
        	$("#note").toggle();
            $("#archivio").toggle();
        });
});
