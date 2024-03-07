<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';


// Función para limpiar y validar los datos
function limpiarDatos($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $nombre = limpiarDatos($_POST['introducir_nombre']);
    $email = limpiarDatos($_POST['introducir_email']);
    $telefono = limpiarDatos($_POST['introducir_telefono']);
    $asunto = limpiarDatos($_POST['introducir_asunto']);
    $mensaje = limpiarDatos($_POST['introducir_mensaje']);
    $destinatario = 'pruebas210797@gmail.com';

    // Validar el formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: error.php");
        exit();
    }

    // Validar los campos obligatorios
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        // Manejar el error, redirigir a una página de error
        header("Location: error.php");
        exit();
    }

    // Construir el mensaje completo
    $mensajeCompleto = "Nombre: " . htmlspecialchars($nombre) . "\n";
    $mensajeCompleto .= "Email: " . htmlspecialchars($email) . "\n";
    $mensajeCompleto .= "Teléfono: " . htmlspecialchars($telefono) . "\n";
    $mensajeCompleto .= "Asunto: " . htmlspecialchars($asunto) . "\n";
    $mensajeCompleto .= "Mensaje: " . htmlspecialchars($mensaje) . "\n";

    $mail = new PHPMailer(TRUE);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'pruebas210797@gmail.com';                     //SMTP username
        $mail->Password   = 'holamundo1234';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom($email, $nombre);
        $mail->addAddress($destinatario);
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = $mensajeCompleto;
    
        if ($mail->send()) {
            header("Location: index.html?msg=Correo enviado con éxito");
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
