<?php

session_start(); 

// Incluindo a conexão com o banco de dados.
require_once '../FactoryConection.php';
class Postagem {
    
    public $titulo;
    public $conteudo;

    public function __construct($titulo, $conteudo) {
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
    }

    public function savePost(): void {
        try {
            $conexao = FactoryConection::getInstance()->getConnection();
            $sql = "Select (titulo, conteudo) from postagens";
            $smt = $conexao->prepare($sql); // Prepara a instrução SQL
            
            $smt->execute(); // Executa a consulta

            $resultado = $smt->fetch(PDO::FETCH_ASSOC);

            $conexao = null;

            if ($resultado) {

                for ($i = 0; $i < count($resultado); $i++) {

                }
            }
           
        } catch (Exception $e) {
            $_SESSION["msg_post"] = "Erro: " . $e->getMessage(); // Mensagem de erro
        }
    }
}

if($_SERVER['REQUEST_METHOD']== "POST"){
    // Verifica se os dados foram enviados
    if (isset($_POST["titulo"], $_POST["conteudo"])) {
        if (!empty($_SESSION["user_id"])) {
            $post = new Postagem($_POST["titulo"], $_POST["conteudo"]);
            $post->savePost();
        } else {
            $_SESSION["msg_post"] = "Erro: Usuário não autenticado."; // Usuário não autenticado
            header("Location: ../../views/add_postagem.php");
            exit();
        }
    } else {
        $_SESSION["msg_post"] = "Error_Corpo: Dados incompletos."; // Dados não enviados'
        header("Location: ../../views/add_postagem.php");
        exit();
    }
}

