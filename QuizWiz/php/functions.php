<?php
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
            <p style="font-size: 24px; font-weight: bold; color: #007bff;"><a href="https://quizwiz.altervista.org/areaUtente.php?$token">LINK</a></p>
            <p style="color: #666;">Questo codice scadrà dopo un breve periodo di tempo. Non condividerlo con nessuno.</p>
            <p>Se non hai richiesto questo codice, puoi ignorare questa email.</p>
        </div>

    </body>
    </html>
    ';

    $headers = "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= 'From: quizwiz.devs@gmail.com'."\r\n";

    return mail($mail,$subject,$message,$headers);
  }catch(Exception $ex){
    header("Location: accesso.php?errore=".$ex->getMessage());
    exit();
  }	
}
function generaToken($mail,$password){
  $token = md5($mail.$password);
  return (uniqid().$token.uniqid());
}