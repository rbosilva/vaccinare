-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 06-Abr-2017 às 22:20
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaccinare`
--
CREATE DATABASE IF NOT EXISTS `vaccinare` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `vaccinare`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle_vacinas`
--

CREATE TABLE `controle_vacinas` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `crianca` int(11) NOT NULL,
  `vacina` int(11) NOT NULL,
  `dose` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `controle_vacinas`
--

INSERT INTO `controle_vacinas` (`id`, `data`, `horario`, `crianca`, `vacina`, `dose`) VALUES
(1, '2017-04-06', '17:19:00', 1, 1, 'Primeira'),
(2, '2017-04-06', '17:19:00', 2, 2, 'Primeira'),
(3, '2017-04-06', '17:20:00', 1, 3, 'Primeira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `criancas`
--

CREATE TABLE `criancas` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `idade` int(11) NOT NULL,
  `sexo` char(1) NOT NULL,
  `parto_natural` tinyint(1) NOT NULL,
  `mae` text NOT NULL,
  `cor_etnia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `criancas`
--

INSERT INTO `criancas` (`id`, `nome`, `idade`, `sexo`, `parto_natural`, `mae`, `cor_etnia`) VALUES
(1, 'Daniel', 8, 'M', 0, 'Joana', 'Branca'),
(2, 'Sofia', 7, 'F', 1, 'Helena', 'Parda');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `login` varchar(10) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `tentativas` int(11) NOT NULL DEFAULT '0',
  `bloqueado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `tentativas`, `bloqueado`) VALUES
(1, 'Teste', 'user', '$2a$08$ODUxNjg3MTMxNThkNTRkM.wCI/L63NSydug9NZcl88BmvZxqt6fgC', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vacinas`
--

CREATE TABLE `vacinas` (
  `id` int(11) NOT NULL,
  `lote` int(11) NOT NULL,
  `nome` text NOT NULL,
  `data_validade` date NOT NULL,
  `fornecedor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `vacinas`
--

INSERT INTO `vacinas` (`id`, `lote`, `nome`, `data_validade`, `fornecedor`) VALUES
(1, 123, 'Febre Amarela', '2018-10-26', 'Bio-Manguinhos'),
(2, 456, 'BCG', '2018-12-24', 'Sanofi'),
(3, 789, 'Tétano', '2018-03-07', 'BRL Vacinas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `controle_vacinas`
--
ALTER TABLE `controle_vacinas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crianca_2` (`crianca`,`vacina`,`dose`),
  ADD KEY `crianca` (`crianca`),
  ADD KEY `vacina` (`vacina`);

--
-- Indexes for table `criancas`
--
ALTER TABLE `criancas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `vacinas`
--
ALTER TABLE `vacinas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lote` (`lote`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `controle_vacinas`
--
ALTER TABLE `controle_vacinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `criancas`
--
ALTER TABLE `criancas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vacinas`
--
ALTER TABLE `vacinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `controle_vacinas`
--
ALTER TABLE `controle_vacinas`
  ADD CONSTRAINT `fk_criancas` FOREIGN KEY (`crianca`) REFERENCES `criancas` (`id`),
  ADD CONSTRAINT `fk_vacinas` FOREIGN KEY (`vacina`) REFERENCES `vacinas` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
