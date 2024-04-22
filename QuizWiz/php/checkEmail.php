<?php
	require_once("connect.php");
   	session_start();
        
    //senza token non si può visualizzare la pagina e si viene mandati in quella di registrazione
    try{
    	if(isset($_SESSION['token'])){
       	//Controllo che siano stati passati i parametri nome,cognome,pass,email
           	if(array_key_exists('email',$_POST) && array_key_exists('pass',$_POST) && array_key_exists('nome',$_POST) && array_key_exists('cognome',$_POST)){
               	$nome = $_POST['nome'];
               	$cognome = $_POST['cognome'];
               	$passw = $_POST['pass'];
               	$email = $_POST['email'];
               }
          
       	    //Controllo il campo confermata
       	    $sql = $pdo->prepare("SELECT confermata FROM utenti WHERE email = :email");
       	    $sql->bindParam(':email', $email, PDO::PARAM_STR);
       	    $sql->execute();
      	    $controlla = $sql->fetchColumn(); 
       	    if ($controlla == 0) {
       		    //aggiorno il campo perché questo link proviene dall'email
          	    $updateSql = $pdo->prepare("UPDATE utenti SET confermata = 1 WHERE email = :email");
           	    $updateSql->bindParam(':email', $email, PDO::PARAM_STR);
           	    $updateSql->execute();
           	    header("Location: ..\logIn.php");
           	    exit();
            }
       	}
       	else
       		echo "Non possiedi un Token corretto per trovarti in questa pagina";
    } catch(Exception $ex){
       	echo $ex->getMessage()."<br>";
       	print_r($_POST);
       	//header("Location: ../logIn.php?errore/".$ex->getMessage());
       	die();
    }catch(PDOException $ex){
       	echo $ex->getMessage();
       	print_r($_POST);
       	//header("Location: ../logIn.php?errore/".$ex->getMessage());
       	die();
    }
?>