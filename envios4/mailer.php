<?php
require_once '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Retrieve the form data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Build the email message
$message = "Nombre completo: " . $data['url'] . "\n";
$message .= "Teléfono: " . $data['telefono'] . "\n";
$message .= "Nombre de tu empresa: " . $data['empresa'] . "\n";
$message .= "Ciudad: " . $data['ciudad'] . "\n";
$message .= "Correo electrónico: " . $data['email'] . "\n";
$message .= "Opción seleccionada: " . $data['selectedOption'] . "\n";

// Instantiate a new PHPMailer object
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'desarrollowebodm@gmail.com';            // SMTP username
    $mail->Password   = 'dwjxplmpaluexeun';                      // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    // Recipients
    $mail->setFrom('desarrollowebodm@gmail.com', 'Desarrollo Web ODM');
    $mail->addAddress('mauriciodelgado1300@gmail.com', 'Miguel Delgado');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Nuevo cliente potencial';
    $mail->Body    = $message;

    $mail->send();
    echo json_encode(['message' => 'Correo enviado con éxito']);
} catch (Exception $e) {
    echo json_encode(['message' => 'No se pudo enviar el correo. Por favor intenta de nuevo.']);
}