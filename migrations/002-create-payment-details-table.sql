CREATE TABLE IF NOT EXISTS `payment_details` (
  `id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `card_type` tinyint(1) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `card_exp_date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);
