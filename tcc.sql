-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18-Nov-2019 às 17:05
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ponto`
--

CREATE TABLE `ponto` (
  `hora1` time NOT NULL,
  `hora2` time NOT NULL,
  `data` date NOT NULL,
  `id` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `obs_entra` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ponto`
--

INSERT INTO `ponto` (`hora1`, `hora2`, `data`, `id`, `id_usuarios`, `obs_entra`) VALUES
('08:20:50', '12:10:15', '2019-11-01', 1, 2, ''),
('13:30:40', '18:00:00', '2019-11-01', 2, 2, ''),
('08:48:40', '12:00:00', '2019-11-02', 3, 2, ''),
('13:15:00', '18:05:00', '2019-11-02', 4, 2, ''),
('08:48:41', '11:59:00', '2019-11-03', 5, 2, ''),
('13:15:42', '17:58:25', '2019-11-03', 6, 2, ''),
('08:32:00', '11:58:12', '2019-11-04', 7, 2, ''),
('13:35:00', '17:50:20', '2019-11-04', 8, 2, ''),
('08:48:43', '12:01:41', '2019-11-05', 9, 2, ''),
('13:22:10', '18:01:11', '2019-11-05', 10, 2, ''),
('08:23:12', '12:02:14', '2019-11-06', 11, 2, ''),
('13:05:16', '17:40:29', '2019-11-06', 12, 2, ''),
('08:12:35', '12:19:56', '2019-11-07', 13, 2, ''),
('13:31:16', '17:59:54', '2019-11-07', 14, 2, ''),
('08:13:26', '12:00:59', '2019-11-08', 15, 2, ''),
('13:52:25', '17:19:15', '2019-11-08', 16, 2, ''),
('08:59:05', '12:16:29', '2019-11-09', 17, 2, ''),
('13:14:37', '17:45:01', '2019-11-09', 18, 2, ''),
('08:15:00', '11:50:00', '2019-11-10', 19, 2, ''),
('13:24:58', '18:02:51', '2019-11-10', 20, 2, ''),
('08:46:16', '12:12:18', '2019-11-11', 21, 2, ''),
('13:48:50', '17:43:30', '2019-11-11', 22, 2, ''),
('08:23:37', '12:02:49', '2019-11-12', 23, 2, ''),
('13:09:47', '17:27:08', '2019-11-12', 24, 2, ''),
('08:33:44', '12:12:34', '2019-11-13', 25, 2, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `Nome_completo` varchar(200) NOT NULL,
  `CPF` varchar(20) NOT NULL,
  `Data_admissao` date NOT NULL,
  `Salario_Contratual` varchar(100) NOT NULL,
  `funcao` varchar(50) NOT NULL,
  `carga_horaria` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `ultima_op` varchar(1) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`Nome_completo`, `CPF`, `Data_admissao`, `Salario_Contratual`, `funcao`, `carga_horaria`, `email`, `senha`, `ultima_op`, `id_usuario`) VALUES
('teste1', '123456789', '2019-11-01', 'R$2500,00', 'Admin', '8h/dia - 44/semanais - 220h/mensais', 'teste1@gmail.com', '25f9e794323b453885f5181f1b624d0b', '', 1),
('teste2', '123456789', '2019-11-02', 'R$1500,00', 'Vendedor', '8h/dia - 44/semanais - 220h/mensais', 'teste2@gmail.com', '25f9e794323b453885f5181f1b624d0b', 's', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ponto`
--
ALTER TABLE `ponto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuarios` (`id_usuarios`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ponto`
--
ALTER TABLE `ponto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `ponto`
--
ALTER TABLE `ponto`
  ADD CONSTRAINT `id_usuarios` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
