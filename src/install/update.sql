ALTER TABLE `pre_smtp`
ADD `smtp_from_name` varchar(100) DEFAULT NULL COMMENT 'SMTP发信人名字' AFTER `smtp_from`;
