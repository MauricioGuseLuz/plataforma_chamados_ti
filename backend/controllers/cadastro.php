<?php
// Inclua o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Conectar ao banco de dados (supondo que você já tenha isso)
$conexao = new mysqli('localhost', 'usuario', 'senha', 'banco_de_dados');

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Processar o formulário de cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Inserir usuário no banco de dados (supondo que você já tenha isso)
    $sql = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";
    if ($conexao->query($sql) === TRUE) {
        // Enviar e-mail de boas-vindas
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'seuemail@gmail.com';
            $mail->Password   = 'suasenha';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Remetente e destinatário
            $mail->setFrom('seuemail@gmail.com', 'Nome do Sistema');
            $mail->addAddress($email, $nome);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Bem-vindo ao Nosso Sistema!';
            $mail->Body    = "Olá $nome,<br><br>Obrigado por se cadastrar no nosso sistema!<br><br>Atenciosamente,<br>Equipe do Sistema";

            // Envia o e-mail
            $mail->send();
            echo 'Cadastro realizado com sucesso! Um e-mail de boas-vindas foi enviado.';
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    } else {
        echo "Erro ao cadastrar usuário: " . $conexao->error;
    }
}