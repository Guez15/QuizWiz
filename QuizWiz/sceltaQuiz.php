<?php 
	session_start();
    if(!isset($_SESSION['utente'])){
    	header("Location: logIn.php?errore=Impossibile+accedere+alla+risorsa+richiesta!+Effettuare+il+login");
        exit();
    }
?>
<html lang="it">
<head>
    <title>QuizWiz - Trova il Tuo Quiz</title>
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/sceltaQz.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="index.php"><div class="logo"></div></a>
            <div class="title">Trova il tuo Quiz</div>
        </div>
        <div class="main-content">
            <div class="carousel">
                <p>Non ti senti ancora pronto? Ripassa dalle tue note o da quelle degli altri utenti</p>
                <button class="arrow left" onclick="prevSlide()">&#9664;</button>
                <a href="note.php" target="_blank" class="fotoNote">
                    <img src="img/note.png" alt="Immagine 1" class="active">
                </a>
                <a href="archivio.php" target="_blank" class="fotoNote">
                    <img src="img/archivio.png" alt="Immagine 2">
                </a>
                <button class="arrow right" onclick="nextSlide()">&#9654;</button>
            </div>
            <div class="form-section">
                <form action="ripassoQuiz.php" method="POST">
                    <label for="topic">Argomento del Quiz:</label>
                    <input type="text" id="topic" name="topic" required>
                    
                    <label for="difficulty">Difficoltà:</label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="easy">Facile</option>
                        <option value="medium">Normale</option>
                        <option value="hard">Difficile</option>
                    </select>
                    
                    <button type="submit">AVVIA QUIZ</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel img');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        function prevSlide() {
            currentSlide = (currentSlide > 0) ? currentSlide - 1 : slides.length - 1;
            showSlide(currentSlide);
        }

        function nextSlide() {
            currentSlide = (currentSlide < slides.length - 1) ? currentSlide + 1 : 0;
            showSlide(currentSlide);
        }
    </script>
</body>
</html>
