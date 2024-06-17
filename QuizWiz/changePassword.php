<?php
    session_start();
    if(!isset($_SESSION['utente']))
        header("Location: logIn.php?errore=Per+accedere+a+questa+risorsa+è+necessario+fare+cambiare+password");
?>
<html>
    <head>
    	<title>QuizWiz - Cambio Password</title>
		<link rel="stylesheet" href="css/logineregistrazione.css">
        <link rel="icon" href="img/logo.png" type="image/x-icon">
    	<link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    </head>
    <body id="log">
    	
        <div id="rettangolo">
            <h1>Reset Password</h1>
            <hr>
            <?php include_once("htmlBlocks/error.php");?>
            <br>
            <form action="php/checkPassword.php" method="POST" autocomplete="off">
                <input type="password" class="input" id="oldPass" name="oldPass" placeholder="Vecchia Password"><br><br>
                <input type="password" class="input" id="newPass" name="newPass" placeholder="Nuova Password"><br><br>
                <input type="password" class="input" id="newPass" name="confermaPass" placeholder="Conferma Nuova Password"><br><br>

                <input type="submit" class="input" value="Conferma">
                <p style="font-size: 10px;"><a href="areaUtente.php">Torna indietro</a></p>
            </form>
        </div>
        
    </body>
</html>
