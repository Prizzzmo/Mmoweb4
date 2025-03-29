
-- Create database
CREATE DATABASE IF NOT EXISTS mmoweb_local DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE mmoweb_local;

-- Create mw_session table
CREATE TABLE IF NOT EXISTS `mw_session` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `session_id` varchar(150) NOT NULL DEFAULT '',
    `data` mediumtext,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create mw_news table
CREATE TABLE IF NOT EXISTS `mw_news` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `json` mediumtext NOT NULL,
    `date` datetime NOT NULL,
    `author` varchar(100) NOT NULL,
    `publish` int(1) NOT NULL DEFAULT '1',
    `fixed` int(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `publish` (`publish`),
    KEY `fixed` (`fixed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create mw_item_db table
CREATE TABLE IF NOT EXISTS `mw_item_db` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `item_id` int(11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `add_name` varchar(100) DEFAULT NULL,
    `description` text,
    `icon` varchar(100) DEFAULT NULL,
    `icon_panel` varchar(100) DEFAULT NULL,
    `grade` varchar(10) DEFAULT NULL,
    `type` varchar(20) DEFAULT NULL,
    `price` int(11) NOT NULL DEFAULT '0',
    `max_count` int(11) NOT NULL DEFAULT '0',
    `stackable` int(1) NOT NULL DEFAULT '0',
    `sid` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `item_id` (`item_id`),
    KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create mw_users table
CREATE TABLE IF NOT EXISTS `mw_users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    `status` tinyint(1) DEFAULT '1',
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create mw_config table
CREATE TABLE IF NOT EXISTS `mw_config` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `value` text NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
