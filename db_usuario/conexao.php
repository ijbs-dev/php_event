<?php

function novaConexao($banco = 'evento_php') {
      // se for outra porta podemos alterar aqui. Porta 3306 é padrao caso 
    // nao quisesse poderia deixar sem a posta
 
    $servidor = '127.0.0.1:3306';
    $usuario = 'root';
    $senha = '';

    $conexao = new mysqli($servidor, $usuario, $senha, $banco);

    if($conexao->connect_error) {
        die('Erro: ' . $conexao->connect_error);
    }

    return $conexao;
}