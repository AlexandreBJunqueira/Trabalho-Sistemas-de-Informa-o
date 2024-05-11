<?php
	$servername = "localhost";
	$username = "root";
	$password = "abj19032005";

	// Para criar a conexão
	$conn = new mysqli($servername, $username, $password);
	// Para checar a conexão
	if ($conn->connect_error) {
		die("A conexão falhou: " . $conn->connect_error);
	}

	// Para criar o banco de dados
	$sql = "CREATE DATABASE poli_junior";
	if ($conn->query($sql) === TRUE) {
		echo "O Banco de Dados foi criado com sucesso";
	} else {
		echo "Erro ao criar o Banco de Dados: " . $conn->error;
	}

	$conn->close();
?>

