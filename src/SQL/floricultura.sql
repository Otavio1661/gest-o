-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/07/2025 às 16:27
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `floricultura`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixa`
--

CREATE TABLE `caixa` (
  `idcaixa` int(11) NOT NULL,
  `data` date NOT NULL,
  `tipo` enum('entrada','saida') NOT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nome`, `telefone`, `cpf`, `uf`, `cidade`, `bairro`, `rua`, `numero`, `ativo`) VALUES
(1, 'João Silva teste 3', '(11) 98765-4321', '123.456.789-00', 'SP', 'São Paulo', 'Centro2', 'Rua das Flores', '100', 1),
(4, 'Ana Paula Lima', '(41) 97654-3210', '456.789.123-22', 'PR', 'Curitiba', 'Batel', 'Alameda Dom Pedro II', '88', NULL),
(5, 'Fernando Costa', '(51) 93456-7890', '789.123.456-33', 'RS', 'Porto Alegre', 'Moinhos de Vento', 'Rua Padre Chagas', '120', NULL),
(6, 'Juliana Mendes', '(61) 99888-7777', '159.753.486-44', 'DF', 'Brasília', 'Asa Sul', 'SQS 308', '25', NULL),
(7, 'Pedro Henrique', '(71) 97777-8888', '258.369.147-55', 'BA', 'Salvador', 'Barra', 'Rua Almirante Barroso', '70', NULL),
(8, 'Luciana Ferreira', '(85) 96543-2100', '369.258.147-66', 'CE', 'Fortaleza', 'Meireles', 'Av. Beira Mar', '310', NULL),
(10, 'Camila Rocha', '(62) 91234-8765', '852.741.963-88', 'GO', 'Goiânia', 'Setor Bueno', 'Rua T-63', '135', NULL),
(18, 'aaaa', 'adfgdd', 'dfffdd', 'dd', 'ddddo', 'ddd', 'dddd', 'ddewd', 0),
(19, 'xxx', 'xxx', 'xxxx', 'xx', 'xxxx', 'xxxx', 'xxx', 'xxxxx', 1),
(20, 'Micaeli Escarante da Silva', '44984135206', '08589586944', 'pr', 'douradina', 'brooklin', 'são Paulo', '130', 1),
(21, 'Micaeli Escarante da Silva', '44984135206', '08589586944', 'pr', 'douradina', 'brooklin', 'são Paulo', '130', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_alteracoes_notinhas`
--

CREATE TABLE `log_alteracoes_notinhas` (
  `id` int(11) NOT NULL,
  `idnotinha` int(11) NOT NULL,
  `campo_alterado` varchar(100) NOT NULL,
  `valor_antigo` text DEFAULT NULL,
  `valor_novo` text DEFAULT NULL,
  `data_alteracao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `log_alteracoes_notinhas`
--

INSERT INTO `log_alteracoes_notinhas` (`id`, `idnotinha`, `campo_alterado`, `valor_antigo`, `valor_novo`, `data_alteracao`) VALUES
(26, 16, 'valor', '224.00', '', '2025-07-08 10:18:31'),
(27, 16, 'pago', '224.00', '1', '2025-07-08 10:18:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notinhas`
--

CREATE TABLE `notinhas` (
  `idnotinha` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `pago` tinyint(1) DEFAULT 0,
  `descricao` varchar(800) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notinhas`
--

INSERT INTO `notinhas` (`idnotinha`, `idcliente`, `data`, `valor`, `pago`, `descricao`) VALUES
(1, 1, '2025-06-10', 300.00, 0, 'Buquês de flores variadas (rosas, lírios, margaridas, etc.)\r\n\r\nArranjos florais para decoração (em vasos ou cestas)\r\n\r\nPlantas ornamentais em vasos (como suculentas, orquídeas, samambaias)\r\n\r\nVasos decorativos (de cerâmica, vidro, barro, etc.)\r\n\r\nAdubos e fertilizantes para flores\r\n\r\nFerramentas de jardinagem (tesouras de poda, pás pequenas, regadores)\r\n\r\nCartões para acompanhar os arranjos\r\n\r\nPresentes complementares (ursinhos de pelúcia, chocolates)\r\n\r\nLaços, fitas e papéis de embrulho\r\n\r\nServiço de entrega de flores'),
(2, 6, '2025-06-10', 103.00, 0, 'sdfg'),
(3, 6, '2025-06-10', 1234.00, 0, 'asdfghj'),
(4, 10, '2025-06-10', 12345.00, 0, '12345yasdfh'),
(5, 19, '2025-06-10', 123456.00, 0, 'xxxxxxx'),
(6, 19, '2025-06-13', 12345.00, 0, 'sdfgh'),
(7, 19, '2025-06-13', 52.00, 0, 'wergh'),
(8, 19, '2025-06-13', 52.00, 0, 'werfgh'),
(9, 18, '2025-06-13', 2345.00, 0, 'efgtgf'),
(10, 19, '2025-06-13', 2345.00, 0, 'efsgrtdbghn'),
(11, 10, '2025-06-13', 658.00, 0, 'sdfghbvcs'),
(12, 1, '2025-06-10', 12.00, 0, 'testexxxxxxxxxx'),
(13, 1, '2025-06-10', 12.00, 0, 'axxxxx'),
(14, 8, '2025-06-20', 220.00, 1, 'abc de fg'),
(15, 20, '2025-06-20', 0.00, 1, 'presentes'),
(16, 20, '2025-06-20', 0.00, 1, 'sabonete'),
(17, 18, '2025-07-07', 224.00, 0, 'xcvbnkytrd');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `idpagamento` int(11) NOT NULL,
  `idnotinha` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`idcaixa`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Índices de tabela `log_alteracoes_notinhas`
--
ALTER TABLE `log_alteracoes_notinhas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notinhas`
--
ALTER TABLE `notinhas`
  ADD PRIMARY KEY (`idnotinha`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`idpagamento`),
  ADD KEY `idnotinha` (`idnotinha`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `idcaixa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `log_alteracoes_notinhas`
--
ALTER TABLE `log_alteracoes_notinhas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `notinhas`
--
ALTER TABLE `notinhas`
  MODIFY `idnotinha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `idpagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `notinhas`
--
ALTER TABLE `notinhas`
  ADD CONSTRAINT `notinhas_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Restrições para tabelas `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`idnotinha`) REFERENCES `notinhas` (`idnotinha`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
