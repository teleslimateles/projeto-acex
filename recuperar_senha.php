<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recuperar Senha - Prefeitura de Santo André</title>
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
      max-width: 400px;
      width: 100%;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      text-align: center;
    }

    h2 {
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
      color: #007BFF;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Recuperar Senha</h2>
    <p>Informe seu email ou CPF para redefinir a senha.</p>
    <form action="processa_recuperacao.php" method="POST">
      <input type="text" name="cpf_email" placeholder="Email ou CPF" required />
      <button type="submit" class="btn">Enviar instruções</button>
    </form>
    <a href="index.html" class="link">Voltar para login</a>
  </div>
</body>
</html>