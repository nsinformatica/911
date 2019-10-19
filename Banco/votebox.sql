-- --------------------------------------------------------
-- Servidor:                     mysql02-farm76.kinghost.net
-- Versão do servidor:           5.6.36-log - MySQL Community Server (GPL)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para votebox
CREATE DATABASE IF NOT EXISTS `votebox` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `votebox`;

-- Copiando estrutura para tabela votebox.tbl_contato
CREATE TABLE IF NOT EXISTS `tbl_contato` (
  `id_contato` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `mensagem` text,
  PRIMARY KEY (`id_contato`),
  KEY `fk_tbl_contato_tbl_usuario1_idx` (`id_usuario`),
  CONSTRAINT `fk_tbl_contato_tbl_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_ip_acesso
CREATE TABLE IF NOT EXISTS `tbl_ip_acesso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_acesso` varchar(100) DEFAULT '0',
  `data_acesso` date DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50285 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_itens_pergunta
CREATE TABLE IF NOT EXISTS `tbl_itens_pergunta` (
  `id_itens_pergunta` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `imagem` varchar(250) DEFAULT NULL,
  `descricao` varchar(250) DEFAULT NULL,
  `id_pergunta` int(11) NOT NULL,
  `acao` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_itens_pergunta`),
  KEY `id_pergunta_idx` (`id_pergunta`),
  CONSTRAINT `id_pergunta_itens` FOREIGN KEY (`id_pergunta`) REFERENCES `tbl_pergunta` (`id_pergunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_logging
CREATE TABLE IF NOT EXISTS `tbl_logging` (
  `id_logging` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(250) NOT NULL,
  `responsavel` varchar(100) NOT NULL,
  `data_criacao` time DEFAULT NULL,
  PRIMARY KEY (`id_logging`)
) ENGINE=InnoDB AUTO_INCREMENT=50700 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_pergunta
CREATE TABLE IF NOT EXISTS `tbl_pergunta` (
  `id_pergunta` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(11) DEFAULT NULL,
  `pergunta` varchar(200) DEFAULT NULL,
  `id_pesquisa` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `obrigatorio` int(11) DEFAULT NULL,
  `logica` int(11) DEFAULT NULL,
  `id_sessao` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pergunta`),
  KEY `id_pesquisa_idx` (`id_pesquisa`),
  KEY `id_sessao_pergunta_idx` (`id_sessao`),
  CONSTRAINT `id_pesquisa_pergunta` FOREIGN KEY (`id_pesquisa`) REFERENCES `tbl_pesquisa` (`id_pesquisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_sessao_pergunta` FOREIGN KEY (`id_sessao`) REFERENCES `tbl_sessao` (`id_sessao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_pesquisa
CREATE TABLE IF NOT EXISTS `tbl_pesquisa` (
  `id_pesquisa` int(11) NOT NULL AUTO_INCREMENT,
  `tema` int(11) DEFAULT NULL,
  `titulo` varchar(100) NOT NULL,
  `status` char(1) NOT NULL,
  `descricao` text,
  `imagem` varchar(250) DEFAULT NULL,
  `chave` varchar(32) DEFAULT NULL,
  `contador` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_criacao` date DEFAULT NULL,
  `analitics` varchar(45) DEFAULT NULL,
  `publicada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pesquisa`),
  KEY `id_usuario_pesquisa_idx` (`id_usuario`),
  CONSTRAINT `id_usuario_pesquisa` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_sessao
CREATE TABLE IF NOT EXISTS `tbl_sessao` (
  `id_sessao` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) DEFAULT NULL,
  `id_pesquisa` int(11) NOT NULL,
  PRIMARY KEY (`id_sessao`),
  KEY `fk_tbl_sessao_tbl_pesquisa1_idx` (`id_pesquisa`),
  CONSTRAINT `fk_tbl_sessao_tbl_pesquisa1` FOREIGN KEY (`id_pesquisa`) REFERENCES `tbl_pesquisa` (`id_pesquisa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_usuario
CREATE TABLE IF NOT EXISTS `tbl_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(30) DEFAULT NULL,
  `imagem` varchar(250) DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela votebox.tbl_voto
CREATE TABLE IF NOT EXISTS `tbl_voto` (
  `id_voto` int(11) NOT NULL AUTO_INCREMENT,
  `id_pergunta` int(11) NOT NULL,
  `id_item_pergunta` int(11) DEFAULT NULL,
  `escala` int(11) DEFAULT NULL,
  `texto` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id_voto`),
  KEY `id_pergunta_idx` (`id_pergunta`),
  KEY `id_item_pergunta_idx` (`id_item_pergunta`),
  CONSTRAINT `id_item_pergunta_voto` FOREIGN KEY (`id_item_pergunta`) REFERENCES `tbl_itens_pergunta` (`id_itens_pergunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_pergunta_voto` FOREIGN KEY (`id_pergunta`) REFERENCES `tbl_pergunta` (`id_pergunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50575 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
