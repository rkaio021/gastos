<?php
include 'conexao.php';

$id = $_GET['id'];
$stmt = $conexao->prepare("SELECT * FROM gastos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$gasto = $stmt->get_result()->fetch_assoc();

// Buscar cartões
$cartoes = $conexao->query("SELECT id, nome FROM cartoes ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Gasto</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleParcelamento() {
            var check = document.getElementById("parcelado");
            var parcelas = document.getElementById("parcelas");
            parcelas.style.display = check.checked ? "block" : "none";
        }
    </script>
</head>
<body>
<?php include 'header.php'; ?>

<h2>Editar Gasto</h2>

<form action="atualizar_gasto.php" method="post">
    <input type="hidden" name="id" value="<?= $gasto['id'] ?>">

    <label>Descrição:</label>
    <input type="text" name="descricao" value="<?= $gasto['descricao'] ?>" required><br>

    <label>Local:</label>
    <input type="text" name="local" value="<?= $gasto['local'] ?>"><br>

    <label>Valor (R$):</label>
    <input type="number" name="valor" step="0.01" value="<?= $gasto['valor'] ?>" required><br>

    <label>Data da compra:</label>
    <input type="date" name="data_compra" value="<?= $gasto['data_compra'] ?>" required><br>

    <label><input type="checkbox" id="parcelado" name="parcelado" value="1" onclick="toggleParcelamento()" <?= $gasto['parcelado'] ? 'checked' : '' ?>> Parcelado?</label><br>

    <div id="parcelas" style="display: <?= $gasto['parcelado'] ? 'block' : 'none' ?>;">
        <label>Total de parcelas:</label>
        <input type="number" name="total_parcelas" min="2" value="<?= $gasto['total_parcelas'] ?>"><br>
    </div>

    <label>Cartão:</label>
    <select name="id_cartao" required>
        <option value="">Selecione</option>
        <?php while ($cartao = $cartoes->fetch_assoc()): ?>
            <option value="<?= $cartao['id'] ?>" <?= $gasto['id_cartao'] == $cartao['id'] ? 'selected' : '' ?>>
                <?= $cartao['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit">Atualizar</button>
</form>
</body>
</html>
