DROP TABLE IF EXISTS `produto_departamento`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `departamentos`;
DROP TABLE IF EXISTS `marcas`;
CREATE TABLE `departamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE `marcas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `preco` double NOT NULL,
  `estoque` varchar(45) NOT NULL,
  `marca_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produtos_marcas_idx` (`marca_id`),
  CONSTRAINT `fk_produtos_marcas` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
CREATE TABLE `produto_departamento` (
  `produto_id` int NOT NULL,
  `departamento_id` int NOT NULL,
  PRIMARY KEY (`produto_id`,`departamento_id`),
  KEY `fk_produto_departamento_departamentos1_idx` (`departamento_id`),
  CONSTRAINT `fk_produto_departamento_departamentos1` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`),
  CONSTRAINT `fk_produto_departamento_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;