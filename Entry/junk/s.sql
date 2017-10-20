# CocoaMySQL dump
# Version 0.7b5
# http://cocoamysql.sourceforge.net
#
# Host: localhost (MySQL 5.1.25-rc-log)
# Database: challenge
# Generation Time: 2008-09-04 12:12:49 +0100
# ************************************************************

# Dump of table EAV_Date
# ------------------------------------------------------------

CREATE TABLE `EAV_Date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32) DEFAULT NULL,
  `attribute_Id` int(11) DEFAULT NULL,
  `value` date DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `attribute_Id` (`attribute_Id`),
  KEY `created` (`created`),
  KEY `modified` (`modified`),
  CONSTRAINT `fk_eavdate_attribute_id` FOREIGN KEY (`attribute_Id`) REFERENCES `attributes` (`id`),
  CONSTRAINT `fk_eavdate_object` FOREIGN KEY (`object_id`) REFERENCES `object` (`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


# Dump of table EAV_Int
# ------------------------------------------------------------

CREATE TABLE `EAV_Int` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32) DEFAULT NULL,
  `attribute_Id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `attribute_Id` (`attribute_Id`),
  KEY `created` (`created`),
  KEY `modified` (`modified`),
  CONSTRAINT `fk_eavint_attribute` FOREIGN KEY (`attribute_Id`) REFERENCES `attributes` (`id`),
  CONSTRAINT `fk_eavint_object` FOREIGN KEY (`object_id`) REFERENCES `object` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table EAV_Memo
# ------------------------------------------------------------

CREATE TABLE `EAV_Memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32) DEFAULT NULL,
  `attribute_Id` int(11) DEFAULT NULL,
  `value` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  `language_code` char(2) DEFAULT 'en',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `attribute_Id` (`attribute_Id`),
  KEY `created` (`created`),
  KEY `modified` (`modified`)

  CONSTRAINT `fk_eavmemo_attribute` FOREIGN KEY (`attribute_Id`) REFERENCES `attributes` (`id`),
  CONSTRAINT `fk_eavmemo_object` FOREIGN KEY (`object_id`) REFERENCES `object` (`object_id`)


) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table EAV_Real
# ------------------------------------------------------------

CREATE TABLE `EAV_Real` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32) DEFAULT NULL,
  `attribute_Id` int(11) DEFAULT NULL,
  `value` float DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `attribute_Id` (`attribute_Id`),
  KEY `created` (`created`),
  KEY `modified` (`modified`),
  CONSTRAINT `fk_eavreal_attribute` FOREIGN KEY (`attribute_Id`) REFERENCES `attributes` (`id`),
  CONSTRAINT `fk_eavreal_object_id` FOREIGN KEY (`object_id`) REFERENCES `object` (`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1267 DEFAULT CHARSET=utf8;



# Dump of table EAV_String
# ------------------------------------------------------------

CREATE TABLE `EAV_String` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32) DEFAULT NULL,
  `attribute_Id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  `language_code` char(2) DEFAULT 'en',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `attribute_Id` (`attribute_Id`),
  KEY `value` (`value`),
  KEY `created` (`created`),
  KEY `modified` (`modified`)
  CONSTRAINT `fk_eavstring_attribute` FOREIGN KEY (`attribute_Id`) REFERENCES `attributes` (`id`),
  CONSTRAINT `fk_eavstring_object_id` FOREIGN KEY (`object_id`) REFERENCES `object` (`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table attributes
# ------------------------------------------------------------

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `caption` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(32) DEFAULT NULL,
  `datatype` enum('EAV_Int','EAV_String','EAV_Memo','EAV_Date','EAV_Real','EAV_Coordinates','EAV_Objects') NOT NULL DEFAULT 'EAV_String',
  `rdf` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `name` (`name`),
  KEY `datatype` (`datatype`),
  CONSTRAINT `fk_attributes_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `attributes` (`id`,`class_id`,`name`,`caption`,`description`,`datatype`,`rdf`) VALUES ('3','1','datepublished','',NULL,'EAV_Date',NULL);
INSERT INTO `attributes` (`id`,`class_id`,`name`,`caption`,`description`,`datatype`,`rdf`) VALUES ('5','1','title','',NULL,'EAV_String',NULL);


# Dump of table classes
# ------------------------------------------------------------

CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `classes` (`id`,`name`,`description`) VALUES ('1','object',NULL);


# Dump of table edits
# ------------------------------------------------------------

CREATE TABLE `edits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32) NOT NULL,
  `table_name` varchar(32) NOT NULL,
  `row_id` int(11) DEFAULT NULL,
  `author_id` varchar(32) DEFAULT NULL,
  `ip` int(10) unsigned DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `edits_ibfk_1` FOREIGN KEY (`object_id`) REFERENCES `object` (`object_id`),
  CONSTRAINT `edits_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `object` (`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


# Dump of table guid_namespaces
# ------------------------------------------------------------

CREATE TABLE `guid_namespaces` (
  `namespace` varchar(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  UNIQUE KEY `namespace` (`namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `guid_namespaces` (`namespace`,`description`) VALUES ('doi','Digital Object Identifier');


# Dump of table object
# ------------------------------------------------------------

CREATE TABLE `object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32)  NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  `class_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object_id` (`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


# Dump of table object_guid
# ------------------------------------------------------------

CREATE TABLE `object_guid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(32) NOT NULL,
  `namespace` varchar(32) DEFAULT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `fk_namespace` (`namespace`),
  CONSTRAINT `fk_object_namespace` FOREIGN KEY (`namespace`) REFERENCES `guid_namespaces` (`namespace`),
  CONSTRAINT `fk_object_guid` FOREIGN KEY (`object_id`) REFERENCES `object` (`object_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table object_link
# ------------------------------------------------------------

CREATE TABLE `object_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_object_id` varchar(32) NOT NULL,
  `target_object_id` varchar(32) NOT NULL,
  `serial_number` int(11) DEFAULT '1',
  `relationship_id` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT '2100-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `source_object_id` (`source_object_id`),
  KEY `target_object_id` (`target_object_id`),
  CONSTRAINT `object_link_ibfk_2` FOREIGN KEY (`target_object_id`) REFERENCES `object` (`object_id`),
  CONSTRAINT `object_link_ibfk_1` FOREIGN KEY (`source_object_id`) REFERENCES `object` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



