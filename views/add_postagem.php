<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../public/assets/logo.svg">

    <title>Adicionando Postagem</title>
    <script>
        function validateForm(event) {
            const titulo = document.forms["postForm"]["titulo"].value;
            const conteudo = document.forms["postForm"]["conteudo"].value;
            let errorMessage = "";

            if (!titulo) {
                errorMessage += "O título não pode estar vazio.\n";
            }
            if (!conteudo) {
                errorMessage += "O conteúdo não pode estar vazio.\n";
            }

            if (errorMessage) {
                event.preventDefault(); // Impede o envio do formulário
                alert(errorMessage); // Exibe um alerta com as mensagens de erro
            }
        }
    </script>
</head>
<body>
    <div class="mt-5">
        <div class="row justify-content-center">
            <?php
                session_start(); 
                if (isset($_SESSION['msg_post'])) {
                    echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Status</strong>
                                <small>agora mesmo</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                ' . $_SESSION['msg_post'] . '
                            </div>
                        </div>
                    </div>';
                    unset($_SESSION['msg_post']);
                }
            ?>
            <form name="postForm" action="../models/posts/PostCreate.php" method="post" class="col-md-6" onsubmit="validateForm(event)">
                <h1 class="display-6">Adicionando Postagem!</h1>
                <div class="mb-3">
                    <label for="Titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" name="titulo" placeholder="“Não tive lucro”, diz Marçal sobre condenação em esquema de golpes">
                </div>
                <div class="mb-3">
                    <label for="Conteúdo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" name="conteudo" rows="3" placeholder="Candidato a prefeito de São Paulo, Marçal foi preso em 2005 e condenado a 4 anos e 5 meses de prisão por envolvimento com golpes bancários"></textarea>
                </div>
                <div class="col-md-3 justify-content-center">
                    <input type="submit" class="btn btn-primary" value="Postar"> 
                    <a href="home.php" class="btn btn-danger">Voltar para o Home</a>  
                </div> 
            </form>  
        </div>
    </div>
</body>
</html>
