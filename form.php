<?php
	include 'connection.php';

	// Para criar a conexão
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Para checar a conexão
	if ($conn->connect_error) {
		die("A conexão falhou: " . $conn->connect_error);
	}

	// Inserir Dados
	if (isset($_POST['submit'])) {
		
		$nome = $_POST['nome'];
		$sobrenome = $_POST['sobrenome'];
		$email = $_POST['email'];
		$telefone = $_POST['telefone'];
		$nusp = $_POST['nusp'];
		$data_de_nascimento = $_POST['data_de_nascimento'];
		$data_de_nascimento_formatada = date('Y-m-d', strtotime(str_replace('/', '-', $data_de_nascimento)));
		$ano_de_ingresso = $_POST['ano_de_ingresso'];
		$nucleo_de_interesse = $_POST['nucleo_de_interesse'];
		$curso = $_POST['curso'];
		$sexualidade = $_POST['sexualidade'];
		$vulnerabilidade_socioeconomica = $_POST['vulnerabilidade_socioeconomica'] == '1' ? 1 : 0;
		$genero = $_POST['genero'];
		$etnia = $_POST['etnia'];				
    $senha = $_POST['senha'];	

    // Verificar se o número USP já existe na base de dados
    $nusp_existente = $_POST['nusp'];
    $verificar_sql = "SELECT nusp FROM candidatos WHERE nusp = '$nusp_existente'";
    $resultado = $conn->query($verificar_sql);

    if ($resultado->num_rows > 0) {
      // O número USP já existe na base de dados, então recuse a inscrição
      $error_message = "Número USP já cadastrado. Por favor, insira um número USP diferente.";
    } else {
    // O número USP não existe na base de dados, então prossiga com a inserção dos dados
    // Inserir Dados
    if (isset($_POST['submit'])) {
      $sql = "INSERT INTO candidatos (nome, sobrenome, email, telefone, nusp, data_de_nascimento, ano_de_ingresso, nucleo_de_interesse, curso, sexualidade, vulnerabilidade_socioeconomica, genero, etnia, senha)
      VALUES ('$nome', '$sobrenome', '$email', '$telefone','$nusp', '$data_de_nascimento_formatada', '$ano_de_ingresso', '$nucleo_de_interesse', '$curso', '$sexualidade', '$vulnerabilidade_socioeconomica', '$genero', '$etnia', '$senha')";
  
      if ($conn->query($sql) === TRUE) {
        echo "Dados guardados com sucesso.";
      }else{
        echo "Erro:". $sql . "<br>". $conn->error;
      }
    }
}
		
		$conn->close();
	}
	
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
  <div class="logo">
    <img src="logo_pj.png" alt="Logo da Empresa">
  </div>
  <div class="title">
    <h1>Formulário de Candidatos</h1>
  </div>
</div>
</div>

