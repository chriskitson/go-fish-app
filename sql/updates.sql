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

