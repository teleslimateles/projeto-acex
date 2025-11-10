<?php
define('HOST', '3.16.108.59'); // IP público da sua EC2
define('USUARIO', 'root');    // usuário que você criou no MySQL
define('SENHA', 'admin');  // senha definida para esse usuário
define('DB', 'creche_santo_andre');

$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB);

if ($conexao) {
    echo "Conexão realizada com sucesso!<br>";
    echo "Banco: " . DB . "<br>";
} else {
    echo "Erro na conexão: " . mysqli_connect_error();
}
?>
