SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `contact_person` ADD `customer_id` INT(11) NOT NULL AFTER `contact_person_id`;

ALTER TABLE `contact_person` ADD CONSTRAINT `customer_contact_person` FOREIGN KEY (`customer_id`) REFERENCES `J2V2`.`customer`(`customer_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `contact` CHANGE `contact_pnumber` `contact_phone_number` VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `contact_mnumber` `contact_mobile_number` VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `contact_fnumber` `contact_fax_number` VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `unit_of_measurement` ADD `unit_of_measurement_name` VARCHAR(100) NOT NULL AFTER `unit_of_measurement_code`;

ALTER TABLE `account` ADD `customer_id` INT(11) NOT NULL AFTER `account_id`;

ALTER TABLE `account` ADD CONSTRAINT `customer_account` FOREIGN KEY (`customer_id`) REFERENCES `J2V2`.`customer`(`customer_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `J2V2`.`sub_modules` (`sub_modules_id`, `sub_modules_name`, `sub_modules_slug`, `sub_modules_description`, `sub_modules_order`) VALUES (NULL, 'Account', 'account', 'Account Maintenance', '23');

ALTER TABLE `job_order` DROP FOREIGN KEY `branch_job_order`;

ALTER TABLE `branch` CHANGE `branch_id` `branch_id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `job_order` ADD CONSTRAINT `branch_job_order` FOREIGN KEY (`branch_id`) REFERENCES `J2V2`.`branch`(`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `contact_person` CHANGE `contact_person_fname` `contact_person_firstname` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `contact_person_mname` `contact_person_middlename` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `contact_person_lname` `contact_person_lastname` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `unit_of_measurement` CHANGE `unit_of_measurement_id` `unit_of_measurement_id` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tax_type` ADD `tax_type_name` VARCHAR(100) NULL AFTER `tax_type_code`;

ALTER TABLE `tier` ADD `tier_name` VARCHAR(100) NULL AFTER `tier_rank`;

SET FOREIGN_KEY_CHECKS = 1;