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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--========== FAVICON ==========-->
  <link rel="shortcut icon" href="/assets/img/header.svg">

  <!--========== BOX ICONS ==========-->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <!--========== FONT AWESOME ==========-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!--========== CSS ==========-->
  <link rel="stylesheet" href="/assets/css/styles.css">
  <link rel="stylesheet" href="/assets/css/output.css">

  <!--========== JS ==========-->
  <script src="/assets/js/script.js"></script>

  <!--========== DATATABLES ==========-->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="  https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

  <!--========== RECAPTCHA ==========-->
  <script src="https://www.google.com/recaptcha/api.js"></script>

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
  <title><?php print $title ?></title>
</head>

<body class="font-source-code-pro bg-secondary">