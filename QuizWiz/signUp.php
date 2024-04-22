<?php

?>
<html>
    <head>
        <title>QuizWiz - SignUp</title>        
    </head>
    <body>
        <form action="php/registraUtente.php" method="POST">
            <div>
                <input type="text" name="nome" id="nome" placeholder="Inserire un nome">
                <input type="text" name="cognome" id="cognome" placeholder="Inserire un cognome">
            </div>
            <input type="date" name="dataNascita" id="dataNascita">
            <div>
                <input type="email" name="email" id="email" placeholder="Inserie una mail">
                <input type="password" name="pass" id="pass" placeholder="Inserie una password">
                <input type="password" name="confermaPass" id="confermaPass" placeholder="Conferma password">
            </div>
            <input type="submit" name= "invio" value="invio">
            <p>Hai gi&agrave; un account? <a href="logIn.php">Accedi</a></p>
        </form>
    </body>
</html>