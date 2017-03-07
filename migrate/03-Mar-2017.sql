SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `direct_materials_item` CHANGE `direct_materials_item` `direct_materials_item_id` INT(11) NOT NULL AUTO_INCREMENT;

SET FOREIGN_KEY_CHECKS = 1;