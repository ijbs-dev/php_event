<div class="titulo">Criar Tabela Usuario</div>

<?php

require_once "conexao.php";

// DDL - Data Definition Lang.

$sql = "CREATE TABLE IF NOT EXISTS usuario (
    idUsuario INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomeUsuario VARCHAR(60) NOT NULL,
    EmailUsuario VARCHAR(100) NOT NULL,
    SenhaUsuario VARCHAR(100) NOT NULL 
)";

$conexao = novaConexao();
$resultado = $conexao->query($sql);

if($resultado) {
    echo "Tabela criada com sucesso!!";
} else {
    echo "Erro: " . $conexao->error;
}

$conexao->close();