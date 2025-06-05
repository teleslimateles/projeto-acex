<?php
session_start();

echo '<pre>';
print_r($_POST);
echo '</pre>';

// Verifica se os campos foram enviados
if (!isset($_POST['email']) || !isset($_POST['senha'])) {
    die("Erro: Campos de login não enviados.");
}

$email = $_POST['email'];
$senha_digitada = $_POST['senha'];

// Conexão com o banco
$host = "ec2-3-131-141-8.us-east-2.compute.amazonaws.com";
$usuario = "root";
$senha = "Senha@123";
$banco = "creche_santo_andre";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consulta usuário
$sql = "SELECT id, nome_completo, senha FROM responsavel WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($senha_digitada, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome_completo'] = $usuario['nome_completo'];
        header("Location: mapas.php");
        exit();
    } else {
        // Senha incorreta
            $_SESSION['mensagem'] = 'Senha incorreta.';
            header('Location: index.html');
            exit;
    }
} else {
    // Usuário não encontrado
        $_SESSION['mensagem'] = 'Usuário não encontrado.';
        header('Location: index.html');
}

$conn->close();
?>
