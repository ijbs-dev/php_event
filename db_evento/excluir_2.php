<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="titulo">Excluir Evento</div>

<?php
require_once "conexao.php";

$registros = [];
$conexao = novaConexao();

if($_GET['excluir']) {
    $excluirSQL = "DELETE FROM evento WHERE idEvento = ?";
    $stmt = $conexao->prepare($excluirSQL);
    $stmt->bind_param("i", $_GET['excluir']);
    $stmt->execute();
}

$sql = "SELECT idEvento, NomeEvento, DescrEvento, DataEvento, LocalEvento FROM evento";
$resultado = $conexao->query($sql);
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
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Data</th>
        <th>Local</th>
    </thead>
    <tbody>
        <?php foreach($registros as $registro) : ?>
            <tr>
                <td><?= $registro['idEvento'] ?></td>
                <td><?= $registro['NomeEvento'] ?></td>                                
                <td><?= $registro['LocalEvento'] ?></td>                
                <td>
                    <?=
                        date('d/m/Y', strtotime($registro['DataEvento']))
                    ?>
                </td>
                <td><?= $registro['DescrEvento'] ?></td>
                <td>
                    <a href="/exercicio.php?dir=db_evento&file=excluir_2&excluir=<?= $registro['idEvento'] ?>" 
                        class="btn btn-danger">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<style>
    table > * {
        font-size: 1.2rem;
    }
</style>