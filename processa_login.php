<?php
session_start();
require 'conexao.php'; // Conectar ao banco

if (isset($_POST['login_usuario'])) {
    // Sanitize e escape as variáveis para evitar SQL Injection
    $usuario = mysqli_real_escape_string($conexao, trim($_POST['usuario']));
    $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));

    // Consulta para buscar o usuário e a senha hashada no banco
    $sql = "SELECT * FROM login WHERE email = '$usuario' LIMIT 1";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Buscar os dados do usuário
        $usuarioDB = mysqli_fetch_assoc($resultado);
        
        // Verificar se a senha informada corresponde ao hash armazenado
        if (password_verify($senha, $usuarioDB['senha'])) {
            // Senha correta, criar a sessão
            $_SESSION['usuario'] = $usuarioDB['email'];
            header('Location: cadastro_creche.html');
            exit;
            
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
        exit;
    }
}
?>