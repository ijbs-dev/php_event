<div class="titulo">Criar Tabela Evento</div>

<?php

require_once "conexao.php";

// DDL - Data Definition Lang.
$sql = "CREATE TABLE IF NOT EXISTS evento (
    idEvento INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomeEvento VARCHAR(100) NOT NULL,
    DescrEvento VARCHAR(255) NOT NULL,
    DataEvento DATE,
    LocalEvento VARCHAR(100) NOT NULL
)";

$conexao = novaConexao();
$resultado = $conexao->query($sql);

if($resultado) {
    echo "Tabela criada com sucesso!!";
} else {
    echo "Erro: " . $conexao->error;
}

$conexao->close();