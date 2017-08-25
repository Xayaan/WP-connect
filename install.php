<?php
/**
 * Created by PhpStorm.
 * User: Zayaan
 * Date: 8/8/2016
 * Time: 11:50 AM
 */
/*//files
FILES:
    C:\xampp\htdocs\merchant\wp-admin\menu-header.php

    SUPPORT CENTER
    C:\xampp\htdocs\merchant\wp-content\plugins\di-aiosc\templates\admin\ticket\form.php
    C:\xampp\htdocs\merchant\wp-content\plugins\di-aiosc\templates\admin\ticket\preview.php

    PROFILE
    C:\xampp\htdocs\merchant\wp-admin\user-edit.php

    MERCHANT CONNECT
    C:\xampp\htdocs\merchant\wp-content\plugins\userpanel\userpanel.php
    C:\xampp\htdocs\merchant\wp-includes\user.php


PLUGINS:
    Advanced Custom Fields 4.4.8

DATABASE:
    - table
        - wp_merchant
        - wp_rewards
*/

require_once( 'include.php' );

$sql = "CREATE TABLE IF NOT EXISTS `wp_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` int(11) DEFAULT '0',
  `earn` int(11) DEFAULT '0',
  `redeem` int(11) DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `total` int(11) DEFAULT '0',
  `reward` varchar(255) DEFAULT NULL,
  `data` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$wpdb->query($sql);

/*


ALTER TABLE wp_statements
ADD COLUMN `user_id` INT(11) NOT NULL DEFAULT 0 AFTER `id`;




CREATE TABLE IF NOT EXISTS `wp_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `link` text NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `wp_files`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wp_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wp_files` ADD `is_seen` char(1);

ALTER TABLE `wp_files` ADD `unique_id` TEXT NOT NULL AFTER `id`;

CREATE TABLE IF NOT EXISTS `wp_statements` (
  `id` int(11) NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `due_date` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `wp_statements`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wp_statements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

*/

/*
$sql = "CREATE TABLE IF NOT EXISTS `wp_merchant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


ALTER TABLE wp_merchant ADD COLUMN `archive` TINYINT(2) NOT NULL DEFAULT 0 AFTER `message`;

$data = $wpdb->query($sql);
*/