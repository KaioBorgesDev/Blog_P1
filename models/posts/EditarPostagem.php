<?php
session_start();

// Inclui a conexão com o banco de dados
require_once '../FactoryConection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postagem_id = $_POST['postagem_id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    if (isset($postagem_id) && isset($titulo) && isset($conteudo)) {
        try {
            // Estabelece a conexão
            $conexao = FactoryConection::getInstance()->getConnection();

            // Prepara a SQL para atualizar a postagem
            $sql = "UPDATE postagens SET titulo = :titulo, conteudo = :conteudo WHERE id = :postagem_id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
            $stmt->bindParam(':postagem_id', $postagem_id, PDO::PARAM_INT);

            // Executa a atualização e verifica o sucesso
            if ($stmt->execute()) {
                $_SESSION["msg_post"] = "Postagem atualizada com sucesso!";
            } else {
                $_SESSION["msg_post"] = "Erro ao atualizar a postagem!";
            }

            // Fecha a conexão
            $conexao = null;

        } catch (Exception $e) {
            $_SESSION["msg_post"] = "Erro: " . $e->getMessage();
        }
    }

    // Redireciona de volta para a página de postagens
    header("Location: ../../views/home.php");
    exit();
}
?>
