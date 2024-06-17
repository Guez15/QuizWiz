<?php
	session_start();
	if(!isset($_SESSION['utente'])) {
        header("Location: logIn.php?errore=Impossibile+accedere+alla+risorsa+richiesta");
        exit;
    }
?>
<html>
<head>
    <title>QuizWiz - Note</title>
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/archiv.css">
    <link rel="stylesheet" href="css/communityNote.css">
    <link rel="stylesheet" href="css/logineregistrazione.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <?php include_once("htmlBlocks/menuVerticale.php");?>
        <div class="content">
            <form id="searchForm">
                <p>
                    <input type="text" name="persona" id="input" placeholder="Ricerca Note" style="padding:0px 12px"class="input" autocomplete="off"> 
                </p>
                <p class="ric">Ricerca in base a: <span id="tipo">Nome Utente</span></p>
            </form>
            <div id="filtroTipo">
				<label class="container">
                    <input checked="check" type="checkbox">
                    <div class="checkmark"></div>
                    <p>TXT</p>
                </label>
                <label class="container">
                    <input checked="check" type="checkbox">
                    <div class="checkmark"></div>
                    <p>PDF</p>
                </label>
            </div>
            <section class="users" id="results"></section>
        </div>
    </div>
    <script>
        let utente = true;
        let tipologia = document.getElementById("tipo");
        let input = document.getElementById("input");

		tipologia.onclick = function() {
            if (utente) {
                tipologia.innerHTML = "Materia";
                input.setAttribute("name", "materia");
            } else {
                tipologia.innerHTML = "Nome Utente";
                input.setAttribute("name", "persona");
            }
            utente = !utente;
        };

        $(document).ready(function(){
            $("#input").on("input", function(){
                let query = $(this).val();
                let type = utente ? "persona" : "materia";

                $.ajax({
                    url: "php/searchN.php",
                    method: "GET",
                    data: { [type]: query },
                    success: function(data) {
                        $("#results").html(data);
                    }
                });
            });
        });
        
       $(".container").each(function(){
          $(this).click(function(event){
          	  // Controlla se il target non è l'input
              if (event.target.nodeName !== 'INPUT') { 
                  var tipo = $(this).find("p").text();
                  if(tipo == "TXT"){
                  	$("[tipo]").each(function(){	
                       if($(this).attr('tipo') == "txt")
                       	$(this).toggle();
                    });
                  }else{
                  	$("[tipo]").each(function(){	
                       if($(this).attr('tipo') == "pdf")
                       	$(this).toggle();
                    });
                  }
              }
          });
      });

    </script>
</body>
</html>
