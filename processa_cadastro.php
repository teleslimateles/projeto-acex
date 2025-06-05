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
$nome = $_POST['nome_completo'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // senha criptografada

// Prepara a query
$sql = "INSERT INTO responsavel (nome_completo, cpf, email, senha) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $cpf, $email, $senha);

//Supondo que o cadastro foi bem-sucedido:
if ($stmt->execute()) {
    // Redireciona para a págia de sucesso 
    header("Location: cadastro_crianca.html");
    exit();  // Sempre usar o exit() apóis o header()
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}
