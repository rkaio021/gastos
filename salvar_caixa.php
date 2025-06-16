<?php
include 'conexao.php';

$valor = $_POST["valor_pago"];
$data = $_POST["data_pagamento"];
$id_cartao = $_POST["id_cartao"];
$obs = $_POST["obs"];

$stmt = $conexao->prepare("INSERT INTO caixa (valor_pago, data_pagamento, id_cartao, obs) VALUES (?, ?, ?, ?)");
$stmt->bind_param("dsis", $valor, $data, $id_cartao, $obs);

if ($stmt->execute()) {
    echo '
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Processando...</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .feedback-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            color: #2e7d32;
        }

        .loader {
            border: 6px solid #eee;
            border-top: 6px solid #2e7d32;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .success-message {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .redirect-msg {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="feedback-container">
        <div class="loader"></div>
        <div class="success-message">Pagamento registrado com sucesso!</div>
        <div class="redirect-msg">Redirecionando para a página inicial...</div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "index.php";
        }, 2000);
    </script>
</body>
</html>
';exit;
} else {
    echo "Erro ao salvar: " . $conexao->error;
}

$stmt->close();
$conexao->close();
?>
