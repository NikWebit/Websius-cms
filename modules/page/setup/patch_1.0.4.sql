ALTER TABLE `cot_pages`
CHANGE `page_alias`   `page_alias` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_state`   `page_state` TINYINT(1) UNSIGNED DEFAULT '0',
CHANGE `page_desc`    `page_desc` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_keywords` `page_keywords` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_metatitle` `page_metatitle` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_metadesc` `page_metadesc` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_text`    `page_text` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE `page_parser`  `page_parser` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_author`  `page_author` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_ownerid` `page_ownerid` INT(11) DEFAULT '0',
CHANGE `page_date`    `page_date` INT(11) DEFAULT '0',
CHANGE `page_begin`   `page_begin` INT(11) DEFAULT '0',
CHANGE `page_expire`  `page_expire` INT(11) DEFAULT '0',
CHANGE `page_updated` `page_updated` INT(11) DEFAULT '0',
CHANGE `page_file`    `page_file` TINYINT(1) UNSIGNED DEFAULT '0',
CHANGE `page_url`     `page_url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
CHANGE `page_size`    `page_size` INT(11) UNSIGNED DEFAULT '0',
CHANGE `page_rating`  `page_rating` DECIMAL(5,2) DEFAULT '0.00',
CHANGE `page_filecount` `page_filecount` MEDIUMINT(8) UNSIGNED DEFAULT '0';
