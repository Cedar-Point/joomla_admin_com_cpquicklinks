CREATE TABLE `lwr6z_com_cpquicklinks_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_font_awesome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_id_UNIQUE` (`cat_id`),
  UNIQUE KEY `cat_name_UNIQUE` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lwr6z_com_cpquicklinks_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_cat_id` int(11) NOT NULL,
  `link_name` varchar(100) NOT NULL,
  `link_url` text NOT NULL,
  `link_target` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  UNIQUE KEY `link_id_UNIQUE` (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;