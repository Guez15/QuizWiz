<?php
	session_start();
    
	try{
    	if(array_key_exists("accesso",$_SESSION)){
          //Se l'accesso è stato effettuato la pagina può essere visualizzata
          if(!$_SESSION['accesso'])
          	throw new Exception("Accesso richiesto");
      	}else
          	throw new Exception("Accesso richiesto");
    }catch(Exception $ex){
    	header("Location: logIn.php");
        die();
    }
?>
<html>
<head>
	<title>QuizWiz - 2FA</title> 
</head>
<body>
	<p>ACCESSO A DUE FATTORI</p>
    <p>Per completare l'accesso &eacute; necessaria un'ultima operazione: </p>
	<p>Chiediamo gentilmente di controllare la casella di posta elettronica dell'email che si è scelto di usare e di cliccare sul link.</p>
    <p>Una volta completata quest'ultima procedura potrai accedere alla tua area personale.</p>
    <p><a href="index.php">Tornare indietro.</a></p>
</body>
</html>