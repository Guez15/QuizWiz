<?php 
//Registrazione

	require_once("connect.php");
    session_start();

    try{
    	if(!isset($_SESSION['accesso'])){
          //Controllo che siano stati passati i parametri nome,cognome,email,pass
            if(array_key_exists('email',$_POST) && array_key_exists('pass',$_POST) && array_key_exists('nome',$_POST) && array_key_exists('cognome',$_POST)){
                $nome = $_POST['nome'];
                $cognome = $_POST['cognome'];
                $email = $_POST['email'];
                $passw = $_POST['pass'];
                
                //Controllo che la mail inserita non sia già registrata
                $sql = $pdo->prepare("SELECT * FROM utenti WHERE email=:mail");
                $sql->bindParam(":mail",$email,PDO::PARAM_STR);
                if($sql->execute()){
                    if($sql->rowCount() > 0)
                        throw new Exception("Email già registrata");
                    else{
                        $sql = $pdo->prepare("INSERT INTO utenti (nome, cognome, dataNascita, email, pass) VALUES (:nome, :cognome, :dataNascita, :email, :pass)");
                        $sql->bindParam(":cognome",$cognome,PDO::PARAM_STR);
                        $sql->bindParam(":nome",$nome,PDO::PARAM_STR);
                        if(array_key_exists('dataNascita',$_POST))
                            $sql->bindParam(":dataNascita", $_POST["dataNascita"],PDO::PARAM_STR);
                        else $sql->bindParam(":dataNascita", null,PDO::PARAM_NULL);
                        $sql->bindParam(":email",$email,PDO::PARAM_STR);
                        $passw=password_hash($passw,PASSWORD_DEFAULT);
                        $sql->bindParam(":pass",$passw,PDO::PARAM_STR);
                        
                        
                        echo "<br>";
                        
                        if($sql->execute()){
                            //invioMail($email,$token);
                            header("Location: ../logIn.php");
                            die();
                        }else{
                            print_r($sql->errorInfo());
                            throw new Exception("Errore nella registrazione, riprovare");
                        }
                    }
                }else
                    throw new Exception("Email gi&aacute eseguito");
            }else
                throw new Exception("É necessario passare email e password");
		}
    //Gestione errori
	}catch(Exception $ex){
        echo $ex->getMessage()."<br>";
        print_r($_POST);
        header("Location: ../signUp.php?errore=".$ex->getMessage());
        die();
    }catch(PDOException $ex){
        echo $ex->getMessage();
        print_r($_POST);
        header("Location: ../signUp.php?errore=".$ex->getMessage());
        die();
    }
