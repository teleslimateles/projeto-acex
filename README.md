📘 Sistema de Cadastro de Creches
Este projeto é um sistema web simples com funcionalidades de cadastro de responsáveis, endereços, creches, login e recuperação de senha, com integração a banco de dados. O objetivo é facilitar o gerenciamento de cadastros relacionados a creches.

🗂️ Estrutura de Arquivos
Abaixo está a descrição dos principais arquivos do projeto e suas funções:

📄 Arquivos HTML/PHP
-index.html

     Página principal de login do sistema.

-cadastro.php

      Formulário de cadastro do pai ou responsável, utilizado na criação de uma nova conta.

-endereco.php

    -Tela complementar do cadastro onde o responsável informa seu endereço residencial.

-cadastro_creche.html

    -Página HTML que exibe o formulário para cadastrar uma nova creche.

-mapa.html

    Página com um mapa interativo, possivelmente para mostrar a localização das creches ou endereços cadastrados.

-recuperar_senha.php

    Tela para o usuário realizar a recuperação de senha, caso tenha esquecido.

⚙️ Processamento e Backend

-conexao.php

    Script de conexão com o banco de dados. Usado por outros arquivos PHP para realizar operações no banco (login, cadastro, etc.).

-processa_cadastro.php

    Arquivo responsável por receber os dados do formulário de cadastro do responsável e inseri-los no banco de dados.

-processa_endereco.php

    Script que processa o formulário de endereço do responsável e armazena os dados no banco de dados.

-processa_login.php

    Responsável por validar o login do usuário, verificando os dados no banco.

🎨 Estilo
- style.css
  
      Arquivo de estilos que define o layout visual de parte da aplicação.
