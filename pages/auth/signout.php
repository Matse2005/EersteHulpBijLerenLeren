<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";

// Destroy the session
session_unset();
session_destroy();

// Redirect to the signin page
location("/login");
