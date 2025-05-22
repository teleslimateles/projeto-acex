<?php
session_start();

// Dados de conexão
$host = "localhost";
$usuario= "root";
$senha = "Senha@123";
$banco = "creche_santo_andre";

// Conecta ao banco
$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

// Consulta no banco
$sql = "SELECT id, senha FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verifica a senha (criptografada ou simples)
    // Se usar hash: password_verify($senha, $row['senha'])
    if ($senha === $row['senha']) {
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['usuario_nome'] = $usuario;

        header("Location: painel.php");
        exit();
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}

$stmt->close();
$conn->close();
?>
