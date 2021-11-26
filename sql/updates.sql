-- CREATE TABLE `transactions` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `session` varchar(255) DEFAULT NULL,
--   `qty` int(11) DEFAULT NULL,
--   `total` decimal(15,2) DEFAULT NULL,
--   `booking_fee` decimal(15,2) DEFAULT NULL,
--   `ticket_fee` decimal(15,2) DEFAULT NULL,
--   `confirmed` bit(1) DEFAULT b'0',
--   `transaction` varchar(255) DEFAULT NULL,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ALTER TABLE `go_fish_app`.`bookings` 
-- DROP COLUMN `confirmed`,
-- DROP COLUMN `transaction`,
-- DROP COLUMN `session`,
-- ADD COLUMN `transaction_id` INT(11) NULL AFTER `cost`;


ALTER TABLE `users` 
ADD COLUMN `user_type` BIT NULL DEFAULT 1 AFTER `updated_at`,
ADD COLUMN `global_admin` BIT NULL DEFAULT 0 AFTER `user_type`;



ALTER TABLE `venues` 
ADD COLUMN `deleted` BIT(1) NULL DEFAULT 0 AFTER `rules`;

ALTER TABLE `go_fish_app`.`venues` 
ADD COLUMN `open_sunday` BIT(1) NULL DEFAULT 0,
ADD COLUMN `open_monday` BIT(1) NULL DEFAULT 0,
ADD COLUMN `open_tuesday` BIT(1) NULL DEFAULT 0,
ADD COLUMN `open_wednesday` BIT(1) NULL DEFAULT 0,
ADD COLUMN `open_thursday` BIT(1) NULL DEFAULT 0,
ADD COLUMN `open_friday` BIT(1) NULL DEFAULT 0,
ADD COLUMN `open_saturday` BIT(1) NULL DEFAULT 0;


ALTER TABLE `venues` 
ADD COLUMN `place_meta` LONGTEXT NULL AFTER `open_saturday`;

CREATE TABLE `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `key` VARCHAR(45) NULL,
  `value` VARCHAR(45) NULL,
  `results` LONGTEXT NULL,
  `results_updated` DATETIME NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `categories` 
ADD COLUMN `created_at` DATETIME NULL AFTER `results_updated`,
ADD COLUMN `updated_at` DATETIME NULL AFTER `created_at`;

ALTER TABLE `categories` 
ADD COLUMN `image` VARCHAR(255) NULL AFTER `name`;

/* 23-11-21 */
CREATE TABLE `venues_closed` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `venue_id` INT NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  PRIMARY KEY (`id`));

  ALTER TABLE `venues_closed` 
ADD COLUMN `created_at` TIMESTAMP NULL AFTER `end_date`,
ADD COLUMN `updated_at` TIMESTAMP NULL AFTER `created_at`;


ALTER TABLE `users` 
ADD COLUMN `town` VARCHAR(255) NULL AFTER `global_admin`,
ADD COLUMN `origin` VARCHAR(45) NULL AFTER `town`;



