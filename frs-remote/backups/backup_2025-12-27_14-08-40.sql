SET FOREIGN_KEY_CHECKS=0;


CREATE TABLE `frs_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `type` int(1) NOT NULL,
  `image` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_users` (`id`,`first_name`,`last_name`,`email`,`password`,`type`,`image`,`address`,`contact`,`deleted`) VALUES ('1','Charlene','Dela Cruz','admin@admin.com','202cb962ac59075b964b07152d234b70','0','default.png','Bayombong, Nueva Vizcaya','09170202020','0');

CREATE TABLE `frs_drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_drivers_createdby` (`created_by`),
  KEY `fk_drivers_updatedby` (`updated_by`),
  CONSTRAINT `fk_drivers_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_drivers_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('1','Juan','Dela Cruz','Bayombong, Nueva Vizcaya','09171234567','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('2','Pedro','Santos','Solano, Nueva Vizcaya','09172345678','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('3','Maria','Gonzales','Bambang, Nueva Vizcaya','09173456789','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('4','Luis','Reyes','Bagabag, Nueva Vizcaya','09174567890','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('5','Ana','Torres','Diadi, Nueva Vizcaya','09175678901','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('6','Carlos','Lopez','Quezon, Nueva Vizcaya','09176789012','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('7','Sofia','Martinez','Villaverde, Nueva Vizcaya','09177890123','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('8','Miguel','Garcia','Aritao, Nueva Vizcaya','09178901234','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('9','Elena','Fernandez','Dupax del Norte, Nueva Vizcaya','09179012345','0','1','');
INSERT INTO `frs_drivers` (`id`,`first_name`,`last_name`,`address`,`contact`,`deleted`,`created_by`,`updated_by`) VALUES ('10','Jose','Ramirez','Kasibu, Nueva Vizcaya','09170123456','0','1','');

CREATE TABLE `frs_ejeeps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate` varchar(20) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ejeeps_createdby` (`created_by`),
  KEY `fk_ejeeps_updatedby` (`updated_by`),
  CONSTRAINT `fk_ejeeps_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_ejeeps_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_ejeeps` (`id`,`plate`,`deleted`,`created_by`,`updated_by`) VALUES ('1','ABC 123','0','1','1');
INSERT INTO `frs_ejeeps` (`id`,`plate`,`deleted`,`created_by`,`updated_by`) VALUES ('2','XYZ 789','0','1','1');
INSERT INTO `frs_ejeeps` (`id`,`plate`,`deleted`,`created_by`,`updated_by`) VALUES ('3','DEF 456','0','1','1');
INSERT INTO `frs_ejeeps` (`id`,`plate`,`deleted`,`created_by`,`updated_by`) VALUES ('4','GHI 101','0','1','1');
INSERT INTO `frs_ejeeps` (`id`,`plate`,`deleted`,`created_by`,`updated_by`) VALUES ('5','JKL 202','0','1','1');
INSERT INTO `frs_ejeeps` (`id`,`plate`,`deleted`,`created_by`,`updated_by`) VALUES ('6','KLS 0992','0','1','');

