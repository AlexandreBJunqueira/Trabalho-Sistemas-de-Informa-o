<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	// Para criar a conexão
	$conn = new mysqli($servername, $username, $password);
	// Para checar a conexão
	if ($conn->connect_error) {
		die("A conexão falhou: " . $conn->connect_error);
	}

	// Para criar o banco de dados
	$sql = "CREATE DATABASE ps_policc";
	if ($conn->query($sql) === TRUE) {
		echo "O Banco de Dados foi criado com sucesso";
	} else {
		echo "Erro ao criar o Banco de Dados: " . $conn->error;
	}

	$conn->close();
?>

