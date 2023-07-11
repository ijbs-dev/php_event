<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="titulo">Consultar Evento</div>

<?php
require_once "conexao.php";

$sql = "SELECT idEvento, NomeEvento, DescrEvento, DataEvento, LocalEvento FROM evento";

$conexao = novaConexao();
$resultado = $conexao->query($sql);

$registros = [];

if($resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        $registros[] = $row;
    }
} elseif($conexao->error) {
    echo "Erro: " . $conexao->error;
}

$conexao->close();
?>

<table class="table table-hover table-striped table-bordered">
    <thead>
        <th>Código</th>
        <th>Nome</th>
        <th>Descricao</th>
        <th>Data</th>
        <th>Local</th>
    </thead>
    <tbody>
        <?php foreach($registros as $registro): ?>
            <tr>
                <td><?= $registro['idEvento'] ?></td>
                <td><?= $registro['NomeEvento'] ?></td>
                <td><?= $registro['DescrEvento'] ?></td>
                <td>
                    <?=
                        date('d/m/Y', strtotime($registro['DataEvento']))
                    ?>
                </td>                
                <td><?= $registro['LocalEvento'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<style>
    table > * {
        font-size: 1.2rem;
    }
</style>