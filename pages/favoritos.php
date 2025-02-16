<?php
include("../handler/utils/conexao.php");
include("../handler/utils/valida.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>
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
    <?php include("../includes/load.php") ?>
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
                        INNER JOIN favoritos ON filmes.id = favoritos.filme_id 
                        INNER JOIN generos ON filmes.genero = generos.id 
                        WHERE favoritos.cpf = '$cpf'";

                $resultado = $conn->query($sql);

                $filmesPorGenero = [];
                while ($row = $resultado->fetch_assoc()) {
                    $filmesPorGenero[$row['nome_genero']][] = $row;
                }

                if (empty($filmesPorGenero)) {
                    echo "Você não tem filmes favoritos!";
                } else {
                    foreach ($filmesPorGenero as $genero => $filmes) {
                        echo "<h2>$genero</h2>";
                        echo "<div class='filmes-por-genero'>";
                        foreach ($filmes as $row) {
                            $id = $row['id'];
                            echo "<a href='assistir_filme.php?id=" . $id . "'>";
                            echo "
                            <article class='filme'>
                                <div class='fav'>
                                    <form class='favoritarForm' method='post' action='../handler/filme/favoritar.php'>
                                        <input type='hidden' name='pgfav' value='favoritos'>
                                        <input type='hidden' name='id' value='" . $id . "'>
                                        <button type='submit' class='btn-favoritar'>
                                            <i class='bi bi-star-fill'></i>
                                        </button>
                                    </form>
                                </div>
                                <img src='" . $row['path'] . "'>
                                <div class='txt-filme'>
                                    <p>" . $row['nome'] . "</p>
                                    <p id='genero-filme'>" . $genero . "</p>
                                </div>
                            </article>
                            ";
                            echo "</a>";
                        }
                        echo "</div>";
                    }
                }
                ?>
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

    document.querySelectorAll('.favoritarForm').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const resposta = JSON.parse(xhr.responseText);
                    if (resposta.success) {
                        form.closest('.filme').remove();
                    } else {
                        alert(resposta.message);
                    }
                } else {
                    alert('Erro ao favoritar o filme');
                }
            };
            xhr.send(formData);
        });
    });
    </script>
</body>

</html>