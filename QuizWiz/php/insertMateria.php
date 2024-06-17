<?php 
session_start();
require_once("connect.php");
if(isset($_SESSION['utente'])){
    try{
        if(isset($_GET['materia'])){
            //Cambio formattazione alla materia
            $mat = ucfirst(strtolower(trim($_GET['materia'])));
            //Controllo che il numero di materie "studiate" sia minore di 4
            $sql = $pdo->prepare("SELECT COUNT(*) num FROM studioMaterie WHERE fk_utente=:ut");
            $sql->bindParam(":ut",$_SESSION['utente'],PDO::PARAM_INT);
            if($sql->execute()){
                $row = $sql->fetch();
                if($row['num']<4){
                    //Controllo se la materia sia già presente nel DB
                    $sql = $pdo->prepare("SELECT * FROM materie WHERE descrizione=:mat");
                    $sql->bindParam(":mat",$mat,PDO::PARAM_STR);
                    if($sql->execute()){
                        $row = $sql->fetch();
                        if(empty($row)){
                            //Se no, allora la inserisco...
                            $sql = $pdo->prepare("INSERT INTO materie(descrizione) VALUES(:mat)");
                            $sql->bindParam(":mat",$mat,PDO::PARAM_STR);
                            //... e prendo l'id
                            if($sql->execute())
                                $idMat = $pdo->lastInsertedId();
                            else
                                throw new Exception("Errore nell'inserimento della materia");
                        }else{
                            $idMat = $row['id'];
                            //Se è già presente, controllo che l'utente non l'abbia già salvata tra quelle studiate
                            $sql = $pdo->prepare("SELECT * FROM studioMaterie st WHERE fk_utente=:ut AND fk_materia=:mat");
                            $sql->bindParam(":ut",$_SESSION['utente'],PDO::PARAM_INT);
                            $sql->bindParam(":mat",$idMat,PDO::PARAM_INT);
                            if($sql->execute()){
                                $row = $sql->fetch();
                                if(!empty($row))
                                    throw new Exception("Impossibile salvare una materia già salvata!");
                            }
                        }
                        //Inserisco nella tabella studio materie lo studente e la materia studiata
                        $sql = $pdo->prepare("INSERT INTO studioMaterie(fk_utente,fk_materia) VALUES(:ut,:mat)");
                        $sql->bindParam(":ut",$_SESSION['utente'],PDO::PARAM_INT);
                        $sql->bindParam(":mat",$idMat,PDO::PARAM_INT);
                        if($sql->execute()){
                            header("Location: ../areaUtente.php?successo=Materia salvata correttamente");
                            exit();
                        }else
                            throw new Exception("Errore nel salvataggio della materia! Riprovare");
                    }else
                        throw new Exception("Errore nella ricerca della materia inserita! Riprovare");
                }else 
                    throw new Exception("Numero massimo di materie inserite raggiunto");
            }else
                throw new Exception("Errore nella ricerca dell'utente! Riprovare");
        }else
            throw new Exception('Inserire una materia!');
    }catch(Exception $ex){
        header("Location: ../areaUtente.php?errore=".$ex->getMessage());
        exit();
    }
}else{
    header("Location: ../login.php?errore=Impossibile+alla+risorsa+richiesta!");
    exit();
}