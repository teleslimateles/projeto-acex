<?php
session_start();

if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Painel do Administrador</title>
  <style>
    body {
      background-color: #f0f2f5;
      font-family: Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .dashboard {
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 500px;
      width: 100%;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 1rem;
    }

    p {
      font-size: 16px;
      margin-bottom: 2rem;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      margin: 10px auto;
      background-color: #86c5f0;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      text-decoration: none;
    }

    .btn:hover {
      background-color: #5caee4;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['admin_user']); ?>!</h1>
    <p>Você está logado no painel do administrador.</p>

    <!-- Botão para cadastro de creches -->
    <a href="cadastro_creche.html" class="btn">Cadastro de Creches</a>

    <!-- Botão de logout -->
    <a href="logout_admin.php" class="btn">Sair</a>
  </div>
</body>
</html>
