<?php
include 'conexao.php';

$filtro_mes = isset($_GET['mes']) ? (int)$_GET['mes'] : (int)date('m');
$filtro_ano = isset($_GET['ano']) ? (int)$_GET['ano'] : (int)date('Y');

$cartoes = $conexao->query("SELECT id, nome FROM cartoes ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Caixa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<h2>Resumo do Caixa - <?= str_pad($filtro_mes, 2, '0', STR_PAD_LEFT) ?>/<?= $filtro_ano ?></h2>

<form method="get">
    <label>Mês:</label>
    <input type="number" name="mes" value="<?= $filtro_mes ?>" min="1" max="12" required>
    <label>Ano:</label>
    <input type="number" name="ano" value="<?= $filtro_ano ?>" required>
    <button type="submit">Filtrar</button>
</form>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Cartão</th>
        <th>Total Gasto (no mês)</th>
        <th>Total Pago</th>
        <th>Saldo a Pagar</th>
        <th>% Pago</th>
    </tr>

<?php
while ($cartao = $cartoes->fetch_assoc()):
    $id_cartao = $cartao['id'];
    $total_gasto = 0;

    $dataFiltro = sprintf('%04d-%02d-01', $filtro_ano, $filtro_mes);
    $dtFiltro = new DateTime($dataFiltro);

    $sql_gastos = "SELECT valor, total_parcelas, data_compra, parcelado
                   FROM gastos
                   WHERE id_cartao = ?
                   AND (
                     (parcelado = 1 AND
                      DATE_ADD(data_compra, INTERVAL (total_parcelas - 1) MONTH) >= ? 
                      AND data_compra <= ?)
                     OR
                     (parcelado = 0 AND MONTH(data_compra) = ? AND YEAR(data_compra) = ?)
                   )";

    $stmt = $conexao->prepare($sql_gastos);
    $stmt->bind_param("issii", $id_cartao, $dataFiltro, $dataFiltro, $filtro_mes, $filtro_ano);
    $stmt->execute();
    $result_gastos = $stmt->get_result();

    while ($gasto = $result_gastos->fetch_assoc()) {
        $valor = (float)$gasto['valor'];
        $parcelado = (int)$gasto['parcelado'];
        $total_parcelas = (int)$gasto['total_parcelas'];
        $data_compra = new DateTime($gasto['data_compra']);

        if ($parcelado === 1) {
            $diff_anos = (int)$dtFiltro->format('Y') - (int)$data_compra->format('Y');
            $diff_meses = (int)$dtFiltro->format('m') - (int)$data_compra->format('m');
            $parcela_atual = $diff_anos * 12 + $diff_meses + 1;

            if ($parcela_atual >= 1 && $parcela_atual <= $total_parcelas) {
                $valor_parcela = $valor / $total_parcelas;
                $total_gasto += $valor_parcela;
            }
        } else {
            $total_gasto += $valor;
        }
    }

    // Buscar total pago no mês
    $sql_pago = "SELECT SUM(valor_pago) AS total_pago FROM caixa WHERE id_cartao = ? AND MONTH(data_pagamento) = ? AND YEAR(data_pagamento) = ?";
    $stmt_pago = $conexao->prepare($sql_pago);
    $stmt_pago->bind_param("iii", $id_cartao, $filtro_mes, $filtro_ano);
    $stmt_pago->execute();
    $result_pago = $stmt_pago->get_result();
    $total_pago = $result_pago->fetch_assoc()['total_pago'] ?? 0;

    $saldo = $total_gasto - $total_pago;
    $percentual_pago = ($total_gasto > 0) ? ($total_pago / $total_gasto) * 100 : 100;
?>
    <tr>
        <td><?= htmlspecialchars($cartao['nome']) ?></td>
        <td>R$ <?= number_format($total_gasto, 2, ',', '.') ?></td>
        <td>R$ <?= number_format($total_pago, 2, ',', '.') ?></td>
        <td>R$ <?= number_format(max($saldo, 0), 2, ',', '.') ?></td>
        <td><?= number_format($percentual_pago, 1) ?>%</td>
    </tr>

<?php endwhile; ?>

</table>

</body>
</html>
