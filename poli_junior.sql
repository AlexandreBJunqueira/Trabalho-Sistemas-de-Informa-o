-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Jun-2024 às 23:52
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `poli_junior`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliadores`
--

CREATE TABLE `avaliadores` (
  `nusp` int(11) NOT NULL,
  `senha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliadores`
--

INSERT INTO `avaliadores` (`nusp`, `senha`) VALUES
(12345678, '12345678');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos`
--

CREATE TABLE `avisos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(20) NOT NULL,
  `aviso` varchar(200) NOT NULL,
  `processo_seletivo` varchar(4) NOT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avisos`
--

INSERT INTO `avisos` (`id`, `titulo`, `aviso`, `processo_seletivo`, `data`) VALUES
(1, 'Aviso Teste', 'Testando', '24.0', NULL),
(2, 'Testando', 'Novamente', '24.2', '2024-06-14'),
(3, 'Aviso Teste', 'Testando', '24.1', '2024-06-14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastrados`
--

CREATE TABLE `cadastrados` (
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `nusp` int(11) NOT NULL,
  `data_de_nascimento` date NOT NULL,
  `ano_de_ingresso` int(11) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `sexualidade` varchar(20) NOT NULL,
  `vulnerabilidade_socioeconomica` tinyint(1) DEFAULT NULL,
  `genero` varchar(30) NOT NULL,
  `etnia` varchar(30) NOT NULL,
  `senha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cadastrados`
--

INSERT INTO `cadastrados` (`nome`, `sobrenome`, `email`, `telefone`, `nusp`, `data_de_nascimento`, `ano_de_ingresso`, `curso`, `sexualidade`, `vulnerabilidade_socioeconomica`, `genero`, `etnia`, `senha`) VALUES
('Cauan', 'Kazama', 'cauan.kazama@polijunior.com.br', '(11) 11111-1111', 11111111, '2004-04-13', 2022, 'Engenharia da Computação', 'Homossexual', 1, 'Feminino', 'Pardo', 'cauankazama'),
('Rafael', 'Junqueira', 'rafael.junqueira@polijunior.com.br', '(34) 99999-9999', 12121212, '2003-09-19', 2022, 'Engenharia Ambiental', 'Heterossexual', 0, 'Masculino', 'Branco', 'rbj19092003'),
('Alexandre', 'Junqueira', 'alexandrebarsamjunqueira@gmail.com', '(34) 99222-0101', 12561642, '2005-03-19', 2023, 'Engenharia de Produção', 'Heterossexual', 0, 'Masculino', 'Branco', 'abj19032005');

-- --------------------------------------------------------

--
-- Estrutura da tabela `datas_comuns`
--

CREATE TABLE `datas_comuns` (
  `data` datetime NOT NULL,
  `processo_seletivo` varchar(4) NOT NULL,
  `evento` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `datas_comuns`
--

INSERT INTO `datas_comuns` (`data`, `processo_seletivo`, `evento`) VALUES
('2024-06-14 18:00:00', '24.1', 'Palestra Institucional');

-- --------------------------------------------------------

--
-- Estrutura da tabela `inscritos`
--

CREATE TABLE `inscritos` (
  `nusp` int(11) NOT NULL,
  `nucleo_de_interesse` varchar(50) NOT NULL,
  `processo_seletivo` varchar(4) NOT NULL,
  `palestra_institucional` tinyint(1) DEFAULT 0,
  `slides_pessoal` tinyint(1) DEFAULT 0,
  `dinamica_em_grupo` tinyint(1) DEFAULT 0,
  `entrevista` tinyint(1) DEFAULT 0,
  `data_inscricao` date DEFAULT NULL,
  `conheceu_pj` varchar(30) NOT NULL,
  `mentoria` tinyint(1) DEFAULT 0,
  `feedback_slides_pessoal` varchar(500) DEFAULT '',
  `feedback_dinamica_em_grupo` varchar(500) DEFAULT '',
  `feedback_entrevista` varchar(500) DEFAULT '',
  `data_dinamica_em_grupo` datetime DEFAULT NULL,
  `data_entrevista` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `inscritos`
--

INSERT INTO `inscritos` (`nusp`, `nucleo_de_interesse`, `processo_seletivo`, `palestra_institucional`, `slides_pessoal`, `dinamica_em_grupo`, `entrevista`, `data_inscricao`, `conheceu_pj`, `mentoria`, `feedback_slides_pessoal`, `feedback_dinamica_em_grupo`, `feedback_entrevista`, `data_dinamica_em_grupo`, `data_entrevista`) VALUES
(12561642, 'Núcleo de Análise e Inteligência de Dados', '24.0', 1, 1, 1, 0, '2024-06-06', 'Whatsapp', 0, 'Parabéns!', 'Parabéns!', 'Performou mal na etapa de estimation.', NULL, NULL),
(11111111, 'Núcleo de Tecnologia e Inovação', '24.2', 1, 1, 0, 0, '2024-06-06', 'PJ Day', 0, 'Ok', '', '', '2024-03-19 18:00:00', '0000-00-00 00:00:00'),
(12561642, 'Núcleo de Consultoria Estratégica e Negócios', '24.1', 0, 0, 0, 0, '2024-06-08', 'Panfletos', 0, '', '', '', NULL, NULL),
(12561642, 'Núcleo de Engenharia Civil', '24.2', 0, 0, 0, 0, '2024-06-22', 'PJ Day', 0, '', '', '', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliadores`
--
ALTER TABLE `avaliadores`
  ADD PRIMARY KEY (`nusp`);

--
-- Índices para tabela `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cadastrados`
--
ALTER TABLE `cadastrados`
  ADD PRIMARY KEY (`nusp`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
