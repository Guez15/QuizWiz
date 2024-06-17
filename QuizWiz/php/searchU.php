<?php
require_once("connect.php");
session_start();

if(!isset($_SESSION['utente'])){
    header("Location: logIn.php?errore=Impossibile+accedere+a+questa+risorsa");
    exit();
}

if(array_key_exists('persona', $_GET) || array_key_exists('materia', $_GET)){
    if(array_key_exists('persona', $_GET)){
        $ricerca = "persona";
        $nome = explode(" ", trim($_GET['persona']));
        if(count($nome) == 1) {
            $nome[1] = "";
        }
        
        $sql = $pdo->prepare("SELECT ut.id as fk_utente, ut.nome, ut.cognome, ut.foto 
                              FROM utenti ut 
                              WHERE ut.nome LIKE :nome OR ut.cognome LIKE :co OR ut.cognome LIKE :nome OR ut.nome LIKE :co");
        $sql->bindParam(":nome", $nome[0], PDO::PARAM_STR);
        $sql->bindParam(":co", $nome[1], PDO::PARAM_STR);
    } else {
        $ricerca = "materia";
        $sql = $pdo->prepare("SELECT DISTINCT(fk_utente), ut.nome, ut.cognome, ut.foto 
                              FROM studioMaterie sm 
                              JOIN utenti ut ON ut.id = sm.fk_utente
                              JOIN materie ma ON ma.id = sm.fk_materia 
                              WHERE ma.descrizione LIKE :mat");
        $sql->bindParam(":mat", $_GET['materia'], PDO::PARAM_STR);
    }
    if($sql->execute()){
        $rows = $sql->fetchAll();
        if(count($rows) > 0){
            $pannocchia = true;
        } else {
            $pannocchia = false;
        }
    }
}

if($ricerca == "materia" && !$pannocchia){
    echo "<h3>Nessun utente è specializzato nella materia inserita.</h3>";
} else if($ricerca == "persona" && !$pannocchia){
    echo "<h3>Nessun utente trovato con il nome inserito.</h3>";
} else {
    foreach($rows as $row){
        echo "<div class='card'>
                <p id='fotoProfilo'><img src='".$row['foto']."'></p>
                <div class='datiBase'>
                    <h3>".$row['nome']."</h3>
                    <h3>".$row['cognome']."</h3>
                </div>
                <p>Competenze di cui mi occupo: 
                    <ul>";
        // Estrazione di ogni materia per ogni singolo utente
        $sql = $pdo->prepare("SELECT ma.descrizione
                              FROM studioMaterie sm 
                              JOIN utenti ut ON ut.id = sm.fk_utente
                              JOIN materie ma ON ma.id = sm.fk_materia
                              WHERE fk_utente = :ut");
        $sql->bindParam(":ut", $row['fk_utente'], PDO::PARAM_INT);
        if($sql->execute()){
            $materie = $sql->fetchAll();
            foreach($materie as $materia){
                echo "<li>".$materia[0]."</li>";
            }
        }
        echo "</ul></p></div>";
    }
}
?>
