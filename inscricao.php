<?php
include 'connection.php';

// Para criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);
// Para checar a conexão
if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['submit'])) {
    $nusp = $_POST['nusp'];
    $senha = $_POST['senha'];
    $nucleo_de_interesse = $_POST['nucleo_de_interesse'];
    $processo_seletivo = $_POST['processo_seletivo'];
    $conheceu_pj = $_POST['conheceu_pj'];	

    // Previne SQL Injection
    $nusp = $conn->real_escape_string($nusp);
    $senha = $conn->real_escape_string($senha);
    $nucleo_de_interesse = $conn->real_escape_string($nucleo_de_interesse);
    $processo_seletivo = $conn->real_escape_string($processo_seletivo);

    // Verifica se o par nusp e senha está na tabela cadastrados
    $sql = "SELECT * FROM cadastrados WHERE nusp='$nusp' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verifica se já existe uma inscrição para este NUSP e processo seletivo
        $stmt = $conn->prepare("SELECT * FROM inscritos WHERE nusp = ? AND processo_seletivo = ?");
        $stmt->bind_param("is", $nusp, $processo_seletivo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Insere os dados na tabela inscritos
            // Obter a data atual
            // Obter a data atual (ano-mês-dia)
            $data_inscricao = date("Y-m-d");

            // Inserir os dados na tabela inscritos, incluindo a data de inscrição
            $stmt = $conn->prepare("INSERT INTO inscritos (nusp, nucleo_de_interesse, processo_seletivo, data_inscricao, conheceu_pj) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $nusp, $nucleo_de_interesse, $processo_seletivo, $data_inscricao, $conheceu_pj);

            if ($stmt->execute()) {
                $message = "Inscrição realizada com sucesso.";
            } else {
                $message = "Erro ao realizar inscrição: " . $stmt->error;
            }
        } else {
            $message = "Você já está inscrito neste processo seletivo.";
        }
    } else {
        $message = "NUSP ou senha incorretos.";
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
<title>Formulário de Candidato</title>
<link rel="stylesheet" href="form.css">
</head>
<body>

<div class="header">
<div class="container">
  <a class="logo" href="menu_candidato.html">
    <img src="logo_pj.png" alt="Logo da Empresa">
  </a>
  <div class="title">
    <h1>Formulário de Inscrição</h1>
  </div>
</div>
</div>

<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="input-group">
    <div class="input-half">
      <label for="nusp">Número USP:</label>
      <input type="text" id="nusp" name="nusp" required>
    </div>
    <div class="input-half">
      <label for="senha">Senha:</label>
      <input type="text" id="senha" name="senha" required>
    </div>
  </div>
  <div class="input-group">
    <div class="input-third">
      <label for="curso">Núcleo de Interesse:</label>
        <select id="nucleo_de_interesse" name="nucleo_de_interesse" required>
          <option value="" disabled selected>Selecione</option>
          <option value="Núcleo de Análise e Inteligência de Dados">Núcleo de Análise e Inteligência de Dados</option>
          <option value="Núcleo de Consultoria Estratégica e Negócios">Núcleo de Consultoria Estratégica e Negócios</option>
          <option value="Núcleo de Engenharia Civil">Núcleo de Engenharia Civil</option>
          <option value="Núcleo de Tecnologia e Inovação">Núcleo de Tecnologia e Inovação</option>
        </select>
    </div>
    <div class="input-third">
      <label for="Processo Seletivo">Processo Seletivo:</label>
        <select id="processo_seletivo" name="processo_seletivo" required>
          <option value="" disabled selected>Selecione</option>
          <option value="24.0">24.0</option>
          <option value="24.1">24.1</option>
          <option value="24.2">24.2</option>
        </select>
    </div>
    <div class="input-third">
      <label for="Como soube do Processo Seletivo">Como soube do Processo Seletivo:</label>
        <select id="conheceu_pj" name="conheceu_pj" required>
          <option value="" disabled selected>Selecione</option>
          <option value="Whatsapp">Whatsapp</option>
          <option value="Instagram">Instagram</option>
          <option value="Panfletos">Panfletos</option>
          <option value="PJ Day">PJ Day</option>
          <option value="WI - Workshop Integrativo">WI - Workshop Integrativo</option>
          <option value="Algum Membro do Poli Júnior">Algum Membro da Poli Júnior</option>
          <option value="Outro">Outro</option>
        </select>
    </div>
  </div>

  <input type="submit" name="submit" value="Enviar">

  <div class="container" style="text-align: center;">
    <a href="menu_candidato.html" style="font-size: 12px;">Voltar para a página inicial</a>
  </div>
</form>

<?php
if (!empty($message)) {
  echo '<div style="text-align: center; margin-top: 20px;">' . $message . '</div>';
}
?>

</div>
</body>
</html>
