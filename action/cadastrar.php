<?php
include("../admin/conexao.php");
include("valida.php");

$cpf = $_POST["cpf"];
$nome = $_POST["nome"];
$senha = $_POST["senha"];

$nome = ucwords(strtolower($nome));

$sqlVerificar = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
$resultadoVerificar = $conn->query($sqlVerificar);

if ($resultadoVerificar->num_rows > 0) {
    echo "CPF ja cadastrado";
} else {
    $sql = ("INSERT INTO `usuarios` (`cpf`, `nome`, `senha`) VALUES ('$cpf', '$nome', '$senha')");
    $resultado = $conn->query($sql);

    $_SESSION['resposta'] = "Usuario cadastrado com sucesso";

    if ($_POST['cadastro'] == 'cadastro') {
        header("Location: ../index.php");
    } else {
        header("Location: ../admin/cadastro.php");
    }
}