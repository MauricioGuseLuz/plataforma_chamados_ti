<?php
session_start();
include '../../backend/includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado.");
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_incidente = $_POST['tipo_incidente'];
$descricao = $_POST['descricao'];

// Insere o chamado no banco de dados
$stmt = $pdo->prepare("INSERT INTO chamados (usuario_id, descricao, tipo_incidente) VALUES (?, ?, ?)");
$stmt->execute([$usuario_id, $descricao, $tipo_incidente]);
$chamado_id = $pdo->lastInsertId();

// Processa os anexos
if (!empty($_FILES['anexos']['name'][0])) {
    foreach ($_FILES['anexos']['tmp_name'] as $key => $tmp_name) {
        $arquivo_base64 = base64_encode(file_get_contents($tmp_name));
        $stmt = $pdo->prepare("INSERT INTO anexos (chamado_id, arquivo_base64) VALUES (?, ?)");
        $stmt->execute([$chamado_id, $arquivo_base64]);
    }
}

// Processa os contatos
if (!empty($_POST['contato_nome'])) {
    foreach ($_POST['contato_nome'] as $key => $nome) {
        $telefone = $_POST['contato_telefone'][$key];
        $observacao = $_POST['contato_observacao'][$key];
        $stmt = $pdo->prepare("INSERT INTO contatos_chamado (chamado_id, nome, telefone, observacao) VALUES (?, ?, ?, ?)");
        $stmt->execute([$chamado_id, $nome, $telefone, $observacao]);
    }
}

echo "Chamado aberto com sucesso!";
?>