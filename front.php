<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa com Imagem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], input[type="email"], input[type="tel"], input[type="date"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .container {
            margin-bottom: 20px;
        }

        /* Botão de Voltar */
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

    <h1>Formulário de Cadastro com Imagem</h1>

    <form action="teste.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div class="container">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="container">
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required>
        </div>

        <div class="container">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
        </div>

        <div class="container">
            <label for="endereco">Endereço:</label>
            <textarea id="endereco" name="endereco" rows="4" required></textarea>
        </div>

        <div class="container">
            <label for="imagem">Escolha uma Imagem:</label>
            <input type="file" id="imagem" name="image" accept="image/*">
        </div>

        <div class="container">
            <input type="submit" value="Cadastrar">
        </div>
    </form>

    <a href="index.php" class="back-btn">Voltar para a Página Inicial</a>

</body>
</html>
