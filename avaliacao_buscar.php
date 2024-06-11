<?php
include 'connection.php';

// Consulta SQL para buscar todos os processos seletivos únicos
$sql_processos_seletivos = "SELECT DISTINCT processo_seletivo FROM inscritos";
$result_processos_seletivos = $conn->query($sql_processos_seletivos);

// Inicialização das variáveis de filtragem
$filter_nusp = isset($_GET['nusp']) ? $_GET['nusp'] : '';
$filter_nome = isset($_GET['nome']) ? $_GET['nome'] : '';
$filter_processo_seletivo = isset($_GET['processo_seletivo']) ? $_GET['processo_seletivo'] : '';

// Consulta SQL com base nos filtros fornecidos
$sql = "SELECT c.nusp, c.nome, c.sobrenome, GROUP_CONCAT(i.processo_seletivo SEPARATOR ', ') AS processos_seletivos
        FROM cadastrados c
        LEFT JOIN inscritos i ON c.nusp = i.nusp
        WHERE (c.nusp LIKE '%$filter_nusp%' OR '$filter_nusp' = '')
        AND (CONCAT(c.nome, ' ', c.sobrenome) LIKE '%$filter_nome%' OR '$filter_nome' = '')
        AND (i.processo_seletivo LIKE '%$filter_processo_seletivo%' OR '$filter_processo_seletivo' = '')
        GROUP BY c.nusp, c.nome, c.sobrenome";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Candidato</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
    <link rel="stylesheet" href="form.css">
</head>
<div class="header">
<div class="container">
  <a class="logo" href="menu_avaliador.html">
    <img src="logo_pj.png" alt="Logo da Empresa">
  </a>
  <div class="title">
    <h1>Avaliação de Candidatos</h1>
  </div>
</div>
</div>
<body>
<div class="container">
    <form action="avaliacao_buscar.php" method="get">
    <div class="input-group">
    <div class="input-third">
        <label for="nusp">NUSP:</label>
        <input type="text" id="nusp" name="nusp" value="<?php echo htmlspecialchars($filter_nusp); ?>" placeholder="Filtrar por NUSP">
        <br>
    </div>
    <div class="input-third">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($filter_nome); ?>" placeholder="Filtrar por Nome">
        <br>
    </div>
    <div class="input-third">
        <label for="processo_seletivo">Processo Seletivo:</label>
        <select id="processo_seletivo" name="processo_seletivo">
            <option value="">Todos os Processos Seletivos</option>
            <?php while($row_processo_seletivo = $result_processos_seletivos->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row_processo_seletivo['processo_seletivo']); ?>" <?php if ($filter_processo_seletivo == $row_processo_seletivo['processo_seletivo']) echo 'selected'; ?>><?php echo htmlspecialchars($row_processo_seletivo['processo_seletivo']); ?></option>
            <?php endwhile; ?>
        </select>
        <br>
    </div>
    </div>
        <input type="submit" name="submit" value="Filtrar">
    </form>

    <h2>Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>NUSP</th>
                <th>Nome Completo</th>
                <th>Processos Seletivos Inscritos</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nusp']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome'] . ' ' . $row['sobrenome']); ?></td>
                        <td>
                            <?php
                            // Divida a string $row['processos_seletivos'] em um array usando a vírgula como delimitador
                            $processos_seletivos = explode(', ', $row['processos_seletivos']);
                            
                            // Percorra o array de processos seletivos
                            foreach ($processos_seletivos as $processo_seletivo) {
                                // Crie o link para cada processo seletivo
                                echo "<a href='candidato.php?nusp=" . htmlspecialchars($row['nusp']) . "&processo_seletivo=" . htmlspecialchars($processo_seletivo) . "'>" . htmlspecialchars($processo_seletivo) . "</a><br>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Nenhum candidato encontrado com os critérios de busca fornecidos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="container" style="text-align: center;">
    <a href="menu_avaliador.html" style="font-size: 12px;">Voltar para a página inicial</a>
  </div>
</div>
</body>
</html>