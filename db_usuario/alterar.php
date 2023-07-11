<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="titulo">Alterar Usuario</div>

<?php
require_once "conexao.php";
$conexao = novaConexao();

if ($_GET['codigo']) {
    $sql = "SELECT * FROM usuario WHERE idUsuario = ?"; 
    $stmt = $conexao->prepare($sql);    
    $stmt->bind_param("i", $_GET['codigo']);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $dados = $resultado->fetch_assoc();            
        }
    }
}

if (count($_POST) > 0) {
    $dados = $_POST;    
    $erros = [];


    if (trim($dados['NomeUsuario']) === "") {
        $erros['NomeUsuario'] = 'Nome é obrigatório';
    }

    if (trim($dados['SenhaUsuario']) === "") {
        $erros['SenhaUsuario'] = 'Senha é obrigatório';
    }

    if(!filter_var($dados['EmailUsuario'], FILTER_VALIDATE_EMAIL)) {
        $erros['EmailUsuario'] = 'Email inválido';
    }

    if (!count($erros)) {       
        $sql = "UPDATE usuario 
        SET NomeUsuario = ?, EmailUsuario = ?, 
        SenhaUsuario = ? WHERE idUsuario = ?";
        
        $stmt = $conexao->prepare($sql);

        $params = [
            $dados['NomeUsuario'],
            $dados['EmailUsuario'],
            $dados['SenhaUsuario'],
            $dados['idUsuario'],
        ];
        //var_dump($stmt);
        //exit;
        //var_dump($params);

        $stmt->bind_param("sssi", ...$params);
        
        if ($stmt->execute()) {
            unset($dados);
        }
    }
}
?>

<form action="/exercicio.php" method="get">
    <input type="hidden" name="dir" value="db_usuario">
    <input type="hidden" name="file" value="alterar">
    <div class="form-group row">
        <div class="col-sm-10">
            <input type="number" name="codigo" class="form-control" 
            value="<?= $_GET['codigo'] ?>" placeholder="Informe o código para consulta">
        </div>
        <div class="col-sm-2">
            <button class="btn btn-success mb-4">Consultar</button>
        </div>
    </div>
</form>

<form action="#" method="post">
<input type="hidden" name="idUsuario" value="<?= $dados['idUsuario']?>">
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
            <input type="text" class="form-control <?= $erros['SenhaUsuario'] ? 'is-invalid' : '' ?>" id="SenhaUsuario" name="SenhaUsuario" placeholder="Senha" value="<?= $dados['SenhaUsuario'] ?>">
            <div class="invalid-feedback">
                <?= $erros['SenhaUsuario'] ?>
            </div>
        </div>        
    </div>
    <button class="btn btn-primary btn-lg">Enviar</button>
</form>