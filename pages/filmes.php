<?php
include("../handler/utils/conexao.php");
include("../handler/utils/valida.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/filmes.css?v=<?php echo time(); ?>">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VX1YBC3426"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-VX1YBC3426');
    </script>
</head>

<body>
    <?php include("../includes/header.php") ?>
    <div class="conteudo">
        <?php include("../includes/nav.php") ?>
        <div class="interface">
            <input type="search" name="busca" id="busca" placeholder="Buscar filme" oninput="buscarFilme()">
            <div class="filmes">
                <?php
                $cpf = $_SESSION['cpf'];

                $sql = "SELECT filmes.*, generos.genero AS nome_genero 
                        FROM filmes 
                        INNER JOIN generos
                        ON filmes.genero = generos.id";

                $resultado = $conn->query($sql);

                while ($row = $resultado->fetch_assoc()) {
                    $id = $row['id'];
                    $genero = $row['nome_genero'];

                    $sqlFav = "SELECT * FROM favoritos WHERE cpf = '$cpf' AND filme_id = '$id'";
                    $resultadoFav = $conn->query($sqlFav);
                    $isFav = $resultadoFav->fetch_assoc();

                    echo "<a href='assistir_filme.php?id=" . $id . "'>";
                    echo "
                    <article class='filme'>";
                    echo "
                    <div class='fav'>
                    <form method='post' action='../handler/filme/favoritar.php'>
                    <input type='hidden' name='id' value='" . $id . "'>
                    <button type='submit'>";
                    if ($isFav) {
                        echo "<i class='bi bi-star-fill'></i>";
                    } else {
                        echo "<i class='bi bi-star'></i>";
                    }
                    echo "</button>
                    </form>
                    </div>
                    ";
                    echo "
                    <img src='" . $row['path'] . "'>
                    <div class='txt-filme'>
                        <p>" . $row['nome'] . "</p>
                        <p id = 'genero-filme'>" . $genero . "</p>
                    </div>
                    </article>
                    ";
                    echo "</a>";
                }
                ?>
                <div class="space"></div>
            </div>
        </div>
    </div>
    <script>
    function buscarFilme() {
        const input = document.getElementById('busca').value.toLowerCase();
        const filmes = document.getElementsByClassName('filme');

        for (let i = 0; i < filmes.length; i++) {
            const nomeFilme = filmes[i].querySelector('.txt-filme p').textContent.toLowerCase();

            if (nomeFilme.includes(input)) {
                filmes[i].style.display = "";
            } else {
                filmes[i].style.display = "none";
            }
        }
    }
    </script>
</body>

</html>