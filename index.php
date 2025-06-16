<?php
include 'conexao.php';

$cartoes = $conexao->query("SELECT id, nome FROM cartoes ORDER BY nome ASC");

$filtro_cartao = isset($_GET['id_cartao']) ? $_GET['id_cartao'] : '';
$filtro_mes = isset($_GET['mes']) ? (int) $_GET['mes'] : date('n');
$filtro_ano = isset($_GET['ano']) ? (int) $_GET['ano'] : date('Y');

// Buscar todos os gastos (iremos filtrar no PHP)
$sql = "SELECT g.*, c.nome AS nome_cartao 
        FROM gastos g
        JOIN cartoes c ON g.id_cartao = c.id";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gastos Registrados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>
<h2>Gastos no Cartão</h2>

<form method="get">
    <label>Cartão:</label>
    <select name="id_cartao">
        <option value="">Todos</option>
        <?php foreach ($cartoes as $cartao): ?>
            <option value="<?= $cartao['id'] ?>" <?= ($filtro_cartao == $cartao['id']) ? 'selected' : '' ?>>
                <?= $cartao['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Mês:</label>
    <input type="number" name="mes" value="<?= $filtro_mes ?>" min="1" max="12">

    <label>Ano:</label>
    <input type="number" name="ano" value="<?= $filtro_ano ?>">

    <button type="submit">Filtrar</button>
</form>

<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>Data</th>
    <th>Descrição</th>
    <th>Local</th>
    <th>Valor Total (R$)</th>
    <th>Parcela Atual</th>
    <th>Valor da Parcela (R$)</th>
    <th>Cartão</th>
    <th>Ações</th>
</tr>

<?php
$total_mes = 0;

while ($gasto = $resultado->fetch_assoc()) {
    $data_compra = new DateTime($gasto['data_compra']);
    $total_parcelas = (int)$gasto['total_parcelas'];
    $valor_total = (float)$gasto['valor'];
    $parcelado = (bool)$gasto['parcelado'];

    for ($i = 0; $i < ($parcelado ? $total_parcelas : 1); $i++) {
        $data_parcela = clone $data_compra;
        $data_parcela->modify("+$i month");

        if ((int)$data_parcela->format('m') == $filtro_mes && (int)$data_parcela->format('Y') == $filtro_ano) {
            if (!empty($filtro_cartao) && $gasto['id_cartao'] != $filtro_cartao) {
                continue;
            }

            $valor_parcela = $valor_total / ($parcelado ? $total_parcelas : 1);
            $total_mes += $valor_parcela;
            ?>
            <tr>
                <td><?= $data_parcela->format('d/m/Y') ?></td>
                <td><?= $gasto['descricao'] ?></td>
                <td><?= $gasto['local'] ?></td>
                <td>R$ <?= number_format($valor_total, 2, ',', '.') ?></td>
                <td><?= $parcelado ? ($i + 1) . " / " . $total_parcelas : "À vista" ?></td>
                <td>R$ <?= number_format($valor_parcela, 2, ',', '.') ?></td>
                <td><?= $gasto['nome_cartao'] ?></td>
                <td><a href="editar_gasto.php?id=<?= $gasto['id'] ?>">Editar</a></td>
            </tr>
            <?php
        }
    }
}
?>

<tr>
    <td colspan="5"><strong>Total gasto no mês:</strong></td>
    <td colspan="2"><strong>R$ <?= number_format($total_mes, 2, ',', '.') ?></strong></td>
</tr>
</table>
</body>
</html>
