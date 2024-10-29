<?php
include("../admin/conexao.php");

$cpf = $_POST["cpf"];

$sqlUsuario = ("DELETE FROM usuarios WHERE cpf = ?");
$stmt = $conn->prepare($sqlUsuario);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$stmt->close();

$sqlFavoritos = "DELETE FROM favoritos WHERE cpf = ?";
$stmt = $conn->prepare($sqlFavoritos);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$stmt->close();

$sqlComentarios = "DELETE FROM comentarios WHERE cpf = ?";
$stmt = $conn->prepare($sqlComentarios);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$stmt->close();

header("Location: ../admin/deleta.php");
