<?php
  require_once("php/connect.php");
  session_start();

  // Verifica se l'utente è autenticato
  if (!isset($_SESSION['utente'])) {
      header("Location: logIn.php?errore=Impossibile+accedere+alla+risorsa+richiesta");
      exit;
  }
?>
<html>
<head>
    <title>QuizWiz - Agenda</title>
    <link rel="stylesheet" href="css/colors.css">
    <link rel="stylesheet" href="css/agenda.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <!-- Carica il foglio di stile per FullCalendar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <!-- Carica jQuery, necessario per FullCalendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Carica Moment.js, libreria per la gestione delle date e degli orari -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Carica FullCalendar, la libreria per il calendario -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <!-- Carica il file di traduzione in italiano per FullCalendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/it.min.js"></script>
    <!-- Carica SweetAlert2 per alert personalizzati -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        <?php include_once("htmlBlocks/menuVerticale.php"); ?>
        <div id="calendar"></div>
        <?php include_once("htmlBlocks/error.php"); ?>
    </div>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                events: 'php/caricamentoAgenda.php', //Pagina caricamento attività esistenti
                selectable: true,
                select: function(start, end) { //Si attiva quando l'utente seleziona un giorno
                    Swal.fire({
                        title: 'Inserire il titolo dell\'attività:',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Salva',
                        cancelButtonText: 'Annulla',
                        customClass: {
                            confirmButton: 'btn btn-success custom-confirm-button',
                            cancelButton: 'btn btn-danger custom-confirm-button'
                        },
                        showLoaderOnConfirm: true,
                        preConfirm: (inputValue) => {
                            if (!inputValue) {
                                Swal.showValidationMessage('Il titolo non può essere vuoto');
                            }
                            return inputValue;
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var title = result.value;
                            console.log("Inserire il titolo dell'attività:", title); // Debug per verificare il titolo

                            // Inserimento dell'evento solo se è stato inserito un titolo
                            if (title) {
                                var eventData = {
                                    title: title,
                                    start: start.format('YYYY-MM-DD'), // Utilizza solo la data senza orario
                                    end: end.format('YYYY-MM-DD') // Utilizza solo la data senza orario
                                };
                                $.ajax({
                                    url: 'php/inserimentoAgenda.php', //Pagina inserimento attività
                                    type: 'POST',
                                    data: eventData,
                                    success: function(response) {
                                        //alert(response); 
                                        $('#calendar').fullCalendar('refetchEvents');
                                    },
                                    /*error: function(xhr, status, error) {
                                        alert('Errore AJAX: ' + error);
                                    }*/
                                });
                            }
                        }
                    });
                },
                eventClick: function(event) { //Si attiva quando l'utente seleziona un'attività
                    Swal.fire({
                        title: "Vuoi rimuovere questa attività?",
                        text: " ",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Annulla",
                        confirmButtonText: "Elimina",
                        customClass: {
                            cancelButton: 'btn btn-danger custom-confirm-button',
                            confirmButton: 'btn btn-success custom-confirm-button'
                        },
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'php/cancellazioneAgenda.php',
                                type: 'POST',
                                data: { id: event.id },
                                success: function() {
                                    $('#calendar').fullCalendar('removeEvents', event._id);
                                    Swal.fire({
                                        title: "L'attività è stata eliminata",
                                        text: " ",
                                        icon: "success",
                                        customClass: {
                                            confirmButton: 'btn btn-success custom-confirm-button'
                                        }
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        title: "Errore",
                                        text: "Si è verificato un errore durante la cancellazione, riprovare",
                                        icon: "error",
                                        customClass: {
                                            confirmButton: 'btn btn-success custom-confirm-button'
                                        }
                                    });
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: "Non sono state apportate modifiche",
                                text: " ",
                                icon: "info",
                                customClass: {
                                    confirmButton: 'btn btn-success custom-confirm-button'
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
