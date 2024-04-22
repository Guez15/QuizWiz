<?php 
  try {
		$hostname="localhost";
		$dbname="my_quizwiz";
		$user="root";

		$pdo = new PDO("mysql:host=$localhost;dbname=$dbname", $user,"");
		
	// GESTIONE DELLE ECCEZIONI
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
		
	// CONTROLLO DEGLI ERRORI DI CONNESSIONE DOVUTI AI DATI DI AUTENTICAZIONE
	if(!$pdo) 
		echo ("Errore: username o password di connessione al DB errati!");
?>