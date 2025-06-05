<?php
// Dados de conexão
$host = "ec2-3-131-141-8.us-east-2.compute.amazonaws.com";
$usuario = "root"; // altere se for diferente
$senha = "Senha@123"; // altere se houver senha no seu MySQL
$banco = "creche_santo_andre";

// Conecta ao banco
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];

// Prepara a query
$sql = "INSERT INTO endereços (cep, rua, numero, bairro) VALUES (?, ?, ?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $cep, $rua, $numero, $bairro);

// Executa e verifica se deu certo
if ($stmt->execute()) {
    // Redireciona para a página de login
    header("Location: index.html");
    exit(); // IMPORTANTE: para interromper o script após redirecionar
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>