CREATE TABLE `frs_routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_routes_createdby` (`created_by`),
  KEY `fk_routes_updatedby` (`updated_by`),
  CONSTRAINT `fk_routes_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_routes_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_routes` (`id`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('1','Bayombong - Solano','0','1','');

CREATE TABLE `frs_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('O','I','F','') NOT NULL,
  `description` varchar(50) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categories_createdby` (`created_by`),
  KEY `fk_categories_updatedby` (`updated_by`),
  CONSTRAINT `fk_categories_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_categories_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('1','I','Amortization','0','1','');
INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('2','O','Register per Unit','0','1','');
INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('3','O','Maintenance & Repair','0','1','');
INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('4','I','Insurance','0','1','');
INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('5','O','Driver Salary','0','1','');
INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('6','O','Utilities - Electric Bill','0','1','');
INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('7','O','Utilities - Water Bill','0','1','');
INSERT INTO `frs_categories` (`id`,`type`,`description`,`deleted`,`created_by`,`updated_by`) VALUES ('8','O','Office Supplies','0','1','');

CREATE TABLE `frs_collections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `ejeep_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` double(10,0) NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_collections_ejeepid` (`ejeep_id`),
  KEY `fk_collections_routeid` (`route_id`),
  KEY `fk_collections_createdby` (`created_by`),
  KEY `fk_collections_updatedby` (`updated_by`),
  KEY `fk_collections_driverid` (`driver_id`),
  CONSTRAINT `fk_collections_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_collections_driverid` FOREIGN KEY (`driver_id`) REFERENCES `frs_drivers` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_collections_ejeepid` FOREIGN KEY (`ejeep_id`) REFERENCES `frs_ejeeps` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_collections_routeid` FOREIGN KEY (`route_id`) REFERENCES `frs_routes` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_collections_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('1','1','1','1','2024-01-05','1500','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('2','2','2','1','2024-01-10','1200','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('3','3','3','1','2024-01-15','1300','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('4','4','4','1','2024-01-20','1400','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('5','5','5','1','2024-01-25','1100','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('6','6','1','1','2024-02-01','1600','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('7','7','2','1','2024-02-05','1700','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('8','8','3','1','2024-02-10','1800','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('9','9','4','1','2024-02-15','1900','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('10','10','5','1','2024-02-20','2000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('11','1','1','1','2024-03-01','1500','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('12','2','2','1','2024-03-05','1200','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('13','3','3','1','2024-03-10','1300','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('14','4','4','1','2024-03-15','1400','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('15','5','5','1','2024-03-20','1100','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('16','6','1','1','2024-04-01','1600','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('17','7','2','1','2024-04-05','1700','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('18','8','3','1','2024-04-10','1800','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('19','9','4','1','2024-04-15','1900','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('20','10','5','1','2024-04-20','2000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('21','1','1','1','2024-05-01','1500','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('22','2','2','1','2024-05-05','1200','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('23','3','3','1','2024-05-10','1300','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('24','4','4','1','2024-05-15','1400','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('25','5','5','1','2024-05-20','1100','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('26','6','1','1','2024-06-01','1600','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('27','7','2','1','2024-06-05','1700','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('28','8','3','1','2024-06-10','1800','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('29','9','4','1','2024-06-15','1900','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('30','10','5','1','2024-06-20','2000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('31','1','1','1','2025-11-22','4000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('32','2','1','1','2025-11-22','2000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('33','6','3','1','2025-11-22','6000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('34','2','5','1','2025-10-22','3000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('35','4','5','1','2025-09-15','5000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('36','6','4','1','2025-10-30','5000','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('37','6','4','1','2024-02-07','2700','0','1','');
INSERT INTO `frs_collections` (`id`,`driver_id`,`ejeep_id`,`route_id`,`date`,`amount`,`deleted`,`created_by`,`updated_by`) VALUES ('38','1','1','1','2025-12-16','5000','0','1','');

CREATE TABLE `frs_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_expenses_createdby` (`created_by`),
  KEY `fk_expenses_updatedby` (`updated_by`),
  KEY `fk_expenses_categoryid` (`category_id`),
  CONSTRAINT `fk_expenses_categoryid` FOREIGN KEY (`category_id`) REFERENCES `frs_categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_expenses_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_expenses_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('1','3','Tire replacement for e-jeep ABC 123','2000','2024-01-05','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('2','4','Annual insurance for e-jeep XYZ 789','5000','2024-01-10','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('3','6','Electric bill for January 2024','1500','2024-01-15','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('4','7','Water bill for January 2024','800','2024-01-20','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('5','8','Office supplies for January 2024','500','2024-01-25','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('6','3','Brake repair for e-jeep DEF 456','1200','2024-02-01','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('7','4','Insurance renewal for e-jeep GHI 101','4500','2024-02-05','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('8','6','Electric bill for February 2024','1600','2024-02-10','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('9','7','Water bill for February 2024','850','2024-02-15','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('10','8','Office supplies for February 2024','600','2024-02-20','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('11','3','Engine repair for e-jeep JKL 202','3000','2024-03-01','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('12','4','Insurance for e-jeep ABC 123','4800','2024-03-05','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('13','6','Electric bill for March 2024','1700','2024-03-10','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('14','7','Water bill for March 2024','900','2024-03-15','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('15','8','Office supplies for March 2024','700','2024-03-20','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('16','3','Battery replacement for e-jeep XYZ 789','2500','2024-04-01','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('17','4','Insurance for e-jeep DEF 456','4700','2024-04-05','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('18','6','Electric bill for April 2024','1800','2024-04-10','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('19','7','Water bill for April 2024','950','2024-04-15','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('20','8','Office supplies for April 2024','800','2024-04-20','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('21','3','Transmission repair for e-jeep GHI 101','3500','2024-05-01','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('22','4','Insurance for e-jeep JKL 202','4900','2024-05-05','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('23','6','Electric bill for May 2024','1900','2024-05-10','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('24','7','Water bill for May 2024','1000','2024-05-15','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('25','8','Office supplies for May 2024','900','2024-05-20','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('26','3','Suspension repair for e-jeep ABC 123','2800','2024-06-01','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('27','4','Insurance for e-jeep XYZ 789','4600','2024-06-05','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('28','6','Electric bill for June 2024','2000','2024-06-10','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('29','7','Water bill for June 2024','1050','2024-06-15','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('30','8','Office supplies for June 2024','1000','2024-06-20','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('31','5','Payout for Driver: Carlos Lopez (Week: November 16, 2025 - November 22, 2025)','690','2025-12-01','0','1','');
INSERT INTO `frs_expenses` (`id`,`category_id`,`description`,`amount`,`date`,`deleted`,`created_by`,`updated_by`) VALUES ('32','5','Payout for Driver: Juan Dela Cruz (Week: December 14, 2025 - December 20, 2025)','650','2025-12-16','0','1','');

CREATE TABLE `frs_salaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `rate_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `collection` double NOT NULL,
  `salary` double NOT NULL,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salaries_createdby` (`created_by`),
  KEY `fk_salaries_updateby` (`updated_by`),
  KEY `fk_salaries_driverid` (`driver_id`),
  KEY `fk_salaries_rateid` (`rate_id`),
  CONSTRAINT `fk_salaries_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_salaries_driverid` FOREIGN KEY (`driver_id`) REFERENCES `frs_drivers` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_salaries_rateid` FOREIGN KEY (`rate_id`) REFERENCES `frs_rates` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_salaries_updateby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('1','1','1','2024-01-05','1500','270','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('2','2','1','2024-01-10','1200','216','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('3','3','1','2024-01-15','1300','234','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('4','4','1','2024-01-20','1400','252','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('5','5','1','2024-01-25','1100','198','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('6','6','1','2024-02-01','1600','288','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('7','7','1','2024-02-05','1700','306','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('8','8','1','2024-02-10','1800','324','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('9','9','1','2024-02-15','1900','342','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('10','10','1','2024-02-20','2000','360','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('11','1','1','2024-03-01','1500','270','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('12','2','1','2024-03-05','1200','216','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('13','3','1','2024-03-10','1300','234','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('14','4','1','2024-03-15','1400','252','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('15','5','1','2024-03-20','1100','198','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('16','6','1','2024-04-01','1600','288','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('17','7','1','2024-04-05','1700','306','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('18','8','1','2024-04-10','1800','324','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('19','9','1','2024-04-15','1900','342','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('20','10','1','2024-04-20','2000','360','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('21','1','1','2024-05-01','1500','270','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('22','2','1','2024-05-05','1200','216','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('23','3','1','2024-05-10','1300','234','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('24','4','1','2024-05-15','1400','252','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('25','5','1','2024-05-20','1100','198','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('26','6','1','2024-06-01','1600','288','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('27','7','1','2024-06-05','1700','306','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('28','8','1','2024-06-10','1800','324','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('29','9','1','2024-06-15','1900','342','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('30','10','1','2024-06-20','2000','360','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('31','1','1','2025-11-22','4000','610','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('32','2','1','2025-11-22','2000','360','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('33','6','1','2025-11-22','6000','690','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('34','2','1','2025-10-22','3000','570','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('35','4','1','2025-09-15','5000','650','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('36','6','1','2025-10-30','5000','650','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('37','6','1','2024-02-07','2700','558','0','1','');
INSERT INTO `frs_salaries` (`id`,`driver_id`,`rate_id`,`date`,`collection`,`salary`,`deleted`,`created_by`,`updated_by`) VALUES ('38','1','1','2025-12-16','5000','650','0','1','');

CREATE TABLE `frs_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quota` double NOT NULL,
  `base_salary` double NOT NULL,
  `base_rate` double NOT NULL,
  `addon_rate` double NOT NULL,
  `is_default` bit(1) NOT NULL DEFAULT b'0',
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rates_createdby` (`created_by`),
  KEY `fk_rates_updatedby` (`updated_by`),
  CONSTRAINT `fk_rates_createdby` FOREIGN KEY (`created_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_rates_updatedby` FOREIGN KEY (`updated_by`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_rates` (`id`,`quota`,`base_salary`,`base_rate`,`addon_rate`,`is_default`,`deleted`,`created_by`,`updated_by`) VALUES ('1','2700','450','18','4','1','0','1','');

CREATE TABLE `frs_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_trail_userid` (`user_id`),
  CONSTRAINT `fk_trail_userid` FOREIGN KEY (`user_id`) REFERENCES `frs_users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('1','1','Added a new collection.','2025-11-22 16:17:51');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('2','1','Added a new collection.','2025-11-22 16:18:06');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('3','1','Added a new collection.','2025-11-22 16:18:26');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('4','1','Added a new collection.','2025-11-22 16:18:48');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('5','1','Added a new collection.','2025-11-22 16:19:11');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('6','1','Added a new collection.','2025-11-22 16:19:34');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('7','1','Added a new collection.','2025-11-28 12:37:44');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('8','1','Processed payout for Driver: Carlos Lopez (Week: November 16, 2025 - November 22, 2025) - Amount: Ph','2025-12-01 13:55:43');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('9','1','Added a new collection.','2025-12-16 16:27:37');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('10','1','Processed payout for Driver: Juan Dela Cruz (Week: December 14, 2025 - December 20, 2025) - Amount: ','2025-12-16 16:28:11');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('12','1','Created database backup: backup_2025-12-27_14-01-25.sql','2025-12-27 14:01:25');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('13','1','Added a new e-jeep.','2025-12-27 14:02:05');
INSERT INTO `frs_trail` (`id`,`user_id`,`description`,`date`) VALUES ('14','1','Created database backup: backup_2025-12-27_14-05-00.sql','2025-12-27 14:05:00');

SET FOREIGN_KEY_CHECKS=1;