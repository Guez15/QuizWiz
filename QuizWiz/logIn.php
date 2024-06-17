<html>
    <head>
        <title>QuizWiz - LogIn</title>
        <link rel="stylesheet" href="css/logineregistrazione.css">
        <link rel="icon" href="img/logo.png" type="image/x-icon">
    	<link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    </head>
    <body id="log">
    	<div id="rettangolo">
        	<h1>LogIn</h1>
            <hr>
            <?php include_once("htmlBlocks/error.php");?>
            <br>
        	<form action="php/checkUtente.php" method="POST" autocomplete="off">
                <input type="email" name="email" placeholder="Email" class="input" id="email">
                <br><br>
               	<input type="password" name="pass" placeholder="Password" class="input" id="pass">
                <br><br>
            	<input type="submit" class="input">
            	<p>Non possiedi ancora le credenziali? <br> Allora <a href="signUp.php">registrati</a>!</p>
                <p style="font-size: 10px;"><a href="index.php">Torna indietro</a></p>
        	</form>
    	</div>
    </body>
</html>
