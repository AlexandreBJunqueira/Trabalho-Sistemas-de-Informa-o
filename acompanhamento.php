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
$sql = "SELECT palestra_institucional, slides_pessoal, dinamica_em_grupo, entrevista, feedback_slides_pessoal, feedback_dinamica_em_grupo, feedback_entrevista 
        FROM inscritos 
        WHERE nusp = ? AND processo_seletivo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $nusp, $processo_seletivo);
$stmt->execute();
$result = $stmt->get_result();
$inscrito = $result->fetch_assoc();

// Função para verificar se uma etapa está "Reprovada" com base no feedback
function getStatus($status, $feedback) {
    if ($status == 0 && !empty($feedback)) {
        return 'Reprovado';
    }
    return $status ? 'Aprovado' : 'Aguardando';
}

function getStatusPalestra($status, $feedback) {
    return $status ? 'Compareceu' : 'Não Compareceu';
}

$stmt->close();
$conn->close();
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
        padding: 10px 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
  
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
        {
          title: 'Entrevista Inicial',
          start: '2024-05-15',
          backgroundColor: '#004E95' 
        },
        {
          title: 'Avaliação Técnica',
          start: '2024-05-20',
          backgroundColor: '#004E95' 
        },
        {
          title: 'Dinâmica de Grupo',
          start: '2024-05-25',
          backgroundColor: '#004E95'
        }
      ]
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
            <td>
                <?php 
                    $feedback = htmlspecialchars($inscrito['feedback_slides_pessoal']);
                    echo '<textarea class="feedback-textarea" rows="4" cols="50" readonly>' . $feedback . '</textarea>';
                ?>
            </td>
        </tr>
        <td>Dinâmica em Grupo</td>
            <td><?php echo getStatus($inscrito['dinamica_em_grupo'], $inscrito['feedback_dinamica_em_grupo']); ?></td>
            <td>
                <?php 
                    $feedback = htmlspecialchars($inscrito['feedback_dinamica_em_grupo']);
                    echo '<textarea class="feedback-textarea" rows="4" cols="50" readonly>' . $feedback . '</textarea>';
                ?>
            </td>
        </tr>
        <tr>
            <td>Entrevista</td>
            <td><?php echo getStatus($inscrito['entrevista'], $inscrito['feedback_entrevista']); ?></td>
            <td>
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

<footer>
    <p>© 2024 Poli Júnior. Todos os direitos reservados.</p>
</footer>
</body>
</html>
