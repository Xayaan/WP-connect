<?php
$sql = [];
$sql[] = "CREATE TABLE IF NOT EXISTS `wp_statements` (
`id` int(11) NOT NULL,
`ref_no` varchar(255) NOT NULL,
`date` datetime NOT NULL,
`description` text NOT NULL,
`due_date` datetime NOT NULL,
`amount` decimal(10,2) NOT NULL DEFAULT '0.00',
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$sql[] = "ALTER TABLE `wp_statements`
ADD PRIMARY KEY (`id`);";

$sql[] = "ALTER TABLE `wp_statements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

$sql[] = "ALTER TABLE `wp_statements`
add column `user_id` bigint(20) unsigned";

foreach ($sql as $key => $value)
{
    $data = $wpdb->query($value);
    var_dump($data);
}