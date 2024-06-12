<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login.php");
    exit();
}

// Inclui o arquivo de conexão com o banco de dados
include 'connection.php';

// Obtém o nusp da sessão
$nusp = $_SESSION['nusp'];

// Busca os processos seletivos associados ao usuário
$sql = "SELECT processo_seletivo FROM inscritos WHERE nusp = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $nusp);
$stmt->execute();
$result = $stmt->get_result();

$processos_seletivos = [];
while ($row = $result->fetch_assoc()) {
    $processos_seletivos[] = $row['processo_seletivo'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="menu.css">
<title>Área do Candidato</title>
</head>
<body>

<div class="logo">
    <img src="logo_pj.png" alt="Logo da Empresa">
</div>

<div class="login-box">
    <h2>Processos Seletivos</h2>
    <div class="buttons">
        <?php foreach ($processos_seletivos as $processo): ?>
            <button onclick="location.href='acompanhamento.php?processo_seletivo=<?php echo htmlspecialchars($processo); ?>'">
                <?php echo htmlspecialchars($processo); ?>
            </button>
        <?php endforeach; ?>
    </div>
    <div class="container" style="text-align: center;">
        <a href="logout.php" style="font-size: 12px;">Logout</a>
    </div>
</div>

</body>
</html>
