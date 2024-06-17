<?php 
	session_start();
	if(isset($_SESSION['utente'])){
    	session_destroy();
        header("Location: ../logIn.php?errore=Logout+effettuato");
    }
    else
    	header("Location: ../logIn.php?errore=Operazione+fallita");