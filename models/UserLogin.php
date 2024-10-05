<?php

// Incluindo a conexão com o banco de dados. 
require_once '../models/FactoryConection.php';

class UserLogin {
    // Propriedades do usuário
    private $email;
    private $senha;  

    // Define o email do usuário
    public function setEmail($email): void { 
        $this->email = $email;
    }

    // Define a senha do usuário
    public function setSenha($senha): void {
        $this->senha = $senha;
    }

    // Método para autenticar o usuário
    public function autenticar(): void {
        // Tentando conectar ao banco de dados
        $conexao = FactoryConection::getInstance()->getConnection();
        $email = $this->email;

        // Montando a consulta para buscar o usuário pelo email
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Buscando o resultado
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // Fechando a conexão com o banco de dados
        $conexao = null;
        // Verifica se o usuário foi encontrado
        if ($resultado) {
            // Aqui estamos usando a função password_verify para verificar a senha
            if (password_verify($this->senha, $resultado['senha'])) {
                session_start(); // Iniciando a sessão
                // Armazenando informações do usuário na sessão
                $_SESSION['id'] = $resultado['id'];
                $_SESSION['nome'] = $resultado['nome'];
                $_SESSION['email'] = $resultado['email'];
                $_SESSION['tipo_usuario'] = $resultado['tipo_usuario'];
                header('Location: ../views/home.html'); // Redireciona para a página inicial

                exit(); // Garantindo que não mais nada seja executado
            } else {
                session_start();
                $_SESSION['error'] = "Email ou senha inválidos. Vamos tentar de novo?";
                header('Location: ../public/index.php'); // Redireciona para a página de login
                exit();
            }
        } else {
            
            session_start();
            $_SESSION['error'] = "Email ou senha inválidos. Vamos tentar de novo?";
            header('Location: ../public/index.php'); // Redireciona para a página de login
                
        }
    }

    // Método para gerenciar o login
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Capturando email e senha do formulário
            $email = $_POST['Email']; 
            $senha = $_POST['Senha']; 
            $this->setEmail($email);
            $this->setSenha($senha);
            
            $this->autenticar(); // Tentando autenticar o usuário
        }
    }
}

// Criando um novo objeto User e chamando o método login
$user = new UserLogin();
$user->login();