<div class="container">

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <div class="input-group">
    <div class="input-third">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required>
    </div>
    <div class="input-third">
      <label for="sobrenome">Sobrenome:</label>
      <input type="text" id="sobrenome" name="sobrenome" required>
    </div>
    <div class="input-third">
      <label for="data_de_nascimento">Data de Nascimento:</label>
      <input type="date" id="data_de_nascimento" name="data_de_nascimento" required>
    </div>
  </div>

  <div class="input-group">
  	<div class="input-third">
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>
	</div>
    <div class="input-third">
      <label for="telefone">Telefone:</label>
      <input type="text" id="telefone" name="telefone" required>
    </div>
    <div class="input-third">
      <label for="nusp">NUSP:</label>
      <input type="text" id="nusp" name="nusp" pattern="[0-9]*" required>
    </div>
  </div>

  <div class="input-group">
    <div class="input-half">
      <label for="curso">Curso:</label>
      <select id="curso" name="curso" required>
        <option value="" disabled selected>Selecione</option>
        <option value="Engenharia Ambiental">Engenharia Ambiental</option>
        <option value="Engenharia Civil">Engenharia Civil</option>
        <option value="Engenharia da Computação">Engenharia da Computação</option>
        <option value="Engenharia de Minas">Engenharia de Minas</option>
        <option value="Engenharia de Petróleo">Engenharia de Petróleo</option>
        <option value="Engenharia Naval">Engenharia Naval</option>
        <option value="Engenharia Metalúrgica">Engenharia Metalúrgica</option>
        <option value="Engenharia de Produção">Engenharia de Produção</option>
        <option value="Engenharia Elétrica">Engenharia Elétrica</option>
        <option value="Engenharia Eletrônica">Engenharia Eletrônica</option>
        <option value="Engenharia Mecânica">Engenharia Mecânica</option>
        <option value="Engenharia Mecatrônica">Engenharia Mecatrônica</option>
        <option value="Engenharia de Materiais">Engenharia de Materiais</option>
        <option value="Engenharia Química">Engenharia Química</option>
      </select>
    </div>
    <div class="input-half">
      <label for="ano_de_ingresso">Ano de Ingresso:</label>
      <input type="number" id="ano_de_ingresso" name="ano_de_ingresso" required>
    </div>
  </div>

  <div class="diversidade-section">
    <h3>Diversidade</h3>
    <div class="input-group">
    <div class="input-quarter">
      <label for="sexualidade">Sexualidade:</label>
        <select id="sexualidade" name="sexualidade" required>
          <option value="" disabled selected>Selecione</option>
          <option value="Heterossexual">Heterossexual</option>
          <option value="Homossexual">Homossexual</option>
          <option value="Bissexual">Bissexual</option>
          <option value="Pansexual">Pansexual</option>
          <option value="Assexual">Assexual</option>
          <option value="Outra">Outra</option>
        </select>
      </div>

      <div class="input-quarter">
        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required>
          <option value="" disabled selected>Selecione</option>
          <option value="Masculino">Masculino</option>
          <option value="Feminino">Feminino</option>
          <option value="Não-binário">Não-binário</option>
          <option value="Gênero fluido">Gênero fluido</option>
          <option value="Travesti">Travesti</option>
          <option value="Transgênero">Transgênero</option>
          <option value="Outro">Outro</option>
        </select>
      </div>
      <div class="input-quarter">
        <label for="vulnerabilidade_socioeconomica">Vulnerabilidade Socioeconômica:</label>
        <select id="vulnerabilidade_socioeconomica" name="vulnerabilidade_socioeconomica" required>
          <option value="" disabled selected>Selecione</option>
          <option value="1">Sim</option>
          <option value="0">Não</option>
        </select>
      </div>
      <div class="input-quarter">
      <label for="etnia">Etnia:</label>
        <select id="etnia" name="etnia" required>
          <option value="" disabled selected>Selecione</option>
          <option value="Branco">Branco</option>
          <option value="Negro">Negro</option>
          <option value="Pardo">Pardo</option>
          <option value="Amarelo">Amarelo</option>
          <option value="Indígena">Indígena</option>
          <option value="Outra">Outra</option>
        </select>
    </div>

    </div>
  </div>

  <div class="input-group">
    <div class="input-half">
      <label for="curso">Núcleo de Interesse:</label>
        <select id="nucleo_de_interesse" name="nucleo_de_interesse" required>
          <option value="" disabled selected>Selecione</option>
          <option value="Núcleo de Análise e Inteligência de Dados">Núcleo de Análise e Inteligência de Dados</option>
          <option value="Núcleo de Consultoria Estratégica e Negócios">Núcleo de Consultoria Estratégica e Negócios</option>
          <option value="Núcleo de Engenharia Civil">Núcleo de Engenharia Civil</option>
          <option value="Núcleo de Tecnologia e Inovação">Núcleo de Tecnologia e Inovação</option>
        </select>
    </div>
    <div class="input-half">
      <label for="curso">Defina sua Senha:</label>
      <input type="text" id="senha" name="senha" required>
    </div>
  </div>

  <input type="submit" name="submit" value="Enviar">

  <div class="container" style="text-align: center;">
    <a href="inicial_10.html" style="font-size: 12px;">Voltar para a página inicial</a>
  </div>
</form>

<?php
if (isset($error_message)) {
  echo '<div style="text-align: center; margin-top: 20px;">' . $error_message . '</div>';
}
?>

</div>

</body>
</html>


<script>
document.getElementById('telefone').addEventListener('input', function (e) {
  var telefone = e.target.value.replace(/\D/g, '').substring(0, 11);
  var formatacao = telefone.match(/^(\d{2})(\d{5})(\d{4})$/);

  if (formatacao) {
    e.target.value = '(' + formatacao[1] + ') ' + formatacao[2] + '-' + formatacao[3];
  } else {
    e.target.value = telefone;
  }
});
</script>