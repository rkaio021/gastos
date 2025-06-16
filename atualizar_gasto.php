<?php
include 'conexao.php';

$id = $_POST['id'];
$descricao = $_POST['descricao'];
$local = $_POST['local'];
$valor = $_POST['valor'];
$data_compra = $_POST['data_compra'];
$parcelado = isset($_POST['parcelado']) ? 1 : 0;
$total_parcelas = $parcelado ? $_POST['total_parcelas'] : 1;
$id_cartao = $_POST['id_cartao'];

$stmt = $conexao->prepare("UPDATE gastos 
                           SET descricao = ?, local = ?, valor = ?, data_compra = ?, parcelado = ?, total_parcelas = ?, id_cartao = ?
                           WHERE id = ?");
$stmt->bind_param("ssdsiisi", $descricao, $local, $valor, $data_compra, $parcelado, $total_parcelas, $id_cartao, $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao atualizar gasto: " . $stmt->error;
}
?>
