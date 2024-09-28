<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexao.php");
include("valida.php");

$nome = $_POST['nome'];
$path = $_POST['path'];
$filme = $_FILES['filme'];

if ($filme['error'] === UPLOAD_ERR_OK) {
    $filmeData = file_get_contents($filme['tmp_name']);
    $filmeData = mysqli_real_escape_string($conn, $filmeData);

    $sql = "INSERT INTO `filmes` (`id`, `nome`, `path`, `filme`, `data`) VALUES (NULL, '$nome', '$path', '$filmeData', current_timestamp());";
    $resultado = $conn->query($sql);

    if ($resultado) {
        $_SESSION['resposta'] = "Filme cadastrado com sucesso";
    } else {
        $_SESSION['resposta'] = "Erro ao cadastrar filme: " . $conn->error;
    }
} else {
    echo "Erro no upload: " . $filme['error'];
}

header("Location: cadastro_filme.php");
