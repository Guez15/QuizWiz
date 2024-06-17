<?php
    include 'connect.php';
    session_start();

    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    try {
        // Prepara la query SQL
        $sql = $pdo->prepare("INSERT INTO agendaEventi (titolo, inizio, fine, fk_utente) VALUES (:tit, :sta, :e, :fk)");

        // Associa i parametri
        $sql->bindParam(":tit", $title, PDO::PARAM_STR);
        $sql->bindParam(":sta", $start, PDO::PARAM_STR);
        $sql->bindParam(":e", $end, PDO::PARAM_STR);
        $sql->bindParam(":fk", $_SESSION['utente'], PDO::PARAM_INT); // Assumo che $_SESSION['utente']['id'] contenga l'ID dell'utente

        // Esegue la query
        if ($sql->execute()) throw new Exception("Attività inserita con successo!");
        else throw new Exception("Errore durante l'inserimento dell'attività: " . $sql->errorInfo()[2]); //In caso di errore, stampa il messaggio di errore del PDO 
    } catch (PDOException $e){
        throw new Exception("Errore PDO durante l'inserimento dell'attività: " . $e->getMessage()); // Cattura e stampa eventuali eccezioni PDO
        header("Location: ../agenda.php?errore=" . urlencode($ex->getMessage()));
        die();
    } 
?>