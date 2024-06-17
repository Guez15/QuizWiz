<?php
    require_once("php/connect.php");
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
                        $path = $row['foto'];
                    }
                    else
                    	throw new Exception("ERRORE AAAAAAAAA");
                }
    	}else{
        	if(array_key_exists("token",$_GET)){
                $sql = $pdo->prepare("SELECT * FROM utenti WHERE tokenUsato=false AND token=:tk");
                $sql->bindParam(":tk",$_GET['token'],PDO::PARAM_STR);
                if($sql->execute()){
                    $row = $sql->fetch();
                    if(!empty($row)){
                        $sql = $pdo->prepare("UPDATE utenti SET tokenUsato=true WHERE id=:id");
                        $sql->bindParam(":id",$row['id'],PDO::PARAM_INT);
                        if($sql->execute()){
                            $_SESSION['utente'] = $row['id'];
                            $nome = $row['nome'];
                            $cognome = $row['cognome'];
                            $email = $row['email'];
                            $path = $row['foto'];
                        }
                        else
                            throw new Exception("ERRORE".$pdo->errorInfo());
                    }
                    else
                        throw new Exception("Nessun utente trovato, riprovare");
                }
            }
            else
            	throw new Exception("É necessario confermare la propria identità via mail.");
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
<html>
    <head>
        <title>QuizWiz - Area Utente</title>
        <link rel="stylesheet" href="css/areaUtente.css">
        <link rel="stylesheet" href="css/colors.css">
        <link rel="stylesheet" href="css/logineregistrazione.css">
        <link rel="icon" href="img/logo.png" type="image/x-icon">
    	<link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <style>
        	/*!important si utilizza per annullare delle vecchie proprietà css e impostarne altre più importanti*/
            .custom-confirm-button {
                background-color: #B2DFFB !important;
            	font-weight: bold; 
                border-color: #A1CAF1 !important;
            }
   	 	</style>
    </head>
    <body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        if (isset($_GET['errore'])) {
            // Fare l'escape del messaggio di errore per evitare problemi di sicurezza
            $errore = htmlspecialchars($_GET['errore'], ENT_QUOTES, 'UTF-8');
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Qualcosa non va!',
                    text: '$errore',
                    icon: 'warning',
                    confirmButtonText: 'Chiudi',
                    customClass: {
                		confirmButton: 'custom-confirm-button'
            		}
                });
            });
            </script>";
        }
        if (isset($_GET['successo'])) {
            //Messaggio si successo
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'SUCCESSO!',
                    text: 'Materia inserita correttamente',
                    icon: 'success',
                    confirmButtonText: 'Chiudi',
                    customClass: {
                		confirmButton: 'custom-confirm-button'
            		}
                });
            });
            </script>";
        }
?>
        <div id='wrapper'>
            <?php include_once("htmlBlocks/menuVerticale.php");?>
            <div id='content'>
                <section class='benvenuto'>
                    <div id='fotoProfilo' style='background-image:url("<?=$path?>")'></div>
                    <h3>Benvenuto <?= $nome ?></h3>
                </section>
                <section class='datiPersonali'>
                    <div>
                        <div id='nome' class='dato'>
                            <p>Nome <span><?=$nome?></span></p>
                        </div>
                        <div id='cognome' class='dato'>
                            <p>Cognome <span><?=$cognome?></span></p>
                        </div>
                        <div id='email' class='dato'>
                            <p>Email <span><?=$email?></span></p>
                        </div>
                        <div id='password' class='dato'>
                            <p>Password <span>···············</span></p>
                            <p><a href="changePassword.php">Cambia Password</a></p>
                        </div>
                    </div>
                    <div id='materie'>
                        <?php 
                                $sql = $pdo->prepare("SELECT ma.descrizione FROM studioMaterie st JOIN materie ma ON ma.id=st.fk_materia WHERE st.fk_utente=:ut");
                                $sql->bindParam(":ut",$_SESSION['utente'],PDO::PARAM_STR);
                                if($sql->execute()){
                                    $rows = $sql->fetchAll();
                                    if(count($rows) < 1){
                                        ?>
                                        <p>Nessuna materia inserita</p>
                                        <p id='addMat'><b> + NUOVA MATERIA</b></p>
                                        <?php
                                    }else{
                                        ?>
                                        <ul>
                                            <?php 
                                                for($i=0;$i<count($rows);$i++)
                                                    echo "<li>".$rows[$i][0]."</li>";
                                            ?>
                                        </ul>
                                        <?php if(count($rows)!=4){?>
                                            <p id='addMat'><b> + NUOVA MATERIA</b></p>
                                        <?php }
                                    }
                                }
                            ?>
                            <form action="php/insertMateria.php" method="GET" id='insertMateria'>
                                <input type="text" name="materia" maxlength="100" autocomplete="off" class="input" required>
                                <input type="submit" value="INVIO" class="input">
                            </form>
                    </div>

                </section>
            </div>
            <a href="php/logout.php" class='logout'>
                <h4>LOG OUT</h4>
            </a>
            <form action="php/changePP.php" method="GET" id="changePP" class="popup">
                <?php 
                	echo "<p id='x'>X</p>";
                    $code = "";
                    for($i = 0; $i < 2; $i++){
                        $sex = ($i == 1) ? "M" : "F";
                        for($j = 1; $j < 4; $j++){
                            $code .= "<button type='submit' class='fotoPr' style='background-image:url(img/fotoProfilo/studente$j$sex.png)' name='profilePic' value='studente$j$sex'></button>";
                        }
                        $code.="<br>";
                    }
                    echo $code;
                ?>
            </form>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        window.onload = ()=>{
            $("#insertMateria").hide();
            $("#changePP").hide();
        }

        $("#addMat").click(function(){
            $("#insertMateria").fadeToggle();
        });
        
        $("#fotoProfilo").click(function(){
        	$("#changePP").show();
        });
        
        $("#x").click(function(){
        	$("#changePP").hide();
        });
    </script>
</html>
