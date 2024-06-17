<html>
    <head>
        <title>QuizWiz - SignUp</title>
        <link rel="stylesheet" href="css/logineregistrazione.css">
        <link rel="icon" href="img/logo.png" type="image/x-icon">
    	<link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    </head>
    <body id="log">
        <div id="rettangolo2">
        	<h1>Registrazione</h1>
        	<hr>
            <?php include_once("htmlBlocks/error.php");?>
        	<br>
        	<form action="php/registraUtente.php" method="POST">
            	<input type="text" name="nome" id="nome" class="input" placeholder="Nome">
            	<input type="text" name="cognome" id="cognome" class="input" placeholder="Cognome">
                <br><br>
            	<input type="email" name="email" id="email" class="input" placeholder="Email">
                <input type="date" name="dataNascita" id="dataNascita" class="input">
            	<br><br>
                <input type="password" name="confermaPass" id="confermaPass" class="input" placeholder="Conferma password">
                <input type="password" name="pass" id="pass" class="input" placeholder="Password">
                <br><br>
                <input type="submit" name= "invio" value="invio" class="input">
            	<p>Hai già le credenziali? <br> Allora <a href="logIn.php">Accedi</a>!</p>
                <p style="font-size: 10px;"><a href="index.php">Torna indietro</a></p>
        	</form>
    	</div>
    </body>
</html>
