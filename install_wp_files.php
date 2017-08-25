<?php

$sql = [];
$sql[] = "CREATE TABLE IF NOT EXISTS `wp_files` (
`id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`image` text NOT NULL,
`link` text NOT NULL,
`type` tinyint(2) NOT NULL DEFAULT '0',
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$sql[] = "ALTER TABLE `wp_files` ADD PRIMARY KEY (`id`);";
$sql[] = "ALTER TABLE `wp_files` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
$sql[] =  "ALTER TABLE `wp_files` ADD `is_seen` char(1);";
$sql[] = "ALTER TABLE `wp_files` ADD `unique_id` TEXT NOT NULL AFTER `id`;";
foreach ($sql as $key => $value)
{
    $data = $wpdb->query($value);
    print_r($data);
}
