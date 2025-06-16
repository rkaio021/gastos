<?php
include 'conexao.php';

// Buscar os cartões cadastrados
$resultado = $conexao->query("SELECT id, nome FROM cartoes ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Gasto</title>
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

    <h2>Cadastrar Gasto</h2>
    <form action="salvar_gasto.php" method="post">
        <label>Descrição:</label>
        <input type="text" name="descricao" required><br>

        <label>Local:</label>
        <input type="text" name="local"><br>

        <label>Valor (R$):</label>
        <input type="number" name="valor" step="0.01" required><br>

        <label>Data da compra:</label>
        <input type="date" name="data_compra" required><br>

        <label><input type="checkbox" id="parcelado" name="parcelado" value="1" onclick="toggleParcelamento()"> Parcelado?</label><br>

        <div id="parcelas" style="display: none;">
            <label>Total de parcelas:</label>
            <input type="number" name="total_parcelas" min="2"><br>
        </div>

        <label>Cartão:</label>
        <select name="id_cartao" required>
            <option value="">Selecione</option>
            <?php while ($cartao = $resultado->fetch_assoc()): ?>
                <option value="<?= $cartao['id'] ?>"><?= $cartao['nome'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
