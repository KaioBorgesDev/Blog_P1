<?php

session_start(); 
require_once '../models/FactoryConection.php';

class Postagem {
    
    public $titulo;
    public $conteudo;
    public $autor; // novo atributo para o autor da postagem
    public $dataPostagem; // novo atributo para a data da postagem

    public function __construct($titulo, $conteudo, $autor, $dataPostagem) {
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
        $this->autor = $autor;
        $this->dataPostagem = $dataPostagem;
    }

    public static function getAllPosts(): array {
        try {
            $conexao = FactoryConection::getInstance()->getConnection();
            $sql = "SELECT titulo, conteudo, id_usuario, data_postagem FROM postagens order by data_postagem DESC"; // pegando tudo que tem
            $smt = $conexao->prepare($sql); // preparando a consulta
            
            $smt->execute();

            $resultados = $smt->fetchAll(PDO::FETCH_ASSOC); // busca todos os resultados

            // vamos buscar o nome do autor
            $conexao_nome = FactoryConection::getInstance()->getConnection();
            foreach ($resultados as &$post) {
                $autorId = $post['id_usuario'];
                $sqlAutor = "SELECT nome FROM usuarios WHERE id = :id"; 
                $smtAutor = $conexao_nome->prepare($sqlAutor);
                $smtAutor->execute([':id' => $autorId]);
                $autor = $smtAutor->fetch(PDO::FETCH_ASSOC);
                $post['autor'] = $autor['nome']; 
            }

            return $resultados; // aqui estão os nossos tesouros (ou não).
        } catch (Exception $e) {
            $_SESSION["msg_post"] = "Erro: " . $e->getMessage(); 
            return []; // um array vazio caso não consiga
        }
    }
}

$posts = Postagem::getAllPosts();



// chamando a função que vai nos mostrar as postagens
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../public/assets/logo.svg">
</head>
<body>
  
    <ul class="nav justify-content-center fixed-top bg-light mt">
        <li class="nav-item">
            <a class="nav-link" href="add_postagem.php">Adicionar Postagem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="excluir_postagem.php">Excluir Postagem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="editar_postagem.php">Editar Postagem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Administração</a> <!-- essa parte é só para os fortes! -->
        </li>
        <li class="nav-item">
            <a class="nav-link"  data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">Perfil</a> 
        </li>
        
    </ul>

    <div class="container mt-5">
        <h1>Postagens</h1>
        
        <div class="list-group">
            <?php foreach ($posts as $post): ?>
                <div class="list-group-item mt-4">
                <small class="text-muted">Por: <?= htmlspecialchars($post['autor']) ?> em <?= htmlspecialchars(date('d/m/Y H:i', strtotime($post['data_postagem']))) ?></small>
                    <h5 class="mb-1"><?= htmlspecialchars($post['titulo']) ?></h5>
                    <p class="mb-1"><?= htmlspecialchars($post['conteudo']) ?></p>
                    
                </div>
            <?php endforeach; ?>
            <?php if (empty($posts)): ?>
                <div class="list-group-item">Nenhuma postagem encontrada. que tristeza, não? vamos escrever algo, pessoal!</div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Área do Usuario</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
      <div class="offcanvas-body">
        <div>
          <h5 class="display-9">Aqui você poderia ver suas informações pessoais.</h5>
        </div>
        <div class="dropdown mt-3">
          <a class="btn btn-danger" href="../models/UserLogout.php">
            Sair da Conta
          </a>
          
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
