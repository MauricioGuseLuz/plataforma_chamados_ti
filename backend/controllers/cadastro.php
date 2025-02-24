<?php
session_start();
include '../../backend/includes/db.php';

$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$whatsapp = $_POST['whatsapp'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];

// Verifica se o usuário tem mais de 18 anos
$hoje = new DateTime();
$nascimento = new DateTime($data_nascimento);
$idade = $hoje->diff($nascimento)->y;

if ($idade < 18) {
    die("Você deve ter mais de 18 anos para se cadastrar.");
}

// Verifica se o e-mail já está cadastrado
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    die("Este e-mail já está cadastrado.");
}

// Insere o usuário no banco de dados
$stmt = $pdo->prepare("INSERT INTO usuarios (nome_completo, data_nascimento, email, telefone, whatsapp, senha, estado, cidade) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$nome, $data_nascimento, $email, $telefone, $whatsapp, $senha, $estado, $cidade]);

echo "Cadastro realizado com sucesso!";
?>