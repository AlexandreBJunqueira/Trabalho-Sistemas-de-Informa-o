<?php

include 'connection.php';

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

// Criação da tabela 'cadastrados'
$sql = "CREATE TABLE cadastrados (
    nome VARCHAR(20) NOT NULL,
    sobrenome VARCHAR(20) NOT NULL,
    email VARCHAR(128) NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    nusp INT NOT NULL PRIMARY KEY,
    data_de_nascimento DATE NOT NULL,
    ano_de_ingresso INT NOT NULL,
    curso VARCHAR(50) NOT NULL,
    sexualidade VARCHAR(20) NOT NULL,
    vulnerabilidade_socioeconomica BOOLEAN,
    genero VARCHAR(30) NOT NULL,
    etnia VARCHAR(30) NOT NULL,
    senha VARCHAR(20) NOT NULL
);";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'cadastrados' criada com sucesso!";
} else {
    echo "Erro ao criar tabela 'cadastrados': " . $conn->error;
}

// Criação da tabela 'inscritos'
$sql = "CREATE TABLE inscritos (
    nusp INT NOT NULL,
    nucleo_de_interesse VARCHAR(50) NOT NULL,
    processo_seletivo VARCHAR(4) NOT NULL,
    palestra_institucional TINYINT(1) DEFAULT 0,
    slides_pessoal TINYINT(1) DEFAULT 0,
    dinamica_em_grupo TINYINT(1) DEFAULT 0,
    entrevista TINYINT(1) DEFAULT 0,
    data_inscrição DATE,
    conheceu_pj VARCHAR(30) NOT NULL,
    mentoria TINYINT(1) DEFAULT 0,
    feedback_slides_pesssoal VARCHAR(200) DEFAULT '',
    feedback_dinamica_em_grupo VARCHAR(200) DEFAULT '',
    feedback_entrevista VARCHAR(200) DEFAULT '',
    data_dinamica_em_grupo DATETIME,
    data_entrevista DATETIME,
    CONSTRAINT fk_nusp FOREIGN KEY (nusp) REFERENCES cadastrados(nusp)
);";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'inscritos' criada com sucesso!";
} else {
    echo "Erro ao criar tabela 'inscritos': " . $conn->error;
}

// Criação da tabela 'avaliadores'
$sql = "CREATE TABLE avaliadores (
    nusp INT NOT NULL PRIMARY KEY,
    senha VARCHAR(20) NOT NULL
);";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'avaliadores' criada com sucesso!";
} else {
    echo "Erro ao criar tabela 'avaliadores': " . $conn->error;
}

// Inserção de dados na tabela 'avaliadores'
$sql = "INSERT INTO avaliadores (nusp, senha) VALUES ('admin', 'admin');";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos na tabela 'avaliadores' com sucesso!";
} else {
    echo "Erro ao inserir dados na tabela 'avaliadores': " . $conn->error;
}

$sql = "CREATE TABLE datas_comuns (
    `data` DATETIME NOT NULL,
    processo_seletivo VARCHAR(4) NOT NULL,
    evento VARCHAR(30) NOT NULL
);";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'avaliadores' criada com sucesso!";
} else {
    echo "Erro ao criar tabela 'avaliadores': " . $conn->error;
}

$sql = "CREATE TABLE avisos (
    id INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(20) NOT NULL,
    aviso VARCHAR(200) NOT NULL,
    processo_seletivo VARCHAR(4) NOT NULL,
    `data` DATE,
    PRIMARY KEY (id)
);";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'avaliadores' criada com sucesso!";
} else {
    echo "Erro ao criar tabela 'avaliadores': " . $conn->error;
}

// Fecha a conexão
$conn->close();

?>