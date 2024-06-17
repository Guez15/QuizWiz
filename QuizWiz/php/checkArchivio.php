<?php
    require_once("connect.php");
    session_start();

    try {
        if (isset($_POST['invia']) && $_POST['invia'] === "Invia") {
            $fileSalvato = $_FILES['fil']['tmp_name']; // File temporaneo
            $fileName = $_FILES['fil']['name'];
            $dimensione = $_FILES['fil']['size'];

            // Controllo estensione file
            $fileEstensione = pathinfo($fileName, PATHINFO_EXTENSION);
            if ($fileEstensione !== "txt" && $fileEstensione !== "pdf") throw new Exception("Il file deve essere di tipo TXT oppure PDF");

            // Recupera l'ID della materia corrispondente alla descrizione
            $materiaa = $_POST['materia'];
            $sql = $pdo->prepare("SELECT id FROM materie WHERE descrizione = :ma");
            $sql->bindParam(":ma", $materiaa, PDO::PARAM_STR);
            if ($sql->execute()) {
                $ricercaFk = $sql->fetch(PDO::FETCH_ASSOC);
                if (!$ricercaFk) throw new Exception("Materia non trovata nel database");
            } else throw new Exception("Errore nella ricerca della materia nel database");

            // Controllo duplicati nel database per lo stesso utente
            $sql = $pdo->prepare("SELECT nome FROM note WHERE nome = :nom AND fk_utente = :fk");
            $sql->bindParam(":nom", $fileName, PDO::PARAM_STR);
            $sql->bindParam(":fk", $_SESSION['utente'], PDO::PARAM_INT);
            if ($sql->execute()) {
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                if ($row) throw new Exception("Il file è già stato salvato");
            } else throw new Exception("Errore nel controllo dei duplicati nel database");

            // Directory di destinazione per il file caricato
            $percorso = "../fileSalvati/" . $fileName;
            
            // Sposta il file nella directory di destinazione
            if (!move_uploaded_file($fileSalvato, $percorso)) throw new Exception("Il file non è stato inserito nella memoria");

            // Inserimento della nota nel database
            $sql = $pdo->prepare("INSERT INTO note (nome, percorso, dimensione, fk_utente, fk_materia) VALUES (:nom, :pa, :dim, :fk, :fk2)");
            $sql->bindParam(":fk", $_SESSION['utente'], PDO::PARAM_INT);
            $sql->bindParam(":pa", $percorso, PDO::PARAM_STR);
            $sql->bindParam(":nom", $fileName, PDO::PARAM_STR);
            $sql->bindParam(":dim", $dimensione, PDO::PARAM_INT);
            $sql->bindParam(":fk2", $ricercaFk['id'], PDO::PARAM_INT);
            
            if ($sql->execute()) {
                header("Location: ../archivio.php");
                exit();
            } else throw new Exception("Salvataggio non effettuato nel database");
        } else throw new Exception("Azione di invio non riconosciuta");
    } catch (Exception $ex) {
        echo $ex->getMessage();
        header("Location: ../archivio.php?errore=" . urlencode($ex->getMessage()));
        die();
    }
?>