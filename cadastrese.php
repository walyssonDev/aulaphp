<?php
include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Cadastro usuarios</title>
    <style>
    body {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90vh;
        gap: 1em;
        padding-top: 3em;
    }

    form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
        align-items: center;
        background-color: #0a100d;
        padding: 2em 10em;
        border-radius: 1em;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    form h1 {
        margin: 0 0 .5em 0;
    }

    form input {
        margin-bottom: 1em;
        border-radius: 1em;
        border: none;
        padding: .5em;
    }

    form input[type="submit"] {
        background-color: #219ebc;
        color: white;
        width: 100%;
        margin-bottom: 0;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
    }

    form input[type="submit"]:hover {
        opacity: .7;
    }

    form a {
        color: white;
        margin-top: 1em;
    }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="cadastrar.php">
            <h1>Cadastrar</h1>
            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" placeholder="Seu nome: " required>
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf" placeholder="Seu CPF" required>
            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" placeholder="Sua senha" required>
            <input type="submit" value="Enviar">
            <input type="hidden" name="cadastro" value="cadastro">
            <a href="index.php">Login</a>
        </form>
    </div>
</body>

</html>