-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Jul-2015 às 07:45
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gravadora`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cantor`
--

CREATE TABLE IF NOT EXISTS `cantor` (
  `codigo_cantor` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo_cantor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `cantor`
--

INSERT INTO `cantor` (`codigo_cantor`, `nome`) VALUES
(1, 'Zeze de Camargo e Luciano');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cd`
--

CREATE TABLE IF NOT EXISTS `cd` (
  `codigo_cd` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `data_lancamento` date NOT NULL,
  `cantor_fk` int(11) NOT NULL,
  PRIMARY KEY (`codigo_cd`),
  KEY `cantor_fk` (`cantor_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `cd`
--

INSERT INTO `cd` (`codigo_cd`, `titulo`, `data_lancamento`, `cantor_fk`) VALUES
(3, 'Teorias', '2014-06-03', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(32) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `login`, `nome`, `senha`) VALUES
(3, 'natanael', 'Natanael', '202cb962ac59075b964b07152d234b70'),
(4, 'rafael', 'Rafael', '202cb962ac59075b964b07152d234b70'),
(5, 'tulio', 'Tulio', '202cb962ac59075b964b07152d234b70');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cd`
--
ALTER TABLE `cd`
  ADD CONSTRAINT `cantor_fk` FOREIGN KEY (`cantor_fk`) REFERENCES `cantor` (`codigo_cantor`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
