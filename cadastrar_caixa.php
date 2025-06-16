<?php
include 'conexao.php';

// Buscar cartões disponíveis
$cartoes = $conexao->query("SELECT id, nome FROM cartoes ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar Pagamento</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

    <h2>Registrar Pagamento no Caixa</h2>
    <form action="salvar_caixa.php" method="post">
        <label>Valor pago (R$):</label>
        <input type="number" name="valor_pago" step="0.01" required><br>

        <label>Data do pagamento:</label>
        <input type="date" name="data_pagamento" required><br>

        <label>Cartão:</label>
        <select name="id_cartao" required>
            <option value="">Selecione</option>
            <?php while ($cartao = $cartoes->fetch_assoc()): ?>
                <option value="<?= $cartao['id'] ?>"><?= $cartao['nome'] ?></option>
            <?php endwhile; ?>
        </select><br>

        <label>Observação (opcional):</label>
        <input type="text" name="obs"><br><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
