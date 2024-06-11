<?php
include 'connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atualizar informações do candidato
    $nusp = $_POST['nusp'];
    $processo_seletivo = $_POST['processo_seletivo'];
    $palestra_institucional = isset($_POST['palestra_institucional']) ? 1 : 0;
    $slides_pessoal = isset($_POST['slides_pessoal']) ? 1 : 0;
    $dinamica_em_grupo = isset($_POST['dinamica_em_grupo']) ? 1 : 0;
    $entrevista = isset($_POST['entrevista']) ? 1 : 0;
    $mentoria = isset($_POST['mentoria']) ? 1 : 0;

    $sql = "UPDATE inscritos SET 
                palestra_institucional = $palestra_institucional, 
                slides_pessoal = $slides_pessoal, 
                dinamica_em_grupo = $dinamica_em_grupo, 
                entrevista = $entrevista, 
                mentoria = $mentoria 
            WHERE nusp = $nusp AND processo_seletivo = $processo_seletivo";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: candidato.php?nusp=$nusp&processo_seletivo=$processo_seletivo&success=Informações atualizadas com sucesso!");
    } else {
        header("Location: candidato.php?nusp=$nusp&processo_seletivo=$processo_seletivo&error=Erro ao atualizar informações: " . $conn->error);
    }
    exit();
} else {
    // Buscar informações do candidato
    $nusp = $_GET['nusp'];
    $processo_seletivo = $_GET['processo_seletivo'];
    $sql = "SELECT * FROM cadastrados WHERE nusp = $nusp";
    $result = $conn->query($sql);
    $candidato = $result->fetch_assoc();

    $sql = "SELECT * FROM inscritos WHERE nusp = $nusp AND processo_seletivo = $processo_seletivo";
    $result = $conn->query($sql);
    $inscritos = $result->fetch_assoc();

    if (isset($_GET['success'])) {
        $message = "<p style='color: green;'>" . htmlspecialchars($_GET['success']) . "</p>";
    } elseif (isset($_GET['error'])) {
        $message = "<p style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do Candidato</title>
    <link rel="stylesheet" href="candidato.css">
</head>
<body>
    <?php if ($candidato && $inscritos): ?>
        <div class="header">
        <div class="container">
        <a class="logo" href="avaliacao_buscar.php">
            <img src="logo_pj.png" alt="Logo da Empresa">
        </a>
        <div class="title">
            <h1>Avaliação do Candidato</h1>
        </div>
        </div>
        </div>
    <div class="container">
        <table class="info-table">
            <tr>
                <th colspan="2">Informações Pessoais</th>
            </tr>
            <tr>
                <td><strong>Nome:</strong></td>
                <td><?php echo htmlspecialchars($candidato['nome'] . " " . $candidato['sobrenome']); ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?php echo htmlspecialchars($candidato['email']); ?></td>
            </tr>
            <tr>
                <td><strong>Telefone:</strong></td>
                <td><?php echo htmlspecialchars($candidato['telefone']); ?></td>
            </tr>
            <tr>
                <td><strong>NUSP:</strong></td>
                <td><?php echo htmlspecialchars($candidato['nusp']); ?></td>
            </tr>
            <tr>
                <td><strong>Data de Nascimento:</strong></td>
                <td><?php echo htmlspecialchars($candidato['data_de_nascimento']); ?></td>
            </tr>
            <tr>
                <td><strong>Ano de Ingresso:</strong></td>
                <td><?php echo htmlspecialchars($candidato['ano_de_ingresso']); ?></td>
            </tr>
            <tr>
                <td><strong>Curso:</strong></td>
                <td><?php echo htmlspecialchars($candidato['curso']); ?></td>
            </tr>
            <tr>
                <td><strong>Sexo:</strong></td>
                <td><?php echo htmlspecialchars($candidato['sexualidade']); ?></td>
            </tr>
            <tr>
                <td><strong>Vulnerabilidade Socioeconômica:</strong></td>
                <td><?php echo $candidato['vulnerabilidade_socioeconomica'] ? 'Sim' : 'Não'; ?></td>
            </tr>
            <tr>
                <td><strong>Gênero:</strong></td>
                <td><?php echo htmlspecialchars($candidato['genero']); ?></td>
            </tr>
            <tr>
                <td><strong>Etnia:</strong></td>
                <td><?php echo htmlspecialchars($candidato['etnia']); ?></td>
            </tr>
        </table>

        <table class="info-table">
            <tr>
                <th colspan="2">Informações do Processo Seletivo</th>
            </tr>
            <tr>
                <td><strong>Processo Seletivo:</strong></td>
                <td><?php echo htmlspecialchars($inscritos['processo_seletivo']); ?></td>
            </tr>
        </table>

        <h2>Situação no Processo Seletivo</h2>
        <form action="candidato.php" method="post">
            <input type="hidden" name="processo_seletivo" value="<?php echo htmlspecialchars($inscritos['processo_seletivo']); ?>">
            <input type="hidden" name="nusp" value="<?php echo htmlspecialchars($candidato['nusp']); ?>">
            <label>
                <input type="checkbox" name="palestra_institucional" <?php if ($inscritos['palestra_institucional']) echo 'checked'; ?>> Palestra Institucional
            </label><br>
            <label>
                <input type="checkbox" name="slides_pessoal" <?php if ($inscritos['slides_pessoal']) echo 'checked'; ?>> Slides Pessoal
            </label><br>
            <label>
                <input type="checkbox" name="dinamica_em_grupo" <?php if ($inscritos['dinamica_em_grupo']) echo 'checked'; ?>> Dinâmica em Grupo
            </label><br>
            <label>
                <input type="checkbox" name="entrevista" <?php if ($inscritos['entrevista']) echo 'checked'; ?>> Entrevista
            </label><br>
            <label>
                <input type="checkbox" name="mentoria" <?php if ($inscritos['mentoria']) echo 'checked'; ?>> Mentoria
            </label><br>
            <input type="submit" name="submit" value="Atualizar">
        </form>
        
    <?php else: ?>
        <p>Candidato não encontrado.</p>
    <?php endif; ?>

    <div class="container" style="text-align: center;">
    <a href="avaliacao_buscar.php" style="font-size: 12px;">Voltar para a página inicial</a>
    </div>

    <?php
    if (isset($message)) {
    echo '<div style="text-align: center; margin-top: 20px;">' . $message . '</div>';
    }
    ?>
</div>
</body>
</html>