<?php
	session_start();
	if(!isset($_SESSION['utente'])) {
        header("Location: logIn.php?errore=Impossibile+accedere+alla+risorsa+richiesta");
        exit;
    }
?>
<html>
    <head>
        <title>QuizWiz - Community</title>
        <link rel="stylesheet" href="css/colors.css">
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
                        <input type="text" name="persona" id="input" placeholder="Ricerca Note" class="input" autocomplete="off"> 
                    </p>
                    <p class="ric">Ricerca in base a: <span id="tipo">Nome Utente</span></p>
                </form>
                <section class="users" id="results"></section>
            </div>
            
        </div>
    </body>
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
                    url: "php/searchU.php",
                    method: "GET",
                    data: { [type]: query },
                    success: function(data) {
                        $("#results").html(data);
                    }
                });
            });
        });
    </script>
</html>
