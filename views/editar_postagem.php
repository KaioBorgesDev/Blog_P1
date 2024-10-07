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
                    <select class="form-select mb-3" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
            
                </div>
                <div class="mb-3">
                    <label for="Titulo" class="form-label">Titulo</label>
                    <input type="email" class="form-control" name="Titulo" placeholder="“Não tive lucro”, diz Marçal sobre condenação em esquema de golpes">
                  </div>
                  <div class="mb-3">
                    <label for="Conteúdo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" name="Conteúdo" rows="3" placeholder="Candidato a prefeito de São Paulo, Marçal foi preso em 2005 e condenado a 4 anos e 5 meses de prisão por envolvimento com golpes bancários"></textarea>
                    <input type="submit" class="btn btn-primary mt-3" value="Postar">
                </div>
                <a href="../views/home.php">Voltar</a> 
                       
                        
            </div>  
        </div>
    </div>
    
</body>
</html>