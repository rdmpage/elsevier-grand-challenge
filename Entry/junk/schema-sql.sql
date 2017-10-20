/* SQLEditor (MySQL)*/


CREATE TABLE `object`
(
`id` INT(11) NOT NULL AUTO_INCREMENT ,
`object_id` VARCHAR(32) NOT NULL UNIQUE ,
`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
`modified` DATETIME DEFAULT 2100-00-00 00:00:00,
`class_id` INT(11),
`name` VARCHAR(255),
`description` VARCHAR(255),
PRIMARY KEY (`id`)
) TYPE=InnoDB;



CREATE TABLE `object_link`
(
`id` INT(11) NOT NULL AUTO_INCREMENT ,
`source_object_id` VARCHAR(32) NOT NULL,
`target_object_id` VARCHAR(32) NOT NULL,
`serial_number` INT(11) DEFAULT 1,
`relationship_id` INT(11) DEFAULT 0 NOT NULL,
`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
`modified` DATETIME DEFAULT 2100-00-00 00:00:00,
PRIMARY KEY (`id`)
) TYPE=InnoDB;



CREATE TABLE `edits`
(
`id` INT(11) NOT NULL AUTO_INCREMENT ,
`object_id` VARCHAR(32) NOT NULL,
`table_name` VARCHAR(32) NOT NULL,
`row_id` INT(11),
`author_id` VARCHAR(32),
`ip` INT(10) unsigned ,
`comment` VARCHAR(255),
`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (`id`)
) TYPE=InnoDB;



CREATE TABLE `object_guid`
(
`id` INT(11) NOT NULL AUTO_INCREMENT ,
`object_id` VARCHAR(32) NOT NULL,
`namespace` VARCHAR(32),
`identifier` VARCHAR(255),
`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
`modified` DATETIME DEFAULT 2100-00-00 00:00:00,
PRIMARY KEY (`id`)
) TYPE=InnoDB;


ALTER TABLE `object_link` ADD FOREIGN KEY (`source_object_id`) REFERENCES `object`(`object_id`);
ALTER TABLE `object_link` ADD FOREIGN KEY (`target_object_id`) REFERENCES `object`(`object_id`);
ALTER TABLE `edits` ADD FOREIGN KEY (`object_id`) REFERENCES `object`(`object_id`);
ALTER TABLE `edits` ADD FOREIGN KEY (`author_id`) REFERENCES `object`(`object_id`);
ALTER TABLE `object_guid` ADD FOREIGN KEY (`object_id`) REFERENCES `object`(`object_id`);
