CREATE TABLE IF NOT EXISTS `customer_details` (
  `id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `first_name` char(25) NOT NULL,
  `last_name` char(25) NOT NULL,
  `address` char(100) NOT NULL,
  `city` char(50) NOT NULL,
  `state` char(2) NOT NULL,
  `phone` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
