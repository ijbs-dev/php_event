<div class="titulo">Criar BD de Usuario</div>

<?php

require_once "conexao.php";

$conexao = novaConexao(null);
$sql = 'CREATE DATABASE IF NOT EXISTS evento_php';

$resultado = $conexao->query($sql);

if($resultado) {
    echo "Sucesso na Criação do Banco de Dados!!!";
} else {
    echo "Erro: " . $conexao->error;
}

$conexao->close();