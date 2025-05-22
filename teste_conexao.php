<?php
$conn = new mysqli("localhost", "root", "Senha@123", "creche_santo_andre");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

echo "Conexão bem-sucedida!";
?>