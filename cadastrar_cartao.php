<?php include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Cartão</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

    <h2>Cadastrar Novo Cartão</h2>
    <form action="salvar_cartao.php" method="post">
        <label for="nome">Nome do Cartão:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
