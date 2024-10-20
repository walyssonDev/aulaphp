        <?php
        include("../admin/conexao.php");
        include("../action/valida.php");

        ?>

        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Filmes</title>
            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link rel="stylesheet" href="../assets/filmes.css">
        </head>

        <body>
            <div class="interface">
                <?php
                $cpf = $_SESSION['cpf'];

                $sql = "SELECT * FROM filmes";
                $resultado = $conn->query($sql);

                while ($row = $resultado->fetch_assoc()) {
                    $id = $row['id'];

                    $sqlFav = "SELECT * FROM favoritos WHERE cpf = '$cpf' AND filme_id = '$id'";
                    $resultadoFav = $conn->query($sqlFav);
                    $isFav = $resultadoFav->fetch_assoc();

                    echo "<a href='assistir_filme.php?id=" . $id . "'>";
                    echo "
                    <article class='filme'>";
                    echo "
                    <div class='fav'>
                    <form method='post' action='../action/favoritar.php'>
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
                    </div>
                    </article>
                    ";
                    echo "</a>";
                }
                ?>
            </div>

        </body>

        </html>