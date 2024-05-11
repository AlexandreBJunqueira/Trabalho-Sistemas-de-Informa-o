<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ps_policc";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificando a conexão
if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

// Criando tabela situacao
$sql = "CREATE TABLE situacao (
    id_situacao INTEGER NOT NULL AUTO_INCREMENT,
    descricao VARCHAR(128) NOT NULL,
    PRIMARY KEY (id_situacao),
    INDEX (descricao)
)";

if ($conn->query($sql) === TRUE) {
    echo "A tabela situacao foi criada com sucesso";
} else {
    echo "Erro ao criar a tabela situacao: " . $conn->error;
}

// Criando tabela candidatos
$sql = "CREATE TABLE candidatos (
    id_candidato INTEGER NOT NULL AUTO_INCREMENT,
    nome VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    telefone VARCHAR(30) NOT NULL,
    nusp INT NOT NULL,
    id_situacao INTEGER,
    PRIMARY KEY (id_candidato),
    CONSTRAINT FOREIGN KEY (id_situacao) REFERENCES situacao(id_situacao) ON DELETE CASCADE ON UPDATE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "A tabela candidatos foi criada com sucesso";
} else {
    echo "Erro ao criar a tabela candidatos: " . $conn->error;
}

// Criando tabela disponibilidade
$sql = "CREATE TABLE disponibilidade (
    id_disp INTEGER NOT NULL AUTO_INCREMENT,
    id_candidato INTEGER,
    data DATE,
    PRIMARY KEY (id_disp),
    CONSTRAINT FOREIGN KEY (id_candidato) REFERENCES candidatos(id_candidato) ON DELETE CASCADE ON UPDATE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "A tabela disponibilidade foi criada com sucesso";
} else {
    echo "Erro ao criar a tabela disponibilidade: " . $conn->error;
}

// Criando tabela avaliadores
$sql = "CREATE TABLE avaliadores (
    id_avaliador INTEGER NOT NULL AUTO_INCREMENT,
    nome VARCHAR(128) NOT NULL,
    PRIMARY KEY (id_avaliador)
)";

if ($conn->query($sql) === TRUE) {
    echo "A tabela avaliadores foi criada com sucesso";
} else {
    echo "Erro ao criar a tabela avaliadores: " . $conn->error;
}

$conn->close();
?>
