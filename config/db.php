<?php

define('DB_SERVER', 'ireversedb.mysql.database.azure.com');
define('DB_USERNAME', 'Aldazunlock');
define('DB_PASSWORD', 'Eli32312.17');
define('DB_NAME', 'licencias');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false)
{
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8");

?>