<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php");
$db = database_connect();

if (!isset($_GET["id"])) location("/bestanden");
if (!file_download($db, $_GET["id"])) location("/bestanden");
exit;
