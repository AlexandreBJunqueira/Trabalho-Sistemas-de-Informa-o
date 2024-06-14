<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login.php");
    exit();
}

// Inclui o arquivo de conexão com o banco de dados
include 'connection.php';

// Obtém o nusp da sessão e o processo seletivo da URL
$nusp = $_SESSION['nusp'];
$processo_seletivo = $_GET['processo_seletivo'];

// Busca os dados do processo seletivo para o usuário
$sql = "SELECT palestra_institucional, slides_pessoal, dinamica_em_grupo, entrevista, 
               feedback_slides_pessoal, feedback_dinamica_em_grupo, feedback_entrevista,
               data_dinamica_em_grupo, data_entrevista
        FROM inscritos 
        WHERE nusp = ? AND processo_seletivo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $nusp, $processo_seletivo);
$stmt->execute();
$result = $stmt->get_result();
$inscrito = $result->fetch_assoc();

if (!$inscrito) {
    echo "Nenhum dado encontrado para o inscrito.";
    exit();
}

$stmt->close();

// Busca as datas gerais
$sql_geral = "SELECT evento, `data` 
              FROM datas_comuns 
              WHERE processo_seletivo = ?";
$stmt_geral = $conn->prepare($sql_geral);
$stmt_geral->bind_param("s", $processo_seletivo);
$stmt_geral->execute();
$result_geral = $stmt_geral->get_result();

$datas_gerais = [];
while ($row = $result_geral->fetch_assoc()) {
    $datas_gerais[$row['evento']] = $row['data'];
}

$stmt_geral->close();

$sql_avisos = "SELECT titulo, aviso FROM avisos WHERE processo_seletivo = ? ORDER BY id DESC";
$stmt_avisos = $conn->prepare($sql_avisos);
$stmt_avisos->bind_param("s", $processo_seletivo);
$stmt_avisos->execute();
$result_avisos = $stmt_avisos->get_result();

$stmt_avisos->close();
$conn->close();

// Definir valores padrão se as datas não estiverem definidas
$datas_gerais['Palestra Institucional'] = $datas_gerais['Palestra Institucional'] ?? '0000-00-00T00:00:00';
$datas_gerais['Slides Pessoais'] = $datas_gerais['Slides Pessoais'] ?? '0000-00-00T00:00:00';
$inscrito['data_dinamica_em_grupo'] = $inscrito['data_dinamica_em_grupo'] ?? '0000-00-00T00:00:00';
$inscrito['data_entrevista'] = $inscrito['data_entrevista'] ?? '0000-00-00T00:00:00';

// Função para verificar se uma etapa está "Reprovada" com base no feedback
function getStatus($status, $feedback) {
    if ($status == 0 && !empty($feedback)) {
        return 'Reprovado';
    }
    return $status ? 'Aprovado' : 'Aguardando';
}

function getStatusPalestra($status) {
    return $status ? 'Compareceu' : 'Não Compareceu';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acompanhar Processo Seletivo</title>
<link rel="stylesheet" href="form.css">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<style>
    /* Estilo para a tabela */
    table {
        width: 60%;
        border-collapse: collapse;
        margin: 0 auto;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }

    /* Estilo para o calendário */
    #calendar {
        width: 700px;
        margin: 20px auto;
    }
    
    footer {
        background-color: #004E95;
        color: white;
        text-align: center;
        margin-top: 10px;
        padding: 10px 0;
    }

    td.text-center {
        text-align: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var events = [
            {
                title: 'Palestra Institucional',
                start: '<?php echo $datas_gerais['Palestra Institucional']; ?>',
                backgroundColor: '#004E95'
            },
            {
                title: 'Slides Pessoais',
                start: '<?php echo $datas_gerais['Slides Pessoais']; ?>',
                backgroundColor: '#004E95'
            },
            {
                title: 'Dinâmica de Grupo',
                start: '<?php echo $inscrito['data_dinamica_em_grupo']; ?>',
                backgroundColor: '#004E95'
            },
            {
                title: 'Entrevista',
                start: '<?php echo $inscrito['data_entrevista']; ?>',
                backgroundColor: '#004E95'
            }
        ];

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events
        });

        calendar.render();
    });
</script>
</head>
<body>

<div class="header">
    <div class="container">
        <a class="logo" href="menu_candidato_processos_seletivos.php">
            <img src="logo_pj.png" alt="Logo da Empresa">
        </a>
        <div class="title">
            <h1>Acompanhar Processo Seletivo</h1>
        </div>
    </div>
</div>

<h2>Etapas do Processo Seletivo</h2>
<table>
    <thead>
        <tr>
            <th>Etapas</th>
            <th>Resultados</th>
            <th>Feedbacks</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Palestra Institucional</td>
            <td><?php echo getStatusPalestra($inscrito['palestra_institucional'], ''); ?></td>
            <td>-</td>
        </tr>
        <tr>
            <td>Slides Pessoal</td>
            <td><?php echo getStatus($inscrito['slides_pessoal'], $inscrito['feedback_slides_pessoal']); ?></td>
            <td class="text-center">
                <?php 
                    $feedback = htmlspecialchars($inscrito['feedback_slides_pessoal']);
                    echo '<textarea class="feedback-textarea" rows="4" cols="50" readonly>' . $feedback . '</textarea>';
                ?>
            </td>
        </tr>
        <td>Dinâmica em Grupo</td>
            <td><?php echo getStatus($inscrito['dinamica_em_grupo'], $inscrito['feedback_dinamica_em_grupo']); ?></td>
            <td class="text-center">
                <?php 
                    $feedback = htmlspecialchars($inscrito['feedback_dinamica_em_grupo']);
                    echo '<textarea class="feedback-textarea" rows="4" cols="50" readonly>' . $feedback . '</textarea>';
                ?>
            </td>
        </tr>
        <tr>
            <td>Entrevista</td>
            <td><?php echo getStatus($inscrito['entrevista'], $inscrito['feedback_entrevista']); ?></td>
            <td class="text-center">
                <?php 
                    $feedback = htmlspecialchars($inscrito['feedback_entrevista']);
                    echo '<textarea class="feedback-textarea" rows="4" cols="50" readonly>' . $feedback . '</textarea>';
                ?>
            </td>
        </tr>
    </tbody>
</table>

<h2>Calendário de Etapas</h2>
<div id="calendar"></div>

<h2>Avisos Gerais</h2>
<table>
    <thead>
        <tr>
            <th>Assunto</th>
            <th>Aviso</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row_aviso = $result_avisos->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row_aviso['titulo']); ?></td>
            <td class="text-center">
                <?php 
                    $aviso = htmlspecialchars($row_aviso['aviso']);
                    echo '<textarea class="feedback-textarea" rows="4" cols="50" readonly>' . $aviso . '</textarea>';
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<footer>
    <p>© 2024 Poli Júnior. Todos os direitos reservados.</p>
</footer>
</body>
</html>