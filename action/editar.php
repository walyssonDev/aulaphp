<?php
include("../admin/conexao.php");
include("valida.php");

$cpf = $_POST["cpf"];
$nome = $_POST["nome"];
$senha = $_POST["senha"];
$cpfAnterior = $_POST["cpfAnterior"];

$sql = "UPDATE usuarios SET cpf = '$cpf', nome = '$nome', senha = '$senha' WHERE cpf = '$cpfAnterior'";

if (!$resultado = $conn->query($sql)) {
    die("erro");
} else {
    $_SESSION['mensagem'] = "Editado com sucesso";
    header("Location: ../admin/edita.php");
}