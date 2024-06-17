<?php
  require_once("connect.php");
  session_start();

  if(!isset($_SESSION['utente'])){
      header("Location: logIn.php?errore=Impossibile+accedere+a+questa+risorsa");
      exit();
  }

  if(array_key_exists('persona', $_GET) || array_key_exists('materia', $_GET)){
      if(array_key_exists('persona', $_GET)){
          $ricerca = "persona";
          $nome = explode(" ", trim($_GET['persona']));
          if(count($nome) == 1)
              $nome[1] = "";
          $nome[0] = strtolower($nome[0]);
          $nome[1] = strtolower($nome[1]);
          $sql = $pdo->prepare("SELECT n.nome nomeN,n.percorso,n.dimensione,u.nome,u.cognome,m.descrizione
                                FROM note n JOIN utenti u ON u.id=n.fk_utente
                                            JOIN materie m ON m.id=n.fk_materia
                                WHERE LOWER(u.nome) LIKE :nome OR LOWER(u.cognome) LIKE :co OR LOWER(u.cognome) LIKE :nome OR LOWER(u.nome) LIKE :co");
          $sql->bindParam(":nome", $nome[0], PDO::PARAM_STR);
          $sql->bindParam(":co", $nome[1], PDO::PARAM_STR);
      } else {
          $ricerca = "materia";
          $sql = $pdo->prepare("SELECT n.nome nomeN,n.percorso,n.dimensione,u.nome,u.cognome,m.descrizione
                                FROM note n JOIN utenti u ON u.id=n.fk_utente
                                            JOIN materie m ON m.id=n.fk_materia
                                WHERE m.descrizione=:descr");
          $sql->bindParam(":descr", strtolower($_GET['materia']), PDO::PARAM_STR);
      }
      if($sql->execute()){
          $rows = $sql->fetchAll();
          if(count($rows) > 0){
              $pannocchia = true;
          } else {
              $pannocchia = false;
          }
      }
  }

  if($ricerca == "materia" && !$pannocchia){
      echo "<h3>Nessuna nota trovata con la materia inserita.</h3>";
  } else if($ricerca == "persona" && !$pannocchia){
      echo "<h3>Nessuna nota trovata con l'utente inserito.</h3>";
  } else {
      foreach($rows as $row){
        $est = explode('.',$row['nomeN']);
        $est = strtolower($est[1]); ?>
        <div class="fileScaricato" tipo="<?=$est?>">                                   
            <img class="formatoImg" src="img/img<?=$est?>.png">                                   
            <p><b>Nome del file:</b> <?= htmlspecialchars($row['nomeN']) ?><br>
            <b>Dimensione:</b> <?= round(htmlspecialchars($row['dimensione'])/1000000,2) ?> MB<br>
            <b>Proprietario:</b> <?= htmlspecialchars($row['nome'] . ' ' . $row['cognome']) ?></p><br>
            <div class="styleBottoni">
                <button type="button" class="vis input2" data-filepath="<?= htmlspecialchars($row['percorso']) ?>">Visualizza</button>
                <button type="button" class="sca input2" data-filepath="<?= htmlspecialchars($row['percorso']) ?>">Scarica</button>
            </div>
        </div>
        <? 
      }
  }
