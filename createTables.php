<?php

include 'connection.php';

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificando a conexão
if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

// Criação da tabela
$sql = "CREATE TABLE candidatos (
    id_candidato INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(20) NOT NULL,
    sobrenome VARCHAR(20) NOT NULL,
    email VARCHAR(128) NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    nusp INT NOT NULL,
    data_de_nascimento DATE NOT NULL,
    ano_de_ingresso INT NOT NULL,
    nucleo_de_interesse VARCHAR(6) NOT NULL,
    curso VARCHAR(50) NOT NULL,
    sexualidade VARCHAR(20) NOT NULL,
    vulnerabilidade_socioeconomica BOOLEAN,
    genero VARCHAR(30) NOT NULL,
    etnia VARCHAR(30) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'candidatos' criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Fecha a conexão
$conn->close();

?>
