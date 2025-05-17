<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - Prefeitura de Santo André</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background: url('background.jpg') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(3px);
    }

    .container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      border-radius: 20px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .btn {
      background-color: #86c5f0;
      color: #000;
      padding: 10px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
    }

    .link {
      display: block;
      margin-top: 1rem;
      font-size: 12px;
      text-align: center;
      color: #007BFF;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Criar Conta</h2>
    <form action="processa_cadastro.php" method="POST">
      <input type="text" name="nome_completo" placeholder="Nome completo" required />
      <input type="text" name="cpf" placeholder="CPF" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="senha" placeholder="Senha" required />
      <button type="submit" class="btn">Cadastrar</button>
    </form>
    <a href="index.html" class="link">Já tem uma conta? Voltar ao login</a>
  </div>
</body>
</html>