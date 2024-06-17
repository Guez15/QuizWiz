<?php
    require_once("connect.php");
    require_once("arch.php");
    session_start();
    try{
        if(array_key_exists("utente",$_SESSION)){
            	$sql = $pdo->prepare("SELECT * FROM utenti WHERE id=:id");
                $sql->bindParam(":id",$_SESSION['utente'],PDO::PARAM_INT);
                if($sql->execute()){
                	$row = $sql->fetch();
                    if(!empty($row)){
                    	$nome = $row['nome'];
                    	$cognome = $row['cognome'];
                    	$email = $row['email'];
                    }
                    else
                    	throw new Exception("ERRORE AAAAAAAAA");
                }
            }
    	}catch(PDOException $ex){
    	echo $ex->getMessage();
    	header("Location: logIn.php?errore=".$ex->getMessage());
        die();
    }catch(Exception $ex){
    	echo $ex->getMessage();
    	header("Location: logIn.php?errore=".$ex->getMessage());
        die();
    }
?>