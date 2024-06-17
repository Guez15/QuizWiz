<?php
// Display PHP errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define a log file
$log_file = __DIR__ . '/error_log.txt';

// Function to log errors to the file
function log_to_file($message) {
    global $log_file;
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['topic']) || !isset($_POST['difficulty'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Parametri "argomento" o "difficoltà" mancanti'));
        exit;
    }

    $argomento = htmlspecialchars($_POST['topic']);
    $diff = htmlspecialchars($_POST['difficulty']);

    // Log received parameters
    log_to_file("Received topic: " . $argomento);
    log_to_file("Received difficulty: " . $diff);

    $api_key = 'sk-proj-16sTSp8rHELcG48z4Hv7T3BlbkFJDmXHQDRzLaWnswfAT4uP';
    $model = 'gpt-3.5-turbo';
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = array(
        'model' => $model,
        'messages' => array(
            array(
                'role' => 'system',
                'content' => 'You are a helpful assistant.'
            ),
            array(
                'role' => 'user',
                'content' => 'Domanda ' . $diff . ' su ' . $argomento . ' con 4 risposte, solo una corretta.'
            )
        ),
        'max_tokens' => 75,
        'temperature' => 0.5,
    );

    // Log the data to be sent to OpenAI
    log_to_file("Data to be sent: " . json_encode($data));

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        log_to_file("cURL Error: " . $error); // Log the error
        http_response_code(500);
        echo json_encode(array('error' => 'Errore durante la richiesta cURL: ' . $error));
        exit;
    }

    curl_close($ch);

    // Log the response from OpenAI
    log_to_file("Response from OpenAI: " . $response);

    $decoded_response = json_decode($response, true);

    if (isset($decoded_response['choices'][0]['message']['content'])) {
        $generatedText = $decoded_response['choices'][0]['message']['content'];
        $result = array('question' => $generatedText);
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        log_to_file("Invalid API response: " . $response); // Log the error
        http_response_code(500);
        echo json_encode(array('error' => 'Errore: risposta non valida da OpenAI'));
    }
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Metodo non consentito'));
}
?>
