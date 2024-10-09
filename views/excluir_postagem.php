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
                    <!-- Select para listar os títulos das postagens -->
                    <form action="../models/posts/ExcluirPostagem.php" method="POST">
                        <select class="form-select mb-3" name="postagem_id" required>
                            <option selected disabled>Selecione uma postagem para excluir</option>

                            <!-- PHP para carregar os títulos das postagens -->
                            <?php
                            session_start(); //iniciar a sessao

                            require_once '../models/FactoryConection.php';
                            try {
                                $conexao = FactoryConection::getInstance()->getConnection();

                                // verifica se o usuário está logado
                               
                                    $id_usuario = $_SESSION["user_id"];

                                    // sqkl para buscar os títulos e IDs das postagens do usuário logado
                                    $sql = "SELECT id, titulo FROM postagens WHERE id_usuario = :id_usuario";
                                    $stmt = $conexao->prepare($sql);
                                    $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Exibe as opções no select
                                    foreach ($postagens as $postagem) {
                                        echo "<option value='" . $postagem['id'] . "'>" . $postagem['titulo'] . "</option>";
                                    }
                                

                                $conexao = null; // Fecha a conexão
                            } catch (Exception $e) {
                                echo "Erro ao carregar as postagens: " . $e->getMessage();
                            }
                            ?>
                        </select>

                        <!-- Botão para excluir a postagem -->
                        <button type="submit" class="btn btn-danger mt-3">Excluir Postagem</button>
                    </form>
                </div>

                <a href="../views/home.php">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>
