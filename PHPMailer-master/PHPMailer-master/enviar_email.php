<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP do Gmail
    $mail->SMTPAuth   = true;             // Habilita autenticação SMTP
    $mail->Username   = 'soldadorasta23@gmail.com'; // Seu endereço de e-mail do Gmail
    $mail->Password   = '987';       // Sua senha do Gmail ou senha de aplicativo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita criptografia TLS
    $mail->Port       = 587;              // Porta SMTP para TLS

    // Remetente e destinatário
    $mail->setFrom('soldadorasta23@gmail.com', 'Mauricio guse da luz'); // Remetente
    $mail->addAddress('destinatario@example.com', 'Nome do Destinatário'); // Destinatário

    // Conteúdo do e-mail
    $mail->isHTML(true); // Define o formato do e-mail como HTML
    $mail->Subject = 'Assunto do E-mail'; // Assunto do e-mail
    $mail->Body    = 'Este é o corpo do e-mail em <b>HTML</b>'; // Corpo do e-mail

    // Envia o e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}