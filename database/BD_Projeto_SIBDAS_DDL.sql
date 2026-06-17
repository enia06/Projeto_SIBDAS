-- --------------------------------------------------------
-- Anfitrião:                    vsgate-s1.dei.isep.ipp.pt
-- Versão do servidor:           8.0.45 - MySQL Community Server - GPL
-- SO do servidor:               Linux
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para db1241327
CREATE DATABASE IF NOT EXISTS `db1241327` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db1241327`;

-- A despejar estrutura para tabela db1241327.bem_vindo_publico
CREATE TABLE IF NOT EXISTS `bem_vindo_publico` (
  `id_bem_vindo` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_bin,
  `data_criacao` datetime NOT NULL,
  `data_ultima_atualizacao` datetime NOT NULL,
  PRIMARY KEY (`id_bem_vindo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.contactos_publico
CREATE TABLE IF NOT EXISTS `contactos_publico` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `texto_introdutorio` text COLLATE utf8mb4_bin,
  `subtitulo_nome` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `subtitulo_email` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `subtitulo_mensagem` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `texto_botao` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `data_criacao` datetime NOT NULL,
  `data_ultima_atualizacao` datetime NOT NULL,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.criticidades
CREATE TABLE IF NOT EXISTS `criticidades` (
  `id_criticidade` int NOT NULL AUTO_INCREMENT,
  `criticidade` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_criticidade`),
  UNIQUE KEY `criticidade` (`criticidade`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `codigo_documento` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `nome_localizacao_documento` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `ficheiro` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `data_emissao` date NOT NULL,
  `data_validade` date DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_bin,
  `id_tipo_documento` int NOT NULL,
  `id_equipamento` int NOT NULL,
  `id_fornecedor` int DEFAULT NULL,
  PRIMARY KEY (`id_documento`),
  UNIQUE KEY `codigo_documento` (`codigo_documento`),
  KEY `id_tipo_documento` (`id_tipo_documento`),
  KEY `id_equipamento` (`id_equipamento`),
  KEY `id_fornecedor` (`id_fornecedor`),
  CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipos_documento` (`id_tipo_documento`),
  CONSTRAINT `documentos_ibfk_2` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id_equipamento`),
  CONSTRAINT `documentos_ibfk_3` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.equipamentos
CREATE TABLE IF NOT EXISTS `equipamentos` (
  `id_equipamento` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `codigo_interno` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `numero_serie` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `marca` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `modelo` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `fabricante` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `ano_fabrico` int NOT NULL,
  `data_aquisicao` date NOT NULL,
  `custo_aquisicao` decimal(10,2) NOT NULL,
  `observacoes` text COLLATE utf8mb4_bin,
  `id_categoria` int NOT NULL,
  `id_tipo_entrada` int NOT NULL,
  `id_estado` int NOT NULL,
  `id_criticidade` int NOT NULL,
  `id_localizacao` int NOT NULL,
  PRIMARY KEY (`id_equipamento`),
  UNIQUE KEY `codigo_interno` (`codigo_interno`),
  UNIQUE KEY `equipamentos_index_0` (`fabricante`,`modelo`,`numero_serie`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_tipo_entrada` (`id_tipo_entrada`),
  KEY `id_estado` (`id_estado`),
  KEY `id_criticidade` (`id_criticidade`),
  KEY `id_localizacao` (`id_localizacao`),
  CONSTRAINT `equipamentos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  CONSTRAINT `equipamentos_ibfk_2` FOREIGN KEY (`id_tipo_entrada`) REFERENCES `tipos_entrada` (`id_tipo_entrada`),
  CONSTRAINT `equipamentos_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados_equipamento` (`id_estado`),
  CONSTRAINT `equipamentos_ibfk_4` FOREIGN KEY (`id_criticidade`) REFERENCES `criticidades` (`id_criticidade`),
  CONSTRAINT `equipamentos_ibfk_5` FOREIGN KEY (`id_localizacao`) REFERENCES `localizacoes` (`id_localizacao`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.equipamento_fornecedor
CREATE TABLE IF NOT EXISTS `equipamento_fornecedor` (
  `id_equipamento` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  PRIMARY KEY (`id_equipamento`,`id_fornecedor`),
  KEY `id_fornecedor` (`id_fornecedor`),
  CONSTRAINT `equipamento_fornecedor_ibfk_1` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id_equipamento`),
  CONSTRAINT `equipamento_fornecedor_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.estados_equipamento
CREATE TABLE IF NOT EXISTS `estados_equipamento` (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_estado`),
  UNIQUE KEY `estado` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.estados_garantia
