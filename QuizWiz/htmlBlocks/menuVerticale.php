<?php 
	require_once("php/connect.php");
    session_start();
    if(isset($_SESSION['utente'])){
    	$sql = $pdo->prepare("SELECT foto FROM utenti WHERE id=:d");
        $sql->bindParam(":d",$_SESSION['utente'],PDO::PARAM_INT);
        if($sql->execute()){
        	$row = $sql->fetch();
            $foto = $row[0];
        }
    }
    else
    	$foto = "img/areaUtente.png";
?>
<div id="menuVerticale">
    <div class="menu-items">
        <p>
            <a href="index.php"><img src="img/home.png" alt="home"></a>
        </p>
        <p>
            <a href="note.php"><img src="img/note.png" alt="note"></a>
        </p>
        <p>
            <a href="agenda.php"><img src="img/agenda.png" alt="agenda"></a>
        </p>
        <p>
            <a href="community.php"><img src="img/community.png" alt="community"></a>
        </p>
        <p>
            <a href="archivio.php"><img src="img/archivio.png" alt="archivio"></a>
        </p>
        <p>
            <a href="sceltaQuiz.php"><img src="img/sceltaQuiz.png" alt="sceltaQuiz"></a>
        </p>
    </div>
    <p>
        <a href="areaUtente.php"><img src=<?=$foto?> alt="utente"></a>
    </p>
</div>
