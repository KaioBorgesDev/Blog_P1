<?php

session_start();

// Incluindo a conexão com o banco de dados.
require_once '../FactoryConection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postagem_id = $_POST['postagem_id'];

    if (isset($postagem_id)) {
        try {
            // Estabelece a conexão
            $conexao = FactoryConection::getInstance()->getConnection();
            
            // Prepara a instrução SQL para deletar a postagem com o ID fornecido
            $sql = "DELETE FROM postagens WHERE id = :postagem_id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':postagem_id', $postagem_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                $_SESSION["msg_post"] = "Postagem excluída com sucesso!";
            } else {
                $_SESSION["msg_post"] = "Erro ao excluir a postagem!";
            }

            // Fecha a conexão
            $conexao = null;

        } catch (Exception $e) {
            $_SESSION["msg_post"] = "Erro: " . $e->getMessage();
        }
    }

    // Redireciona para a página de posts
    header("Location: ../../views/home.php");
    exit();
}

?>
