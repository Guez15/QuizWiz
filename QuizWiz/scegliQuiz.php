<?php
	require_once("php/connect.php");
    include_once("php/functions.php");
    session_start();
?>
<html>
<head>
	<title>QuizWiz - Quiz scelta argomento</title>
    <link rel="stylesheet" href="css/sceltaQuiz.css">
</head>
<style>
#box {
    height: 90%;
    width: 85%;
    background-color: grey; 
    position: absolute; 
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); 
    display: flex;
}
#scelta, #livello {
	width: 50%;
    text-align: center;
}
#scelta {
	display: flex;
    align-items: center;
}
#ricerca {
	padding: 1% 20%;
    margin: 20% 1%;
}
#pronti {
	margin-top: 20%;
	padding: 3%;
}
#immagini {
	background-image: url("img/imgScelta.png");
    background-position: -1px -117px;
    margin: 20% 50%;
    height: 120px;
	width: 120px;
}
#sposta {
    align-items: center;
    margin-left: 30%;
    /* display: flex; */
}
</style>
<body>
	<form action="php/ripassoQuiz.php" method="POST">
		<div id="box"> 
    		<div id="scelta">
				<div id="sposta">
                	<button type="button" id="sx"> ← </button>
        			<div id="immagini"> </div>
                	<button type="button" id="dx"> → </button>
                </div>
        	</div>
        	<div id="livello">
        		<input type="text" placeholder="Inserire argomento" id="ricerca">
                
            	<p>Difficoltà: </p>
            	<input type="radio" name="difficolta" value="Facile" id="f" checked>
				<label for="f">Facile</label><br>
				<input type="radio" name="difficolta" value="Normale" id="n">
				<label for="n">Normale</label><br>
				<input type="radio" name="difficolta" value="Difficile" id="d">
				<label for="d">Difficile</label><br>
          
                <input type="submit" name= "invio" id="pronti" value="Avvia il Quiz">
        	</div>
    	</div>
	</form>
    <script>
    	var x = -1;
    	var y = -117;
    	var massimodx = 330;

    	document.getElementById("sx").onclick = function() {
        	sposta(x - 101, y);
    	};

    	document.getElementById("dx").onclick = function() {
        	sposta(x + 101, y);
    	};
    
    	function sposta(xx, yy) {
        	if(xx > massimodx){
            	xx = massimodx;
            }
            
            x = xx;
        	y = yy;
        	document.getElementById("immagini").style.backgroundPosition = x + "px " + y + "px";
    	}
	</script>
</body>
</html>