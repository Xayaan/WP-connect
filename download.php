<?php

$name = strip_tags( $_GET["name"] );

header('Content-type: application/pdf');
header("Content-Disposition: attachment; filename={$name}");
readfile( 'upload/merchant/'.$name );

?>