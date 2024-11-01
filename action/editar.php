<?php
include("../admin/conexao.php");
include("valida.php");
include("../assets/validaForm.php");

$cpf = $_POST["cpf"];
$nome = $_POST["nome"];
$senha = $_POST["senha"];
$tipo = $_POST['tipo'];
$cpfAnterior = $_POST["cpfAnterior"];

$cpf = mascararCPF($cpf);
$resultado = validarForm($nome, $cpf, $senha);

if ($resultado === true) {
    $sql = "UPDATE usuarios SET cpf = ?, nome = ?, senha = ?, tipo = ? WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $cpf, $nome, $senha, $tipo, $cpfAnterior);
    $stmt->execute();

    $_SESSION['mensagem'] = "Editado com sucesso";
    header("Location: ../admin/edita.php");
} else {
    $_SESSION['mensagem'] = $resultado;
    header("Location: ../admin/edita.php");
}
