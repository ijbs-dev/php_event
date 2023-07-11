<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="titulo">Inserir Evento</div>

<?php
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

    /*if(isset($dados['nascimento'])) {
        $data = DateTime::createFromFormat(
            'd/m/Y', $dados['nascimento']);
        if(!$data) {
            $erros['nascimento'] = 'Data deve estar no padrão dd/mm/aaaa';
        }
    }*/
      
    if (trim($dados['LocalEvento']) === "") {
        $erros['LocalEvento'] = 'Local do evento é obrigatório';
    }

    if (!count($erros)) {
        require_once "conexao.php";

        $sql = "INSERT INTO evento 
        (NomeEvento, DescrEvento, DataEvento, LocalEvento)
        VALUES (?, ?, ?, ?)";

        $conexao = novaConexao();
        $stmt = $conexao->prepare($sql);

        $params = [
            $dados['NomeEvento'],
            $dados['DescrEvento'],
            $data ? $data->format('Y-m-d') : null,           
            $dados['LocalEvento'],
                        
        ];

        $stmt->bind_param("ssss", ...$params);

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

<form action="#" method="post">
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