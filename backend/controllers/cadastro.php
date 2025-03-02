<?php
session_start();
include '../../backend/includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../lib/vendor/autoload.php';

// Recebe os dados do formulário
$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$whatsapp = $_POST['whatsapp'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];

// Verifica se as senhas coincidem
if ($senha !== $confirmar_senha) {
    echo json_encode(["status" => "error", "message" => "As senhas não correspondem."]);
    exit();
}

// Verifica se o usuário tem mais de 18 anos
$hoje = new DateTime();
$nascimento = new DateTime($data_nascimento);
$idade = $hoje->diff($nascimento)->y;

if ($idade < 18) {
    echo json_encode(["status" => "error", "message" => "Você deve ter mais de 18 anos para se cadastrar."]);
    exit();
}

// Verifica se o e-mail já está cadastrado
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "error", "message" => "Email já cadastrado."]);
    exit();
}

// Criptografa a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Gera um token único para validação de e-mail
$token_validacao = bin2hex(random_bytes(32)); // Token aleatório de 64 caracteres

// Insere o usuário no banco de dados com o token de validação
$stmt = $pdo->prepare("INSERT INTO usuarios (nome_completo, data_nascimento, email, telefone, whatsapp, senha, estado, cidade, token_validacao, validado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
if ($stmt->execute([$nome, $data_nascimento, $email, $telefone, $whatsapp, $senha_hash, $estado, $cidade, $token_validacao])) {
    // Resposta de sucesso (não espera o envio do e-mail)
    http_response_code(200); // Define o código de status HTTP como 200 (OK)
    echo json_encode(["status" => "success", "message" => "Cadastro realizado com sucesso! Verifique seu e-mail para validar sua conta."]);

    // Envia o e-mail em segundo plano
    enviarEmailValidacao($email, $nome, $token_validacao);
} else {
    // Resposta de erro
    http_response_code(500); // Define o código de status HTTP como 500 (Erro interno)
    echo json_encode(["status" => "error", "message" => "Erro ao cadastrar usuário."]);
    exit();
}

// Função para enviar o e-mail de validação em segundo plano
function enviarEmailValidacao($email, $nome, $token_validacao) {
    $mail = new PHPMailer(true);
    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.mailosaur.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hxpk9jw1@mailosaur.net';
        $mail->Password   = 'OULYYP1TXbR3rBTo85d3gkWTbSQZoBMX';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
        $mail->Port       = 587; // Porta para TLS

        // Configuração do e-mail
        $mail->setFrom('hxpk9jw1@mailosaur.net', 'Mauricio Guse');
        $mail->addAddress($email, $nome);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmação de Cadastro';
        $mail->Body    = "<h1>Olá, $nome!</h1>
                          <p>Seu cadastro foi realizado com sucesso.</p>
                          <p>Clique no link abaixo para validar seu e-mail:</p>
                          <a href='http://localhost/chamados_ti/backend/validar_email.php?token=$token_validacao'>Validar E-mail</a>
                          <br><br>";

        $mail->send(); // Envia o e-mail
    } catch (Exception $e) {
        // Log do erro (opcional)
        error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
    }
}
?>