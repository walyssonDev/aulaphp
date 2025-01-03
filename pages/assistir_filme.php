<?php
include("../handler/utils/conexao.php");
include("../handler/utils/valida.php");

$id = $_GET['id'];

$sql = "SELECT * FROM filmes WHERE id = '$id'";
$resultado = $conn->query($sql);

while ($row = $resultado->fetch_assoc()) {
    $link = $row['filme'];
    $nomeFilme = $row['nome'];
}

$link_limpo = parse_url($link, PHP_URL_PATH);
$extensao = pathinfo($link_limpo, PATHINFO_EXTENSION);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <title><?php echo $nomeFilme ?></title>
    <link rel="stylesheet" href="../assets/css/assistir_filme.css?v=<?php echo time(); ?>">
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
            <div class="filme">
                <?php
                if (strpos($link, 'dropbox.com') !== false) {
                    echo "
                <video id='video' controls autoplay>
                <source type='video/mp4' src='" . $link . "'>
            </video>";
                } else if (strpos($link, 'drive.google.com') !== false) {
                    echo "
            <iframe src='$link' allowfullscreen></iframe>";
                }
                ?>
                <h1><?php echo $nomeFilme ?></h1>
            </div>

            <div class="container">
                <div class="comentarios">
                    <?php
                    $sql = "SELECT * FROM comentarios WHERE filme_id = $id ORDER BY id";
                    $resultado = $conn->query($sql);
                    while ($row = $resultado->fetch_assoc()) {
                        $cpfComentario = $row['cpf'];
                        $comentario = $row['comentario'];

                        $sqlComentario = "SELECT nome, img FROM usuarios WHERE cpf = ? ";
                        $stmt = $conn->prepare($sqlComentario);
                        $stmt->bind_param("s", $cpfComentario);
                        $stmt->execute();
                        $stmt->bind_result($nome, $imgData);
                        $stmt->fetch();
                        $stmt->close();

                        if (empty($nome)) {
                            $nome = "Usuario Deletado";
                        }

                        if (!empty($imgData)) {
                            $imgSrc = 'data:image/jpeg;base64,' . base64_encode($imgData);
                            $img = "<img src='$imgSrc' alt='Imagem de $nome' class='perfil-imagem' loading='lazy'>";
                        } else {
                            $img = "<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40' fill='#ffffff' class='perfil-imagem' viewBox='0 0 32 32'>
                                    <path d='M22 12a6 6 0 1 1-12 0 6 6 0 0 1 12 0'/>
                                    <path fill-rule='evenodd' d='M0 16a16 16 0 1 1 32 0A16 16 0 0 1 0 16m16-14a14 14 0 0 0-10.937 22.74C6.484 22.452 9.61 20 16 20s9.516 2.452 10.937 4.74A14 14 0 0 0 16 2'/>
                                </svg>";
                        }

                        if ($_SESSION['tipo'] == "adm") {

                            if ($nome == "ADM" || $nome == "Adm") {
                                echo "
                        <div class='commentADM'>
                        <div class='txt'>
                        $img
                        <p class='nome'>" . $nome . ": </p>
                        <p>" . $comentario . "</p>
                        </div>
                        <form id='deletar' action='../handler/comentario/deletarComentario.php?id=$id' method='post'>
                        <input type='hidden' name='comentario' id='comentario' value='$comentario'>
                        <input type='hidden' name='cpfUser' id='cpfUser' value='$cpfComentario'>
                        <input type='submit' value='Deletar'>
                        </form>
                        </div>
                        ";
                            } else {
                                echo "
                        <div class='comment'>
                        <div class='txt'>
                        $img
                        <p class='nome'>" . $nome . ": </p>
                        <p>" . $comentario . "</p>
                        </div>
                        <form id='deletar' action='../handler/comentario/deletarComentario.php?id=$id' method='post'>
                        <input type='hidden' name='comentario' id='comentario' value='$comentario'>
                        <input type='hidden' name='cpfUser' id='cpfUser' value='$cpfComentario'>
                        <input type='submit' value='Deletar'>
                        </form>
                        </div>
                        ";
                            }
                        } elseif ($cpfComentario == $_SESSION['cpf']) {
                            echo "
                        <div class='comment'>
                        <div class='txt'>
                        $img
                        <p class='nome'>" . $nome . ": </p>
                        <p>" . $comentario . "</p>
                        </div>
                        <form id='deletar' action='../handler/comentario/deletarComentario.php?id=$id' method='post'>
                        <input type='hidden' name='comentario' id='comentario' value='$comentario'>
                        <input type='hidden' name='cpfUser' id='cpfUser' value='$cpfComentario'>
                        <input type='submit' value='Deletar'>
                        </form>
                        </div>
                        ";
                        } elseif ($nome == "ADM") {
                            echo "
                        <div class='commentADM'>
                        <div class='txt'>
                        $img
                        <p class='nome'>" . $nome . ": </p>
                        <p>" . $comentario . "</p>
                        </div>
                        </div>
                        ";
                        } else {
                            echo "
                        <div class='comment'>
                        <div class='txt'>
                        $img
                        <p class='nome'>" . $nome . ": </p>
                        <p>" . $comentario . "</p>
                        </div>
                        </div>
                        ";
                        }
                    }
                    ?>
                </div>
                <form action="../handler/comentario/comentar.php?id=<?php echo $id ?>" method="post">
                    <input type="text" name="comentario" id="comentario" placeholder="Seu comentario: (Max: 100)"
                        required>
                    <button type="submit">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        <?php
        if (isset($_GET['resposta'])) {
            echo "alert('" . $_GET['resposta'] . "')";
        }
        ?>
        const filme_id = <?php echo $id ?>;
        const isIframe = <?php echo (strpos($link, 'drive.google.com') !== false) ? 'true' : 'false'; ?>;

        <?php
        $cpf = $_SESSION['cpf'];
        $sql = "SELECT tempo FROM minutagem WHERE filme_id = $id AND cpf = '$cpf'";
        $resultado = $conn->query($sql);
        $tempo = ($row = $resultado->fetch_assoc()) ? $row['tempo'] : 0;
        ?>

        if (isIframe) {
            const tempoSalvo = <?php echo $tempo ?>;
            const iframe = document.querySelector('iframe');

            if (iframe) {
                // Adiciona o parâmetro de início à URL do iframe
                const url = new URL(iframe.src);
                url.searchParams.set('start', Math.floor(tempoSalvo));
                iframe.src = url.toString();
            }

            // Atualiza o tempo no servidor periodicamente
            let tempoAtual = tempoSalvo; // Baseado no tempo salvo
            setInterval(() => {
                tempoAtual += 6; // Incrementa manualmente (melhor se houver API)
                fetch('../action/salvar_tempo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tempo: tempoAtual,
                        id: filme_id
                    })
                });
            }, 6000);
        } else {
            const video = document.getElementById('video');
            video.addEventListener('loadedmetadata', () => {
                video.currentTime = <?php echo $tempo ?>;
            });

            setInterval(() => {
                fetch('../action/salvar_tempo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tempo: video.currentTime,
                        id: filme_id
                    })
                });
            }, 6000);
        }
    </script>
</body>

</html>