CREATE TABLE IF NOT EXISTS `estados_garantia` (
  `id_estado_garantia` int NOT NULL AUTO_INCREMENT,
  `estado_garantia` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_estado_garantia`),
  UNIQUE KEY `estado_garantia` (`estado_garantia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.fornecedores
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id_fornecedor` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `nome_empresa` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `morada` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `codigo_postal` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `nif` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `contacto_empresa` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `pessoa_contacto` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `telefone_contacto` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `observacoes` text COLLATE utf8mb4_bin,
  `id_tipo_fornecedor` int NOT NULL,
  PRIMARY KEY (`id_fornecedor`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `nif` (`nif`),
  UNIQUE KEY `email` (`email`),
  KEY `id_tipo_fornecedor` (`id_tipo_fornecedor`),
  CONSTRAINT `fornecedores_ibfk_1` FOREIGN KEY (`id_tipo_fornecedor`) REFERENCES `tipos_fornecedor` (`id_tipo_fornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.garantias_contratos
CREATE TABLE IF NOT EXISTS `garantias_contratos` (
  `id_garantia` int NOT NULL AUTO_INCREMENT,
  `codigo_garantia` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `existe_contrato` tinyint(1) NOT NULL,
  `entidade_responsavel` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_bin,
  `id_estado_garantia` int NOT NULL,
  `id_tipo_contrato` int DEFAULT NULL,
  `id_periodicidade` int DEFAULT NULL,
  `id_equipamento` int NOT NULL,
  PRIMARY KEY (`id_garantia`),
  UNIQUE KEY `codigo_garantia` (`codigo_garantia`),
  KEY `id_estado_garantia` (`id_estado_garantia`),
  KEY `id_tipo_contrato` (`id_tipo_contrato`),
  KEY `id_periodicidade` (`id_periodicidade`),
  KEY `id_equipamento` (`id_equipamento`),
  CONSTRAINT `garantias_contratos_ibfk_1` FOREIGN KEY (`id_estado_garantia`) REFERENCES `estados_garantia` (`id_estado_garantia`),
  CONSTRAINT `garantias_contratos_ibfk_2` FOREIGN KEY (`id_tipo_contrato`) REFERENCES `tipos_contrato` (`id_tipo_contrato`),
  CONSTRAINT `garantias_contratos_ibfk_3` FOREIGN KEY (`id_periodicidade`) REFERENCES `periodicidade` (`id_periodicidade`),
  CONSTRAINT `garantias_contratos_ibfk_4` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id_equipamento`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.localizacoes
CREATE TABLE IF NOT EXISTS `localizacoes` (
  `id_localizacao` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `edificio` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `piso` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `servico_departamento` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `acesso` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `sala_gabinete` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `responsavel` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `observacoes` text COLLATE utf8mb4_bin,
  PRIMARY KEY (`id_localizacao`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.periodicidade
CREATE TABLE IF NOT EXISTS `periodicidade` (
  `id_periodicidade` int NOT NULL AUTO_INCREMENT,
  `periodicidade` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_periodicidade`),
  UNIQUE KEY `periodicidade` (`periodicidade`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.rodape_publico
CREATE TABLE IF NOT EXISTS `rodape_publico` (
  `id_rodape` int NOT NULL AUTO_INCREMENT,
  `titulo_1` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `rua` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `codigo_postal` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `pais` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `titulo_2` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `dias_uteis` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `sabado_feriados` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `domingo` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `titulo_3` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `telefone` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `instagram` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `facebook` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `data_criacao` datetime NOT NULL,
  `data_ultima_atualizacao` datetime NOT NULL,
  PRIMARY KEY (`id_rodape`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.secao_servicos_publico
CREATE TABLE IF NOT EXISTS `secao_servicos_publico` (
  `id_secao_servicos` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `data_criacao` datetime NOT NULL,
  `data_ultima_atualizacao` datetime NOT NULL,
  PRIMARY KEY (`id_secao_servicos`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.servicos_publico
CREATE TABLE IF NOT EXISTS `servicos_publico` (
  `id_servico` int NOT NULL AUTO_INCREMENT,
  `icone` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `titulo` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `descricao` text COLLATE utf8mb4_bin NOT NULL,
  `ordem` int NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `data_criacao` datetime NOT NULL,
  `data_ultima_atualizacao` datetime NOT NULL,
  `id_secao_servicos` int NOT NULL,
  PRIMARY KEY (`id_servico`),
  KEY `id_secao_servicos` (`id_secao_servicos`),
  CONSTRAINT `servicos_publico_ibfk_1` FOREIGN KEY (`id_secao_servicos`) REFERENCES `secao_servicos_publico` (`id_secao_servicos`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.sobre_nos_publico
CREATE TABLE IF NOT EXISTS `sobre_nos_publico` (
  `id_sobre_nos` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_bin,
  `texto_botao` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `data_criacao` datetime NOT NULL,
  `data_ultima_atualizacao` datetime NOT NULL,
  PRIMARY KEY (`id_sobre_nos`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.tipos_contrato
CREATE TABLE IF NOT EXISTS `tipos_contrato` (
  `id_tipo_contrato` int NOT NULL AUTO_INCREMENT,
  `tipo_contrato` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_tipo_contrato`),
  UNIQUE KEY `tipo_contrato` (`tipo_contrato`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.tipos_documento
CREATE TABLE IF NOT EXISTS `tipos_documento` (
  `id_tipo_documento` int NOT NULL AUTO_INCREMENT,
  `tipo_documento` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_tipo_documento`),
  UNIQUE KEY `tipo_documento` (`tipo_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.tipos_entrada
CREATE TABLE IF NOT EXISTS `tipos_entrada` (
  `id_tipo_entrada` int NOT NULL AUTO_INCREMENT,
  `tipo_entrada` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_tipo_entrada`),
  UNIQUE KEY `tipo_entrada` (`tipo_entrada`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.tipos_fornecedor
CREATE TABLE IF NOT EXISTS `tipos_fornecedor` (
  `id_tipo_fornecedor` int NOT NULL AUTO_INCREMENT,
  `tipo_fornecedor` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_tipo_fornecedor`),
  UNIQUE KEY `tipo_fornecedor` (`tipo_fornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela db1241327.utilizadores
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `id_utilizador` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `perfil` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `criado_em` datetime NOT NULL,
  PRIMARY KEY (`id_utilizador`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Exportação de dados não seleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
