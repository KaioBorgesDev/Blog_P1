<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../public/assets/logo.svg">
    <title>Editando Postagem</title>
</head>
<body>
    <div class="mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="display-6">Editando Postagem!</h1>
                <div class="col-10">
                    <!-- Formulário para editar a postagem -->
                    <form action="../models/posts/EditarPostagem.php" method="POST">
                        
                        <!-- Select para listar os títulos das postagens -->
                        <select class="form-select mb-3" name="postagem_id" id="postagem_id" required>
                            <option selected disabled>Selecione uma postagem para editar</option>

                            <!-- PHP para carregar os títulos das postagens -->
                            <?php
                            session_start(); // iniciar a sessão
                            require_once '../models/FactoryConection.php';

                            try {
                                $conexao = FactoryConection::getInstance()->getConnection();

                                // Verifica se o usuário está logado
                                if (!empty($_SESSION["user_id"])) {
                                    $id_usuario = $_SESSION['user_id'];

                                    // SQL para buscar os títulos e IDs das postagens do usuário logado
                                    $sql = "SELECT id, titulo FROM postagens WHERE id_usuario = :id_usuario";
                                    $stmt = $conexao->prepare($sql);
                                    $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Exibe as opções no select
                                    foreach ($postagens as $postagem) {
                                        echo "<option value='" . $postagem['id'] . "'>"  . $postagem['titulo'] . "</option>";
                                    }
                                } else {
                                    echo "<option disabled>Usuário não logado.</option>";
                                }

                                $conexao = null; // Fecha a conexão
                            } catch (Exception $e) {
                                echo "Erro ao carregar as postagens: " . $e->getMessage();
                            }
                            ?>
                        </select>

                        <!-- Inputs para editar título e conteúdo -->
                        <div class="mb-3">
                            <label for="Titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Digite o novo título" required>
                        </div>

                        <div class="mb-3">
                            <label for="Conteúdo" class="form-label">Conteúdo</label>
                            <textarea class="form-control" name="conteudo" id="conteudo" rows="3" placeholder="Digite o novo conteúdo" required></textarea>
                        </div>

                        <!-- Botão para salvar as alterações -->
                        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
                    </form>
                </div>

                <a href="../views/home.php">Voltar</a>
            </div>
        </div>
    </div>

    <script>
        // Script para carregar o título e o conteúdo da postagem selecionada
        document.getElementById('postagem_id').addEventListener('change', function () {
            const postagem_id = this.value;

            if (postagem_id) {
                // Requisição AJAX para buscar os dados da postagem selecionada
                fetch(`../controllers/get_postagem.php?id=${postagem_id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('titulo').value = data.titulo;
                        document.getElementById('conteudo').value = data.conteudo;
                    })
                    .catch(error => console.error('Erro ao carregar a postagem:', error));
            }
        });
    </script>
</body>
</html>
