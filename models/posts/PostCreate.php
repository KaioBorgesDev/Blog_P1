<?php

session_start(); 

// Incluindo a conexão com o banco de dados.
require_once '../FactoryConection.php';
class Postagem {
    public $idUsuario;
    public $titulo;
    public $conteudo;

    public function __construct($titulo, $conteudo) {
        $this->idUsuario = $_SESSION["user_id"] ?? null; // Verifica se o usuário está logado
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
    }

    public function savePost(): void {
        // Obtendo a conexão
    $conexao = FactoryConection::getInstance()->getConnection();

    // Verifica se a conexão é nula
    if ($conexao === null) {
        $_SESSION["msg_post"] = "Erro: Não foi possível estabelecer conexão com o banco de dados.";
        header("Location: ../../views/add_postagem.php");
        exit();
    }
    
    $sql = "INSERT INTO postagens (id_usuario, titulo, conteudo) VALUES (:id_usuario, :titulo, :conteudo)";
    $smt = $conexao->prepare($sql); // Prepara a instrução SQL
    $smt->bindParam(":id_usuario", $this->idUsuario);
    $smt->bindParam(":titulo", $this->titulo);
    $smt->bindParam(":conteudo", $this->conteudo);

    try {
        $smt->execute(); // Executa a consulta
        $_SESSION["msg_post"] = "Sucesso"; // Mensagem de sucesso
    } catch (PDOException $e) {
        $_SESSION["msg_post"] = "Erro ao inserir postagem: " . $e->getMessage(); // Mensagem de erro
    }

    // Redireciona para a página de adição de postagens
    header("Location: ../../views/add_postagem.php");
    exit();
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

