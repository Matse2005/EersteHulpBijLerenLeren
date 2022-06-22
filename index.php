<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";

if (isset($_SESSION["user"])) {
  include_once $_SERVER["DOCUMENT_ROOT"] . "/pages/index.php";
} else {
  include_once $_SERVER["DOCUMENT_ROOT"] . "/pages/auth/signin.php";
}
