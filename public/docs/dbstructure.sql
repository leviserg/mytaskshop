CREATE DATABASE `taskshop` /*!40100 DEFAULT CHARACTER SET utf8 */;
CREATE TABLE `types` (
  `id` int(3) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `c1` (
  `typeid` int(3) NOT NULL,
  `cid` int(3) NOT NULL,
  `param` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`typeid`,`cid`),
  CONSTRAINT `fk_c1_type` FOREIGN KEY (`typeid`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `c2` (
  `typeid` int(3) NOT NULL,
  `cid` int(3) NOT NULL,
  `param` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`typeid`,`cid`),
  CONSTRAINT `fk_c2_type` FOREIGN KEY (`typeid`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `c3` (
  `typeid` int(3) NOT NULL,
  `cid` int(3) NOT NULL,
  `param` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`typeid`,`cid`),
  CONSTRAINT `fk_c3_type` FOREIGN KEY (`typeid`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pname` varchar(180) DEFAULT NULL,
  `price` int(6) DEFAULT NULL,
  `typeid` int(3) NOT NULL,
  `c1param` int(3) NOT NULL,
  `c2param` int(3) NOT NULL,
  `c3param` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_c1_idx` (`typeid`,`c1param`),
  KEY `fk_product_c2_idx` (`typeid`,`c2param`),
  KEY `fk_product_c3_idx` (`typeid`,`c3param`),
  CONSTRAINT `fk_product_c1` FOREIGN KEY (`typeid`, `c1param`) REFERENCES `c1` (`typeid`, `cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_c2` FOREIGN KEY (`typeid`, `c2param`) REFERENCES `c2` (`typeid`, `cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_c3` FOREIGN KEY (`typeid`, `c3param`) REFERENCES `c3` (`typeid`, `cid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

select products.id, pname, price, types.type, c1s.param, c2s.param, c3s.param from products
	join types on products.typeid = types.id
	join c1s on products.c1param = c1s.cid and products.typeid = c1s.typeid
	join c2s on products.c2param = c2s.cid and products.typeid = c2s.typeid
	join c3s on products.c3param = c3s.cid and products.typeid = c3s.typeid
	where products.typeid = 1
