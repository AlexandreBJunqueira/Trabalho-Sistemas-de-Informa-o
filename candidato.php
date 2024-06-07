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
</head>
<body>
    <a href="avaliacao_buscar.php">Voltar para a página de busca</a>
    <?php echo $message; ?>

    <?php if ($candidato && $inscritos): ?>
        <h1>Informações do Candidato</h1>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($candidato['nome'] . " " . $candidato['sobrenome']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($candidato['email']); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($candidato['telefone']); ?></p>
        <p><strong>NUSP:</strong> <?php echo htmlspecialchars($candidato['nusp']); ?></p>
        <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($candidato['data_de_nascimento']); ?></p>
        <p><strong>Ano de Ingresso:</strong> <?php echo htmlspecialchars($candidato['ano_de_ingresso']); ?></p>
        <p><strong>Curso:</strong> <?php echo htmlspecialchars($candidato['curso']); ?></p>
        <p><strong>Sexo:</strong> <?php echo htmlspecialchars($candidato['sexualidade']); ?></p>
        <p><strong>Vulnerabilidade Socioeconômica:</strong> <?php echo $candidato['vulnerabilidade_socioeconomica'] ? 'Sim' : 'Não'; ?></p>
        <p><strong>Gênero:</strong> <?php echo htmlspecialchars($candidato['genero']); ?></p>
        <p><strong>Etnia:</strong> <?php echo htmlspecialchars($candidato['etnia']); ?></p>
        <p><strong>Processo Seletivo:</strong> <?php echo htmlspecialchars($inscritos['processo_seletivo']); ?></p>
        
        <h2>Editar Informações de Inscrição</h2>
        <form action="candidato.php" method="post">
            <input type="hidden" name="processo_seletivo" value="<?php echo htmlspecialchars($inscritos['processo_seletivo']); ?>">
            <label>            
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
            <button type="submit">Atualizar</button>
        </form>
    <?php else: ?>
        <p>Candidato não encontrado.</p>
    <?php endif; ?>
</body>
</html>