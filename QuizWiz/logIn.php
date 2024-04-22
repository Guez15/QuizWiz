<html>
    <head>
        <title>QuizWiz - LogIn</title>
        
    </head>
    <body>
        <form action="php/checkUtente.php" method="POST">
            <div>
                <input type="email" name="email" id="email">
                <input type="password" name="pass" id="pass">    
            </div>
            <input type="submit" value="invio">
            <p>Non hai un account? <a href="signUp.php">Registrati</a></p>
        </form>
    </body>
</html>