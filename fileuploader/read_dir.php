<?php

include('../include.php');

$searchForAdvertisements = 2; // Non ads are type 2, ads are type 1, who knows why.
if(isset($_GET["ads"]))
	$searchForAdvertisements = 1;

$files;

if(wp_get_current_user()->roles[0] == 'administrator')
{
	$files = $wpdb->get_results("SELECT unique_id, image FROM wp_files WHERE type=" . $searchForAdvertisements, ARRAY_A);
}
else
{
	$files = $wpdb->get_results("SELECT unique_id, image FROM wp_files WHERE type=" . $searchForAdvertisements . " AND user_id=" . wp_get_current_user()->ID, ARRAY_A);
}


echo json_encode(($files) ? $files : false);


