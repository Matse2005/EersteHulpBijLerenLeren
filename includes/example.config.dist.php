<?php
// Database connection
$servername = "db_host";
$dbname = "db_name";
$username = "db_user";
$password = "db_password";

// SMTP
$smtp_host = "smtp_host";
$smtp_user = "smtp_user";
$smtp_pass = "smtp_password";

// Smartschool
$smartschool = [
  // OAUTH CLIENTID
  'oauthClient'   => '',
  // OAUTH CLIENT PASSWORD
  'oauthPassword' => '',
  // BETREKKING OP DIT PLATFORM
  'platform'      => 'ksdiest.smartschool.be',
  // WEBSERVICES WACHTWOORD
  'webservicesww' => '',
  // LIJST VAN GEBRUIKERSNAMEN DIE HET PLATFORM MOGEN BEHEEREN
  'admins'      => [
    'matse.vanhorebeek',
  ],
];
