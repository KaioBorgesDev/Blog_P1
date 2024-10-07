<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="icon" href="/assets/logo.svg">
</head>
<body>
    <!-- Formulario de login -->
    <form action="../models/UserLogin.php" method="post" class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Verifica se há uma mensagem de erro na sessão -->
                <?php
                session_start(); // Inicia a sessão para acessar mensagens de erro
                if (isset($_SESSION['error'])) {
                    echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Erro</strong>
                                <small>agora mesmo</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                ' . $_SESSION['error'] . '
                            </div>
                        </div>
                    </div>';
                    unset($_SESSION['error']); // Remove a mensagem após exibi-la
                }
                ?>
                <h1>Login</h1>
                <!-- Caixa de email -->
                <div class="mb-3">
                    <label for="Email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="Email" placeholder="email@example.com">
                    </div>
                </div>
                <!-- Caixa de password -->
                <div class="mb-3">
                    <label for="Password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="Senha">
                    </div>
                </div>
                <!-- Botão de envio -->
                <div class="mb-3">
                    <div class="col-sm-10">
                        <input type="submit" value="Enviar" class="btn btn-primary">
                    </div>
                </div>
                <a href="cadastro.php">Não possui uma conta?</a>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
