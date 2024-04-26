<?php
  require_once("connect.php");
  session_start();
function invioMail($mail,$token){
  try{        
    $subject = 'noreply - Login a due fattori';
   $message = '
    <html>
    <head>
        <title>Codice di Autenticazione a Due Fattori</title>
    </head>
    <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

        <div style="background-color: #fff; border-radius: 10px; padding: 20px;">
            <h2 style="color: #333;">Codice di Autenticazione a Due Fattori</h2>
            <p>Grazie per utilizzare la nostra piattaforma. Di seguito trovi il tuo codice di autenticazione a due fattori:</p>
            <p style="font-size: 24px; font-weight: bold; color: #007bff;"><a href="https://quizwiz.altervista.org/areaUtente.php?'.$token.'">LINK</a></p>
            <p style="color: #666;">Questo codice scadrà dopo un breve periodo di tempo. Non condividerlo con nessuno.</p>
            <p>Se non hai richiesto questo codice, puoi ignorare questa email.</p>
        </div>

    </body>
    </html>
    ';

    $headers = "Content-type:text/html;charset=UTF-8\r\n";
    //'From: <quizzwizz.devs@gmail.com>'."\r\n";

    return mail($mail,$subject,$message,$headers);
  }catch(Exception $ex){
    header("Location: ../logIn.php?errore=".$ex->getMessage());
    exit();
  }	
}
function generaToken($mail,$password){
  $token = password_hash($mail.$password);
  return (uniqid().$token.uniqid());
}

	
function checkUtente(){
	//senza token non si può visualizzare la pagina e si torna al login
    require_once("php/connect.php");
    include_once("php/functions.php");
    session_start();
    

    try{
    	if(isset($_SESSION['utente'])){
        	if(isset($_GET['token'])){
                $sql = $pdo->prepare("SELECT * FROM utenti WHERE id=:id AND token=:tk AND tokenUsato=false");
                $sql->bindParam(":id",$_SESSION['utente'],PDO::PARAM_INT);
                $sql->bindParam(":tk",$_GET['token'],PDO::PARAM_STR);
                if($sql->execute()){
                    $row = $sql->fetch();
                    if(!empty($row)){
                        //Controllo il campo confermata
                        $sql = $pdo->prepare("UPDATE utenti SET tokenUsato=true WHERE id=:id");
                        $sql->bindParam(":id",$_SESSION['utente'],PDO::PARAM_INT);
                        return $sql->execute();
                    }else 
                        throw new Excpetion("Utente non valido");
                }
            }else
                throw new Exception("Non possiedi un Token per trovarti in questa pagina");
        }else
            throw new Exception("É necessario fare il login per accedere all'area personale");
    } catch(Exception $ex){
        
       	echo $ex->getMessage();
        session_destroy();
       	header("Location: logIn.php?errore/".$ex->getMessage());
       	die();
    }catch(PDOException $ex){
       	echo $ex->getMessage();
        session_destroy();
       	header("Location: logIn.php?errore/".$ex->getMessage());
       	die();
    }

} 
    