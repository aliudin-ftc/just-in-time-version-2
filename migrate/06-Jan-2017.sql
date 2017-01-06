-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2017 at 09:39 AM
-- Server version: 5.6.28-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `J2V2`
--

-- --------------------------------------------------------
--
-- Table structure for table `sub_modules`
--

SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `modules_sub_modules` ADD `resources_id` INT(11) NOT NULL ;

ALTER TABLE `modules_sub_modules` ADD CONSTRAINT `resources_modules_sub_modules` FOREIGN KEY (`resources_id`) REFERENCES `J2V2`.`resources`(`resources_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

TRUNCATE TABLE `modules_sub_modules`;

ALTER TABLE `modules_sub_modules` DROP FOREIGN KEY `sub_modules_modules_sub_modules`;

DROP TABLE `sub_modules`;

CREATE TABLE IF NOT EXISTS `sub_modules` (
`sub_modules_id` int(11) NOT NULL,
  `sub_modules_name` varchar(100) DEFAULT NULL,
  `sub_modules_slug` varchar(100) DEFAULT NULL,
  `sub_modules_description` varchar(100) DEFAULT NULL,
  `sub_modules_order` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Indexes for table `sub_modules`
--
ALTER TABLE `sub_modules`
 ADD PRIMARY KEY (`sub_modules_id`);


TRUNCATE TABLE `sub_modules`;
--
-- Dumping data for table `sub_modules`
--

INSERT INTO `sub_modules` (`sub_modules_id`, `sub_modules_name`, `sub_modules_slug`, `sub_modules_description`, `sub_modules_order`) VALUES
(1, 'Manage', 'manage', 'Manage Dashboard', 1),
(2, 'Manage', 'manage', 'Manage Purchase Order', 2),
(3, 'Archived', 'archived', 'Archived Purchase Order', 3),
(4, 'Manage', 'manage', 'Manage Purchase Request', 4),
(5, 'Archived', 'archived', 'Archived Purchase Request', 5),
(6, 'Manage', 'manage', 'Manage Bill of Materials', 6),
(7, 'Request for PR', 'request-for-purchase-request', 'Request for PR Bill of Materials', 7),
(8, 'Issuance', 'issuance', 'Issuance Bill of Materials', 8),
(9, 'Transfer Order', 'transfer-order', 'Transfer Order Withdrawal', 9),
(10, 'Special Request', 'special-request', 'Special Request Withdrawal', 10),
(11, 'Manage', 'manage', 'Manage Billing', 11),
(12, 'Archived', 'archived', 'Archived Billing', 12),
(13, 'Schedules', 'schedules', 'Delivery Schedules', 13),
(14, 'JO Form', 'job-order-form', 'Delivery Job Order Form', 14),
(15, 'Finished Goods', 'finished-goods', 'Delivery Finished Goods', 15),
(16, 'Preparation', 'preparation', 'Delivery Preparation', 16),
(17, 'Posting', 'posting', 'Delivery Posting', 17),
(18, 'Modules', 'modules', 'Report Modules', 18),
(19, 'Logs', 'logs', 'Report Logs', 19),
(20, 'Customer', 'customer', 'Customer Maintenance', 20),
(21, 'Department', 'department', 'Department Maintenance', 20);

--
-- Indexes for dumped tables
--

--
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sub_modules`
--
ALTER TABLE `sub_modules`
MODIFY `sub_modules_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `modules_sub_modules` ADD CONSTRAINT `sub_modules_modules_sub_modules` FOREIGN KEY (`sub_modules_id`) REFERENCES `J2V2`.`sub_modules`(`sub_modules_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/*SET FOREIGN_KEY_CHECKS = 0;*/

TRUNCATE TABLE `modules_sub_modules`;

INSERT INTO `modules_sub_modules` (`modules_sub_modules_id`, `modules_id`, `sub_modules_id`, `resources_id`) VALUES
(1, 1, 1, 1),
(2, 2, 21, 1),
(3, 3, 20, 1),
(4, 4, 2, 1),
(5, 4, 3, 1),
(6, 5, 4, 1),
(7, 5, 5, 1),
(8, 6, 6, 1),
(9, 6, 7, 1),
(10, 6, 8, 1),
(11, 7, 9, 1),
(12, 7, 10, 1),
(13, 8, 11, 1),
(14, 8, 12, 1),
(15, 9, 13, 1),
(16, 9, 14, 1),
(17, 9, 15, 1),
(18, 9, 16, 1),
(19, 9, 17, 1),
(20, 10, 18, 1),
(21, 10, 19, 1),
(22, 3, 21, 1);

TRUNCATE TABLE `modules`;

ALTER TABLE `modules` ADD `modules_icon` VARCHAR(100) NOT NULL AFTER `modules_description`;
ALTER TABLE `modules` ADD `modules_order` INT(11) NOT NULL AFTER `modules_icon`;

INSERT INTO `modules` (`modules_id`, `modules_name`, `modules_slug`, `modules_description`, `modules_icon`, `modules_order`) VALUES
(1, 'Dashboard', 'dashboard', 'Dashboard Description', 'zmdi zmdi-home', 1),
(2, 'Job Order', 'job-order', 'Job Order Description', 'zmdi zmdi-collection-text', 2),
(3, 'Maintenance', 'maintenance', 'Maintenance Description', 'zmdi zmdi-settings', 3),
(4, 'Purchase Order', 'purchase-order', 'Purchase Order Description', 'zmdi zmdi-shopping-cart', 4),
(5, 'Purchase Request', 'purchase-request', 'Purchase Request Description', 'zmdi zmdi-shopping-basket', 5),
(6, 'Bill of Materials', 'bill-of-materials', 'Bill of Materials Description', 'fa fa-cubes', 6),
(7, 'Withdrawal', 'withdrawal', 'Withdrawal Description', 'zmdi zmdi-swap', 7),
(8, 'Billing', 'billing', 'Billing Description', 'zmdi zmdi-card', 8),
(9, 'Delivery', 'delivery', 'Delivery Description', 'zmdi zmdi-truck', 9),
(10, 'Reports', 'reports', 'Reports Description', 'zmdi zmdi-print', 10);

TRUNCATE TABLE `priviledge`;

INSERT INTO `priviledge` (`priviledge_id`, `priviledge_name`, `priviledge_description`) VALUES
(1, 'admin', 'admin'),
(2, 'sales', 'sales');

TRUNCATE TABLE `priviledge_modules`;

INSERT INTO `priviledge_modules` (`priviledge_modules_id`, `priviledge_id`, `modules_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10);

TRUNCATE TABLE `resources`;

INSERT INTO `resources` (`resources_id`, `resources_type_id`, `department_id`, `resources_fname`, `resources_mname`, `resources_lname`, `resources_gender`) VALUES
(1, 1, 1, 'admin', 'admin', 'admin', 'female'),
(2, 1, 2, 'genebert', 'cordero', 'estano', 'male');

TRUNCATE TABLE `resources_level`;

INSERT INTO `resources_level` (`resources_level_id`, `level_id`, `resources_id`) VALUES
(1, 70, 1),
(2, 1, 2);

TRUNCATE TABLE `department`;

INSERT INTO `department` (`department_id`, `department_code`, `department_name`, `department_description`) VALUES
(1, 'SALES', 'sales', 'sales'),
(2, 'IT', 'IT', 'Information Technology');

SET FOREIGN_KEY_CHECKS = 1;