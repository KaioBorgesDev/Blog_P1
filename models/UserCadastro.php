<?php

// Incluindo a conexão com o banco de dados.
require_once '../models/FactoryConection.php';

class UserLogin {
    // Propriedades do usuário
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $data_criacao;
    private $tipo_usuario;   

    // Define o nome do usuário
    public function setNome($nome): void {
        $this->nome = $nome;
    }

    // Define o email do usuário
    public function setEmail($email): void { 
        $this->email = $email;
    }

    // Define a senha do usuário
    public function setSenha($senha): void {
        $this->senha = $senha;
    }

    // Método para verificar a existência do email
    public function verificarExistencias(): bool {
        try {
            $conexao = FactoryConection::getInstance()->getConnection();
            $email = $this->email;

            $sql = "SELECT id FROM usuarios WHERE email = :email"; // Usando parâmetros para evitar SQL Injection
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':email', $email); 
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $conexao = null; // Fechando a conexão

            return count($resultado) > 0;
        } catch (PDOException $e) {
            echo "Erro ao verificar existência: " . $e->getMessage();
            return false; 
        }
    }

    public function setVariaveis(): void {
        if (isset($_POST['Nome'], $_POST['Email'], $_POST['Senha'])) {
            $this->setNome($_POST['Nome']);
            $this->setEmail($_POST['Email']);
            $senhaHash = password_hash($_POST['Senha'], PASSWORD_DEFAULT);
            $this->setSenha($senhaHash);
        } else {
            echo "Dados não enviados corretamente.";
        }
    }

    // Método para gerenciar o cadastro
    public function cadastro(): void {
        $this->setVariaveis(); // Definindo as variáveis primeiro
        if ($this->verificarExistencias()) {
            session_start();
                $_SESSION['error'] = "Email já cadastrado, Vamos tentar de novo?";
                header('Location: ../public/cadastro.php'); // Redireciona para a página de login
            
        } else {
            try {
                $conexao = FactoryConection::getInstance()->getConnection();
                $sql = "INSERT INTO usuarios (email, senha, nome) VALUES (:email, :senha, :nome)";
                $stmt = $conexao->prepare($sql);

                // Colocando os valores para evitar SQL Injection
                $stmt->bindParam(":nome", $this->nome);
                $stmt->bindParam(":email", $this->email);
                $stmt->bindParam(":senha", $this->senha);

                // Executando o statement
                $stmt->execute();

                $_SESSION['msg_post'] = "Cadastrado com sucesso";
                header('Location: ../index.php');
                
            } catch (PDOException $e) {
                $_SESSION['msg_post'] = "Erro ao cadastrar: " . $e->getMessage();;
            }
        }
    }

}

// Criando um novo objeto UserLogin e chamando o método cadastro
$user = new UserLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->cadastro(); 
}
