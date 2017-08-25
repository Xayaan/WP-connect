<?php

//define( 'BLOCK_LOAD', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/beta/wp-config.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/beta/wp-includes/wp-db.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/beta/wp-includes/pluggable.php' );

$wpdb = new wpdb( get_defined_constants(true)['user']['DB_USER'] , get_defined_constants(true)['user']['DB_PASSWORD'], get_defined_constants(true)['user']['DB_NAME'], get_defined_constants(true)['user']['DB_HOST']);
