<?php 
//Login
	require_once("connect.php");
    include_once("functions.php");
    session_start();

    try{
    	//Controllo che non ci sia una sessione attiva
    	if(!isset($_SESSION['accesso'])){
          //Controllo che siano stati passati i parametri email e pass
          if(array_key_exists('email',$_POST) && array_key_exists('pass',$_POST)){
              $email = $_POST['email'];
              $passw = $_POST['pass'];
              //Controllo che la mail inserita sia presente nel db
              $sql = $pdo->prepare("SELECT * FROM utenti WHERE email=:mail");
              $sql->bindParam(":mail",$email,PDO::PARAM_STR);
              if($sql->execute()){
                  //Se è presente, controllo che la password sia corretta
                  if($sql->rowCount() > 0){
                      $row = $sql->fetch();
                      //Confronto la password inserita con la password hashata nel database
                      if(password_verify($passw,$row["pass"])){
                          
                          
                          $token = generaToken($email,$passw);
                          $sql = $pdo->prepare("UPDATE utenti SET token=:tk WHERE id=:id");
                          $sql->bindParam(":tk",$token,PDO::PARAM_STR);
                          $sql->bindParam(":id",$row['id'],PDO::PARAM_INT);
                          if($sql->execute()){
                          	if(!invioMail($email,$token))
                            	throw new Exception("Errore nell'invio della mail");
                            else{
                            	$_SESSION['accesso'] = true;
                                $_SESSION['utente'] = $row['id'];
                            	header("Location: ../2FA.php");
							}
                            exit(); 
                          }	else
                            	throw new Excpetion("Invio mail fallito");
                        }else
                          throw new Exception("Password errata");
                  }
                  else
                      throw new Exception("Email non registrata");
              }
              else
                  throw new Exception("ERRORE: query non eseguita");
          }
          else
              throw new Exception("&Eacute necessario passare email e password");
		}else 
            throw new Exception("Sessione gia avviata");
    //Gestione errori
	}catch(Exception $ex){
        echo $ex->getMessage();
        header("Location: ../logIn.php?errore/".$ex->getMessage());
        die();
    }catch(PDOException $ex){
        echo $ex->getMessage();
        header("Location: ../logIn.php?errore/".$ex->getMessage());
        die();
    }