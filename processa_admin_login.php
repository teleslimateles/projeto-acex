<?php
// Inicia a sessão
session_start();

// Usuário e senha fixos para demonstração
$usuario_correto = "admin";
$senha_correta = "123456";

// Recebe os dados do formulário
$usuario = $_POST['admin_user'] ?? '';
$senha = $_POST['admin_pass'] ?? '';

// Verifica se os dados estão corretos
if ($usuario === $usuario_correto && $senha === $senha_correta) {
    // Login bem-sucedido
    $_SESSION['admin_logado'] = true;
    $_SESSION['admin_user'] = $usuario;

    // Redireciona para a área restrita do admin
    header("Location: admin_dashboard.php");
    exit();
} else {
    // Login falhou
    $_SESSION['erro_login'] = "Usuário ou senha incorretos.";
    header("Location: admin_login.html");
    exit();
}
?>
