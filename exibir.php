<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa com Imagem</title>
    <style>
        /* Definições gerais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            margin-top: 50px;
        }

        /* Container principal */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Estilo para o formulário */
        form {
            margin-top: 20px;
        }
        
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Bem-vindo ao Sistema</h1>

        <!-- Aqui você pode exibir os dados do banco -->
        <div id="dados">
            <p>Aqui estarão os dados do banco de dados</p>
            <!-- Código para exibir dados -->
        </div>

        <!-- Botão de Voltar -->
    </div>
        <a href="front.php" class="back-btn">Voltar para a Página Inicial</a>
</body>
</html>
