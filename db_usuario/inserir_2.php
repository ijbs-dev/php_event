<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="titulo">Inserir Usuario </div>

<?php
if (count($_POST) > 0) {
    $dados = $_POST;
    $erros = [];

    if (trim($dados['NomeUsuario']) === "") {
        $erros['NomeUsuario'] = 'Nome é obrigatório';
    }

    if(!filter_var($dados['EmailUsuario'], FILTER_VALIDATE_EMAIL)) {
        $erros['EmailUsuario'] = 'Email inválido';
    }    

    if (trim($dados['SenhaUsuario']) === "") {
        $erros['SenhaUsuario'] = 'Senha é obrigatório';
    }        

    if (!count($erros)) {
        require_once "conexao.php";

        $sql = "INSERT INTO usuario 
        (NomeUsuario, EmailUsuario, SenhaUsuario)
        VALUES (?, ?, ?)";

        $conexao = novaConexao();
        $stmt = $conexao->prepare($sql);

        $params = [
            $dados['NomeUsuario'],
            $dados['EmailUsuario'],
            $dados['SenhaUsuario'],
        ];

        $stmt->bind_param("sss", ...$params);

        if ($stmt->execute()) {
            unset($dados);
        }
    }
}
?>

<form action="#" method="post">
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="NomeUsuario">Nome </label>
            <input type="text" class="form-control <?= $erros['NomeUsuario'] ? 'is-invalid' : '' ?>" id="NomeUsuario" name="NomeUsuario" placeholder="Nome" value="<?= $dados['NomeUsuario'] ?>">
            <div class="invalid-feedback">
                <?= $erros['NomeUsuario'] ?>
            </div>
        </div> 
        
        <div class="form-group col-md-6">
            <label for="EmailUsuario">E-mail</label>
            <input type="text"
                class="form-control <?= $erros['EmailUsuario'] ? 'is-invalid' : ''?>"
                id="EmailUsuario" name="EmailUsuario" placeholder="E-mail"
                value="<?= $dados['EmailUsuario'] ?>">
            <div class="invalid-feedback">
                <?= $erros['EmailUsuario'] ?>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="SenhaUsuario">Senha </label>
            <input type="password" class="form-control <?= $erros['SenhaUsuario'] ? 'is-invalid' : '' ?>" id="SenhaUsuario" name="SenhaUsuario" placeholder="Senha" value="<?= $dados['SenhaUsuario'] ?>">
            <div class="invalid-feedback">
                <?= $erros['SenhaUsuario'] ?>
            </div>
        </div>        
    </div>
    
    <button class="btn btn-primary btn-lg">Enviar</button>
</form>