<?php
include 'connection.php';

// Para criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);
// Para checar a conexão
if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

$eventMessage = "";
$noticeMessage = "";

if (isset($_POST['submit_event'])) {
    $processo_seletivo = $_POST['processo_seletivo'];
    $evento = $_POST['evento'];
    $data = $_POST['data'];

    // Previne SQL Injection
    $processo_seletivo = $conn->real_escape_string($processo_seletivo);
    $evento = $conn->real_escape_string($evento);
    $data = $conn->real_escape_string($data);

    // Insere os dados na tabela datas_comuns
    $stmt = $conn->prepare("INSERT INTO datas_comuns (processo_seletivo, evento, data) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $processo_seletivo, $evento, $data);

    if ($stmt->execute()) {
        $eventMessage = "Horário do evento definido com sucesso.";
    } else {
        $eventMessage = "Erro ao definir horário do evento: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_POST['submit_notice'])) {
    $titulo = $_POST['titulo'];
    $aviso = $_POST['aviso'];
    $processo_seletivo = $_POST['processo_seletivo'];

    // Previne SQL Injection
    $titulo = $conn->real_escape_string($titulo);
    $aviso = $conn->real_escape_string($aviso);
    $processo_seletivo = $conn->real_escape_string($processo_seletivo);

    // Obter a data e a hora atuais
    $data_emissao = date("Y-m-d");

    // Insere os dados na tabela avisos
    $stmt = $conn->prepare("INSERT INTO avisos (titulo, aviso, processo_seletivo, data) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $aviso, $processo_seletivo, $data_emissao);

    if ($stmt->execute()) {
        $noticeMessage = "Aviso enviado com sucesso.";
    } else {
        $noticeMessage = "Erro ao enviar aviso: " . $stmt->error;
    }

    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Avisos e Horários</title>
<link rel="stylesheet" href="avisos_horarios.css">
</head>
<body>

<div class="header">
<div class="container">
  <a class="logo" href="menu_avaliador.html">
    <img src="logo_pj.png" alt="Logo da Empresa">
  </a>
  <div class="title">
    <h1>Avisos e Horários Gerais</h1>
  </div>
</div>
</div>

<div class="container">
  <!-- Formulário para definir horários -->
  <h2>Definir Horários para Eventos</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="input-group">
      <div class="input-third">
        <label for="processo_seletivo">Processo Seletivo:</label>
        <select id="processo_seletivo" name="processo_seletivo" required>
          <option value="" disabled selected>Selecione</option>
          <option value="24.0">24.0</option>
          <option value="24.1">24.1</option>
          <option value="24.2">24.2</option>
        </select>
      </div>
      <div class="input-third">
        <label for="evento">Evento:</label>
        <select id="evento" name="evento" required>
          <option value="" disabled selected>Selecione</option>
          <option value="Palestra Institucional">Palestra Institucional</option>
          <option value="Slides Pessoais">Slides Pessoais</option>
        </select>
      </div>
      <div class="input-third">
        <label for="data">Data (dia e horário):</label>
        <input type="datetime-local" id="data" name="data" required>
      </div>
    </div>
    <input type="submit" name="submit_event" value="Definir Horário">
  </form>

  <?php
  if (!empty($eventMessage)) {
    echo '<div style="text-align: center; margin-top: 20px;">' . $eventMessage . '</div>';
  }
  ?>
</div>

<div class="container">
      <!-- Formulário para enviar avisos -->
  <h2>Enviar Avisos</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="input-group">
    <div class="input-half">
      <label for="processo_seletivo">Processo Seletivo:</label>
      <select id="processo_seletivo" name="processo_seletivo" required>
        <option value="" disabled selected>Selecione</option>
        <option value="24.0">24.0</option>
        <option value="24.1">24.1</option>
        <option value="24.2">24.2</option>
      </select>
    </div>
    <div class="input-half">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" maxlength="20" required>
      </div>
    </div>
    <div class="input-group">
        <label for="aviso">Aviso:</label>
        <textarea id="aviso" name="aviso" maxlength="200" rows="4" cols="50" required></textarea>
    </div>
    <input type="submit" name="submit_notice" value="Enviar Aviso">

    <div class="container" style="text-align: center;">
    <a href="menu_avaliador.html" style="font-size: 12px;">Voltar para a página inicial</a>
  </div>
  </form>

  <?php
  if (!empty($noticeMessage)) {
    echo '<div style="text-align: center; margin-top: 20px;">' . $noticeMessage . '</div>';
  }
  ?>

</div>
</body>
</html>
