<?php
    require_once("connect.php");
    session_start();

    try {
        // Prepara la query SQL per selezionare gli eventi dell'utente corrente
        $sql = $pdo->prepare("SELECT * FROM agendaEventi WHERE fk_utente = :fk");
        $sql->bindParam(":fk", $_SESSION['utente'], PDO::PARAM_INT); 
        if ($sql->execute()) {
            $events = array(); // Inizializza un array vuoto per salvare gli eventi
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $events[] = array(
                    'id' => $row['id'],
                    'title' => $row['titolo'],
                    'start' => $row['inizio'],
                    'end' => $row['fine'],
                    'fkute' => $row['fk_utente']
                );
            }

            //Conversione dell'array degli eventi in formato JSON 
            echo json_encode($events);
        } else throw new Exception(json_encode(array('error' => 'Errore nella query SQL')));
    } catch (PDOException $e){
        throw new Exception("Errore PDO durante il caricamento: " . $e->getMessage()); // Cattura e stampa eventuali eccezioni PDO
        header("Location: ../agenda.php?errore=" . urlencode($ex->getMessage()));
        die();
    } 
?>