<?php
    require_once("php/connect.php");
    include_once("php/functions.php");
    session_start();
?>
<html>
    <head>
        <title>QuizWiz - Area Utente</title>
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/colors.css">
    </head>
    <body>
        <div id='wrapper'>
            <div id='menuVerticale'>
                <p>
                    <a href='index.php'><img src="imgs/home.png" alt="home"></a>
                </p>
                <p>
                    <a href='appunti.php'><img src="imgs/appunti.png" alt="appunti"></a>
                </p>
                <p>
                    <a href='agenda.php'><img src="imgs/agenda.png" alt="agenda"></a>
                </p>
                <p>
                    <a href='community.php'><img src="imgs/community.png" alt="community"></a>
                </p>
                <p>
                    <a href='archivio.php'><img src="imgs/archivio.png" alt="archivio"></a>
                </p>
                <p>
                    <a href='scegliQuiz.php'><img src="imgs/scegliQuiz.png" alt="scegliQuiz"></a>
                </p>

                <p>
                    <a href='areaUtente.php'><img src="imgs/utenteBase.png" alt="utente"></a>
                </p>
            </div>
            <div id='content'>
                <section class='benvenuto'>
                    <div id='fotoProfilo'></div>
                    <p>Benvenuto <?= $nome ?></p>
                </section>
                <section class='datiPersonali'>
                    <div>
                        <div id='nome'>
                            <p>Nome</p>
                            <p><?=$nome?></p>
                        </div>
                        <div id='cognome'>
                            <p>Cognome</p>
                            <p><?=$cognome?></p>
                        </div>
                        <div id='email'>
                            <p>Email</p>
                            <p><?=$mail?></p>
                        </div>
                        <div id='password'>
                            <p>Password</p>
                            <p>···············</p>
                            <p><a href="changePassw.php">Cambia Password</a></p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>