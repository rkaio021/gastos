<?php
$host = 'localhost';
$usuario = 'root';
$senha = ''; 
$banco = 'cartao';

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>
