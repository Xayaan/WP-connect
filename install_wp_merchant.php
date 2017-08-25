<?php
$sql = [];
$sql[] = "CREATE TABLE IF NOT EXISTS `wp_merchant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[] = " ALTER TABLE wp_merchant ADD COLUMN `archive` TINYINT(2) NOT NULL DEFAULT 0 AFTER `message`";
$sql[] = " ALTER TABLE wp_merchant ADD COLUMN `file_id` varchar(11) NOT NULL DEFAULT 0 AFTER `message`";
foreach ($sql as $key => $value) {
    $data = $wpdb->query($value);
    var_dump($data);
}
echo 'done';
