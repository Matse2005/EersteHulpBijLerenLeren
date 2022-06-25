<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php");
$db = database_connect();

if (isset($_SESSION["user"])) $user = $_SESSION["user"];
// Check if the file is the signin page
else if ($_SERVER["REQUEST_URI"] !== "/login") location("/login");

?>

<!DOCTYPE html>
<!--                                                                                                                                                
  __  __       _          __     ___   _ 
 |  \/  | __ _| |_ ___  __\ \   / / | | |
 | |\/| |/ _` | __/ __|/ _ \ \ / /| |_| |
 | |  | | (_| | |_\__ \  __/\ V / |  _  |
 |_|  |_|\__,_|\__|___/\___| \_/  |_| |_|
        
 Deze code is geschreven door MatseVH (matsevh.eu) 
-->
<html lang="nl">

<head>
  <!--========== META ==========-->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#F4F2ED">
  <meta name="msapplication-navbutton-color" content="#F4F2ED">
  <meta name="apple-mobile-web-app-status-bar-style" content="#F4F2ED">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="<?php print settings($db)["name"] ?>">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="description" content="<?php print texts($db)["home_subtitle"] ?>">
  <meta name="keywords" content="<?php print settings($db)["name"] ?>, Leren, MatseVH, Matse, Van Horebeek, Matse Van Horebeek">

  <!--========== FAVICON ==========-->
  <link rel="shortcut icon" href="/assets/img/header.svg">

  <!--========== CSS ==========-->
  <!-- <link rel="stylesheet" href="/assets/css/styles.css"> -->
  <link rel="stylesheet" href="/assets/css/output.css">

  <!--========== FLOWBITE ==========-->
  <!-- <script src="/assets/js/flowbite.js"></script> -->

  <!--========== TITLE ==========-->
  <?php
  $path = $_SERVER["REQUEST_URI"];
  $file = basename($path); // $file is set to "login.php"
  $file = str_replace(".php", "", $file);
  $title = ucfirst($file); // $title is set to "Login"
  if ($title == "Index" || $title == "") {
    $title = "Home";
  }
  ?>
  <title><?php print $title ?> - <?php print settings($db)["name"] ?></title>
</head>

<body class="font-source-code-pro bg-secondary">