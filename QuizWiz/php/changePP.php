<?php 
    require_once("connect.php");
    session_start();
    try{
        if(isset($_SESSION['utente'])){
            if($_GET["profilePic"]){
            	$foto = "../img/fotoProfilo/".$_GET['profilePic'].".png";
                $sql = $pdo->prepare("UPDATE utenti SET foto=:pp WHERE id=:idU");
                $sql->bindParam(":pp",$foto,PDO::PARAM_STR);
                $sql->bindParam(":idU",$_SESSION['utente'],PDO::PARAM_INT);
                if($sql->execute())
                    header("Location: ../areaUtente.php");
                else
                    throw new Exception("../areaUtente.php?errore=Impossibile aggiornare la foto profilo, riprovare");
            }
        }else
            throw new Exception("../login.php?errore=Impossibile accedere a questa risorsa");
    }catch(Exception $ex){
        echo $ex->getMessage();
        //header("Location: ".$ex->getMessage());
    }