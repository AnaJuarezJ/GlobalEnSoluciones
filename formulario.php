<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

function limpiarDatos($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = limpiarDatos($_POST['introducir_nombre']);
    $email = limpiarDatos($_POST['introducir_email']);
    $telefono = limpiarDatos($_POST['introducir_telefono']);
    $asunto = limpiarDatos($_POST['introducir_asunto']);
    $mensaje = limpiarDatos($_POST['introducir_mensaje']);
    $destinatario = 'pruebas210797@gmail.com';


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: error.php?msg=Correo electrónico no válido");
        exit();
    }

    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        header("Location: error.php?msg=Todos los campos son obligatorios");
        exit();
    }

    $mensajeCompleto = "Nombre: $nombre\nEmail: $email\nTeléfono: $telefono\nAsunto: $asunto\nMensaje: $mensaje\n";

    $mail = new PHPMailer(TRUE);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'prueba210797@gmail.com';
        $mail->Password   = 'holamundo1234';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
    
        $mail->setFrom($email, $nombre);
        $mail->addAddress($destinatario);
    
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = $mensajeCompleto;
    
        if ($mail->send()) {
            header("Location: ruesga.php?msg=Correo enviado con éxito");
            exit();
        } else {
            header("Location: error.php?msg=Error al enviar el mensaje: " . $mail->ErrorInfo);
            exit();
        }
    } catch (Exception $e) {
        header("Location: error.php?msg=Error inesperado: " . $e->getMessage());
        exit();
    }
}
?>
