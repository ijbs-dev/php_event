<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="titulo">Alterar Evento</div>

<?php
require_once "conexao.php";
$conexao = novaConexao();

if ($_GET['codigo']) {
    $sql = "SELECT * FROM evento WHERE idEvento = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $_GET['codigo']);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $dados = $resultado->fetch_assoc();
            if ($dados['DataEvento']) {
                $dt = new DateTime($dados['DataEvento']);
                $dados['DataEvento'] = $dt->format('d/m/Y');
            }
        }
    }
}

if (count($_POST) > 0) {
    $dados = $_POST;    
    $erros = [];

    if (trim($dados['NomeEvento']) === "") {
        $erros['NomeEvento'] = 'Nome é obrigatório';
    }

    if (trim($dados['DescrEvento']) === "") {
        $erros['DescrEvento'] = 'Descrição é obrigatório';
    }

    if (isset($dados['DataEvento'])) {
        $data = DateTime::createFromFormat(
            'd/m/Y',
            $dados['DataEvento']
        );
        if (!$data) {
            $erros['DataEvento'] = 'Data deve estar no padrão dd/mm/aaaa';
        }
    }    

    if (trim($dados['LocalEvento']) === "") {
        $erros['LocalEvento'] = 'Local é obrigatório';
    }

    if (!count($erros)) {       
        $sql = "UPDATE evento 
        SET NomeEvento = ?, DescrEvento = ?, 
        DataEvento = ?, LocalEvento = ?
        WHERE idEvento = ?";
        
        $stmt = $conexao->prepare($sql);

        $params = [
            $dados['NomeEvento'],
            $dados['DescrEvento'],
            $data ? $data->format('Y-m-d') : null,
            $dados['LocalEvento'],
            $dados['idEvento'],
        ];
        //var_dump($stmt);
        //var_dump($params);

        $stmt->bind_param("ssssi", ...$params);
        
        if ($stmt->execute()) {
            unset($dados);
        }
    }
}
?>

<?php foreach ($erros as $erro) : ?>
    <!-- <div class="alert alert-danger" role="alert"> -->
    <?= "" // $erro 
    ?>
    <!-- </div> -->
<?php endforeach ?>


<form action="/exercicio.php" method="get">
    <input type="hidden" name="dir" value="db_evento">
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
<input type="hidden" name="idEvento" value="<?= $dados['idEvento']?>">
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="NomeEvento">Nome </label>
            <input type="text" class="form-control <?= $erros['NomeEvento'] ? 'is-invalid' : '' ?>" id="NomeEvento" name="NomeEvento" placeholder="Nome" value="<?= $dados['NomeEvento'] ?>">
            <div class="invalid-feedback">
                <?= $erros['NomeEvento'] ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="DataEvento">Data </label>
            <input type="text" class="form-control <?= $erros['DataEvento'] ? 'is-invalid' : '' ?>" id="DataEvento" name="DataEvento" placeholder="DataEvento" value="<?= $dados['DataEvento'] ?>">
            <div class="invalid-feedback">
                <?= $erros['DataEvento'] ?>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="LocalEvento">Local </label>
            <input type="text" class="form-control <?= $erros['LocalEvento'] ? 'is-invalid' : '' ?>" id="LocalEvento" name="LocalEvento" placeholder="Local" value="<?= $dados['LocalEvento'] ?>">
            <div class="invalid-feedback">
                <?= $erros['LocalEvento'] ?>
            </div>
        </div>        
    </div>
    <div class="form-group">
            <label> Descrição </label>
            <textarea class="form-control <?= $erros['DescrEvento'] ? 'is-invalid' : '' ?>" name="DescrEvento" rows="5" ><?= $dados['DescrEvento'] ?></textarea>
        </div>
    <button class="btn btn-primary btn-lg">Enviar</button>
</form>