<?php
include("valida.php");
include("conexao.php");

verificarPermissao(['adm']);
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
        height: 80vh;
        gap: 1em;
        padding-top: 3em;
    }

    .img i {
        font-size: 60px;
    }

    .nome,
    .path,
    .file {
        background-color: #219ebc;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1em;
    }

    .nome i,
    .path i,
    .file i {
        margin: 0 1em;
    }

    form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
        align-items: center;
        background-color: #0a100d;
        padding: 4em;
        border-radius: 1em;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    form a {
        color: white;
        margin: 0;
    }

    form label {
        margin-top: 1em;
    }

    form h1 {
        margin: 0 0 .5em 0;
    }

    form input {
        border-radius: 0 1em 1em 0;
        border: none;
        padding: .5em;
    }

    form input[type="submit"] {
        background-color: #219ebc;
        color: white;
        width: 100%;
        margin: 1em 0;
        border-radius: 1em;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
    }

    form input[type="submit"]:hover {
        opacity: .7;
    }

    table {
        width: 50%;
        border-collapse: collapse;
        background-color: #f2f2f2;
    }

    table th,
    td {
        border: 1px solid black;
        text-align: center;
        overflow: hidden;
        padding: 1em;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="cadastrar_filme.php" enctype="multipart/form-data">
            <h1>Cadastrar Filme</h1>
            <div class="img">
                <i class="bi bi-card-checklist"></i>
            </div>
            <label for="nome">Nome: </label>
            <div class="nome">
                <i class="bi bi-pencil-square"></i>
                <input type="text" name="nome" id="nome" placeholder="Nome do filme: " required>
            </div>
            <label for="path">Path: </label>
            <div class="path">
                <i class="bi bi-card-image"></i>
                <input type="text" name="path" id="path" placeholder="Path da imagem: " required>
            </div>
            <label for="file">Arquivo: </label>
            <div class="file">
                <i class="bi bi-file-earmark-fill"></i>
                <input type="file" name="filme" accept=".mp4" required>
            </div>
            <input type="submit" value="Enviar">
        </form>
    </div>
    <script>
    <?php
        if (isset($_SESSION['resposta'])) {
            echo "alert('" . $_SESSION['resposta'] . "')";
            unset($_SESSION['resposta']);
        }
        ?>
    </script>
</body>

</html>