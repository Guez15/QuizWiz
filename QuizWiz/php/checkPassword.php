<?php
    require_once("connect.php");
    session_start();
    try{
        if(isset($_SESSION["accesso"]) && isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['confermaPass'])){
            if($_POST['newPass'] == $_POST['confermaPass']){
                $sql = $pdo->prepare("SELECT pass FROM utenti WHERE id=:id");
                $sql->bindParam(":id",$_SESSION['accesso'],PDO::PARAM_INT);
                if($sql->execute()){
                    $row = $sql->fetch();
                    if(!empty($row)){
                        echo $_POST['oldPass'];
                        if(password_verify($_POST['oldPass'],$row['pass'])){
                            $pass = password_hash($_POST['newPass'],PASSWORD_DEFAULT);
                            $sql = $pdo->prepare('UPDATE utenti SET pass=:passw WHERE id=:id');
                            $sql->bindParam(':id',$_SESSION['accesso'],PDO::PARAM_STR);
                            $sql->bindParam(':passw',$pass,PDO::PARAM_STR);
                            if($sql->execute())
                                header("Location: ../areaUtente.php?mess=Password+cambiata+con+successo");
                            else
                                throw new Excpetion("ERRORE");
                        }
                        else
                            throw new Excpetion("La vecchia password è errata");
                    }
                    else
                        throw new Exception("Utente non esistente");
                }     
            }else
                throw new Exception("Le password devono coincidere");
        }else{
            throw new Exception("É necessario fare il login per cambiare la password");
        }
    }catch(Exception $ex) {
        echo $ex->getMessage();
        //header("Location: ../logIn.php?err=".$ex->getMessage());   
    }