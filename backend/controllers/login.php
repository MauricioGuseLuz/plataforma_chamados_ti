<?php
session_start();
error_reporting(E_ALL); // Exibe todos os erros
ini_set('display_errors', 1); // Garante que os erros sejam exibidos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        include '../../backend/includes/db.php'; // Verifique esse caminho

        // Busca o usuário no banco de dados
        $stmt = $pdo->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>