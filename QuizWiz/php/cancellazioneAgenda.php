 <?php
    require_once("connect.php");
    session_start();

    $id = $_POST['id'];

    try {
        $sql = $pdo->prepare("DELETE FROM agendaEventi WHERE id = :id AND fk_utente = :fk");
        $sql->bindParam(":id", $id, PDO::PARAM_INT);
        $sql->bindParam(":fk", $_SESSION['utente'], PDO::PARAM_INT);

        if ($sql->execute()) throw new Exception("Attività cancellata con successo!");
        else  throw new Exception("Qualcosa è andato storto, riprova");  
    } catch (PDOException $e){
        throw new Exception("Errore PDO durante l'eliminazione dell'attività: " . $e->getMessage()); // Cattura e stampa eventuali eccezioni PDO
        header("Location: ../agenda.php?errore=" . urlencode($ex->getMessage()));
        die();
    } 
?>