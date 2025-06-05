<?php
// Dados de conexão
$host = "ec2-3-131-141-8.us-east-2.compute.amazonaws.com";
$usuario = "root";
$senha = "Senha@123";
$banco = "creche_santo_andre";

// Conecta ao banco
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$nome = $_POST['nome'] ?? null;
$nome_responsavel = $_POST['nome_responsavel'] ?? null;
$cpf = $_POST['cpf'] ?? null;
$cpf_responsavel = $_POST['cpf_responsavel'] ?? null;
$rg = $_POST['rg'] ?? null;
$data_nascimento = $_POST['data_nascimento'] ?? null;
$genero = $_POST['genero'] ?? null;
$pcd = $_POST['pcd'] ?? null;

// Validação básica (você pode melhorar isso com regex e validação mais rigorosa)
if (!$nome || !$cpf || !$rg || !$data_nascimento || !$genero || !$pcd || !$nome_responsavel || !$cpf_responsavel) {
    die("Todos os campos obrigatórios devem ser preenchidos.");
}

// Prepara e executa o INSERT
$sql = "INSERT INTO crianca (nome, nome_responsavel, cpf, cpf_responsavel, rg, data_nascimento, genero, pcd)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $nome, $nome_responsavel, $cpf, $cpf_responsavel, $rg, $data_nascimento, $genero, $pcd);

if ($stmt->execute()) {
    // Redireciona após sucesso
    header("Location: endereco.html"); // Altere para a página que preferir
    exit();
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
