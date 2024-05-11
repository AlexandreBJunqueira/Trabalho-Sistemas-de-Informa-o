<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ps_policc";

	// Para criar a conexão
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Para checar a conexão
	if ($conn->connect_error) {
		die("A conexão falhou: " . $conn->connect_error);
	}

	// Inserir Dados
	if (isset($_POST['submit'])) {
		
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$telefone = $_POST['telefone'];
		$nusp = $_POST['nusp'];		
		$sql = "INSERT INTO candidatos (nome, email, telefone, nusp, id_situacao)
		VALUES ('$nome', '$email', '$telefone','$nusp',1)";

		if ($conn->query($sql) === TRUE) {
			echo "Dados guardados com sucesso.";
		}else{
			echo "Erro:". $sql . "<br>". $conn->error;
		}
		
		$conn->close();
	}
	
?>


<!DOCTYPE html>
<html>
<head>
	<title>POLI JÚNIOR</title>
	<meta charset="UTF-8">
	<style type="text/css">
		body {
			font-family: Arial, sans-serif;
			background-color: rgb(5, 24, 42);
		}
		h1 {
			text-align: center;
			margin-top: 50px;
			margin-bottom: 20px;
			color: #FFF;
		}
		form {
			margin: 0 auto;
			padding: 30px;
			border-radius: 10px;
			background-color: #FFF;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			max-width: 600px;
		}
		label {
			display: block;
			font-weight: bold;
			margin-bottom: 10px;
			color: #555;
		}
		input[type="text"], input[type="email"], textarea {
			display: block;
			margin-bottom: 20px;
			padding: 10px;
			border: 2px solid #DDD;
			border-radius: 5px;
			font-size: 16px;
			width: 100%;
			box-sizing: border-box;
		}
		input[type="submit"] {
			background-color: #26A69A;
			color: #FFF;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			cursor: pointer;
			transition: background-color 0.3s;
		}
		input[type="submit"]:hover {
			background-color: #009688;
		}
	</style>
</head>
<body>
<h2>Insira novos dados</h2>

<form action="" method="POST">
  <fieldset>
	  <legend>Guest:</legend>

	  <label for="nome">Nome:</label><br>
	  <input type="text" id="nome" name="nome"><br><br>
	  <label for="email">Email:</label><br>
	  <input type="email" id="email" name="email"><br><br>
	  <label for="telefone">Telefone:</label><br>
	  <input type="text" id="telefone" name="telefone"><br><br>
	  <label for="nusp">NUSP:</label><br>
	  <input type="text" id="nusp" name="nusp"><br><br>
		<label for="data">Disponibilidades:</label>
		<select name="data" id="data">
        <option value="opcao1">16/02/2023</option>
        <option value="opcao2">17/02/2023</option>
        <option value="opcao3">18/02/2023</option>
		</select>
	  <input type="submit" name="submit" value="Submit">
  </fieldset>
</form>

</body>
</html>
