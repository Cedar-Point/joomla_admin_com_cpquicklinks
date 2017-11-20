CREATE TABLE `lwr6z_com_cpquicklinks_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_priority` int(11) NOT NULL,
  `cat_name` varchar(20) NOT NULL,
  `cat_font_awesome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_id_UNIQUE` (`cat_id`),
  UNIQUE KEY `cat_priority_UNIQUE` (`cat_priority`),
  UNIQUE KEY `cat_name_UNIQUE` (`cat_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `lwr6z_com_cpquicklinks_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_priority` int(11) NOT NULL,
  `link_cat_id` int(11) NOT NULL,
  `link_url` text NOT NULL,
  `link_target` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  UNIQUE KEY `link_id_UNIQUE` (`link_id`),
  UNIQUE KEY `link_priority_UNIQUE` (`link_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;