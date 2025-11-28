<?php
session_start();
require_once 'conexao.php';

// Só acessa se for admin
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'admin') {
    die("Acesso negado.");
}

// Busca todos agendamentos
$sql = "SELECT t.*, u.nome AS cliente, v.modelo AS modelo_veiculo 
        FROM test_drive t
        JOIN usuarios u ON t.id_usuario = u.id
        JOIN veiculos v ON t.id_veiculo = v.id
        ORDER BY t.data ASC, t.horario ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos de Test Drive</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<div class="container">
    <h2>Agendamentos de Test Drive</h2>

    <a href="home.php" class="voltar">← Voltar</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Cliente</th>
            <th>Veículo</th>
            <th>Tipo</th>
            <th>Modelo</th>
            <th>Data</th>
            <th>Horário</th>
        </tr>

        <?php foreach ($agendamentos as $a): ?>
        <tr>
            <td><?= $a['cliente'] ?></td>
            <td><?= $a['modelo_veiculo'] ?></td>
            <td><?= $a['tipo_veiculo'] ?></td>
            <td><?= $a['modelo'] ?></td>
            <td><?= date("d/m/Y", strtotime($a['data'])) ?></td>
            <td><?= substr($a['horario'], 0, 5) ?></td>
        </tr>
        <?php endforeach; ?>

    </table>
</div>

</body>
</html>
