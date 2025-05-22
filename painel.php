<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para o login se não estiver logado
    header("Location: index.html");
    exit(); // importante para parar o script após redirecionar
}

// Exibe mensagem de boas-vindas com o nome do usuário
echo "Bem-vindo, " . htmlspecialchars($_SESSION['usuario_nome']);
?>