<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
include_once $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

function location($url)
{
  // if (str_starts_with(strtolower($_SERVER['HTTP_HOST']), "localhost")) {
  //   return;
  // } else {
  if (!headers_sent()) {
    header('Location: ' . $url);
    exit;
  } else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="' . $url . '";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    echo '</noscript>';
    exit;
  }
  // }
}

function database_connect()
{
  include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/config.dist.php";

  try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // return the connection
    return $db;
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
  }
}

function getUser($db, $email = "null")
{
  if ($email == "null") {
    $email = $_SESSION["user"]["email"];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
      return $user;
    }
  } else {
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
      return $user;
    }
  }

  return false;
}

// function emails($db)
// {
//   $stmt = $db->prepare("SELECT * FROM users");
//   $stmt->execute();
//   $users = $stmt->fetchAll();

//   $emails = array();
//   foreach ($users as $user) {
//     $emails[] = $user["email"];
//   }

//   return json_encode($emails);
// }

function login($db, $email, $password)
{
  $user = getUser($db, $email);
  if ($user) {
    if (hash("sha256", $password . $user["salt"]) == $user["password"]) {

      $userData = array(
        "id" => $user["id"],
        "email" => $user["email"],
        "firstname" => $user["firstname"],
        "lastname" => $user["lastname"],
        // Gravatar image url
        "avatar" => "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user["email"]))) . "?d=identicon",
      );

      $_SESSION["user"] = $userData;
      location("/");
      exit;
    } else {
      return array("error" => "Wachtwoord is incorrect", "status" => "401");
    };
  } else {
    return array("error" => "Gebruiker kon niet gevonden worden", "status" => "404");
  }
}

function randomString($length = 25)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:<>,.?/';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function encrypt($password)
{
  $salt = randomString();
  return array(
    "salt" => $salt,
    "password" => hash("sha256", $password . $salt),
  );
}

function checkAdmin($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM admins WHERE user_id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $user = $stmt->fetch();

  if ($user) {
    return true;
  } else {
    return false;
  }
}

function texts($db)
{
  $stmt = $db->prepare("SELECT * FROM tekst LIMIT 1");
  $stmt->execute();
  $arr = $stmt->fetch();

  return $arr;
}

function bronnen($db)
{
  $stmt = $db->prepare("SELECT * FROM bronnen");
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function addBron($db, $name, $type, $url = "N/A")
{
  $stmt = $db->prepare("INSERT INTO bronnen (content, type, url) VALUES (:name, :type, :url)");
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":url", $url);
  $stmt->execute();
}

function removeBron($db, $id)
{
  $stmt = $db->prepare("DELETE FROM bronnen WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

function websites($db)
{
  $stmt = $db->prepare("SELECT * FROM websites");
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function addWebsite($db, $name, $url)
{
  $stmt = $db->prepare("INSERT INTO websites (content, url) VALUES (:name, :url)");
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":url", $url);
  $stmt->execute();
}

function removeWebsite($db, $id)
{
  $stmt = $db->prepare("DELETE FROM websites WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}


function credits($db)
{
  $stmt = $db->prepare("SELECT * FROM credits");
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function addCredit($db, $name, $url)
{
  $stmt = $db->prepare("INSERT INTO credits (content, url) VALUES (:name, :url)");
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":url", $url);
  $stmt->execute();
}

function removeCredit($db, $id)
{
  $stmt = $db->prepare("DELETE FROM credits WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

function images()
{
  $json = $_SERVER['DOCUMENT_ROOT'] . "/assets/json/poses.json";
  $json = file_get_contents($json);
  $json = json_decode($json, true);

  return $json;
}

function image($id)
{
  $json = $_SERVER['DOCUMENT_ROOT'] . "/assets/json/poses.json";
  $json = file_get_contents($json);
  $json = json_decode($json, true);
  foreach ($json as $key => $value) {
    if ($value['id'] == $id) {
      $pose = $value;
      return $pose;
    }
  }
}

function categories($db)
{
  $stmt = $db->prepare("SELECT * FROM category");
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function getCategory($db, $slug)
{
  $stmt = $db->prepare("SELECT * FROM category WHERE slug = :slug");
  $stmt->bindParam(":slug", $slug);
  $stmt->execute();
  $arr = $stmt->fetch();

  return $arr;
}

function getCategoryByID($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM category WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $arr = $stmt->fetch();

  return $arr;
}

function getSubCategoriesByCategroyID($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM subcategory WHERE category = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function getSubCategorieByID($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM subcategory WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $arr = $stmt->fetch();

  return $arr;
}

function getTipsByCategoryID($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM tips WHERE subcategory = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function resultID($db, $id)
{
  // Maak dit na formulier
}

function format($timestamp)
{
  $date = new DateTime($timestamp);
  $date = $date->format("l d F Y");
  $date = str_replace("Monday", "Maandag", $date);
  $date = str_replace("Tuesday", "Dinsdag", $date);
  $date = str_replace("Wednesday", "Woensdag", $date);
  $date = str_replace("Thursday", "Donderdag", $date);
  $date = str_replace("Friday", "Vrijdag", $date);
  $date = str_replace("Saturday", "Zaterdag", $date);
  $date = str_replace("Sunday", "Zondag", $date);

  $date = str_replace("January", "januari", $date);
  $date = str_replace("February", "februari", $date);
  $date = str_replace("March", "maart", $date);
  $date = str_replace("April", "april", $date);
  $date = str_replace("May", "mei", $date);
  $date = str_replace("June", "juni", $date);
  $date = str_replace("July", "juli", $date);
  $date = str_replace("August", "augustus", $date);
  $date = str_replace("September", "september", $date);
  $date = str_replace("October", "oktober", $date);
  $date = str_replace("November", "november", $date);
  $date = str_replace("December", "december", $date);

  return $date;
}

function subCategories($db, $category = "null")
{
  if ($category == "null") $stmt = $db->prepare("SELECT * FROM tips");
  else  $stmt = $db->prepare("SELECT * FROM subcategory WHERE category = :category");

  $stmt->bindParam(":category", $category);
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function articles($db)
{
  $stmt = $db->prepare("SELECT * FROM articles");
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function getArticle($db, $slug)
{
  $stmt = $db->prepare("SELECT * FROM articles WHERE slug = :slug");
  $stmt->bindParam(":slug", $slug);
  $stmt->execute();
  $arr = $stmt->fetch();

  return $arr;
}

function newArticle($db, $title, $slug, $description, $content)
{
  $stmt = $db->prepare("SELECT slug FROM articles");
  $stmt->execute();
  $arr = $stmt->fetchAll();

  $slugs = array();
  foreach ($arr as $key => $value) {
    $slugs[] = $value["slug"];
  }

  if (in_array($slug, $slugs)) {
    $slug = $slug . "-" . rand(1, 100);
  }

  $stmt = $db->prepare("INSERT INTO articles (title, slug, description, content) VALUES (:title, :slug, :description, :content)");
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":slug", $slug);
  $stmt->execute();

  // Close the popup
  echo "<script>window.close();</script>";
}

function removeArticle($db, $id)
{
  $stmt = $db->prepare("DELETE FROM articles WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

function editArticle($db, $id, $title, $slug, $description, $content)
{
  $stmt = $db->prepare("UPDATE articles SET title = :title, slug = :slug, description = :description, content = :content WHERE id = :id");
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":slug", $slug);
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  // Close the popup
  echo "<script>window.close();</script>";
}

function updateHomePage($db, $home_title, $home_subtitle, $home_howitworks_one_title, $home_howitworks_one_subtitle, $home_howitworks_two_title, $home_howitworks_two_subtitle, $home_howitworks_three_title, $home_howitworks_three_subtitle, $home_extra_websites, $home_extra_bronnen, $home_extra_credits)
{
  $stmt = $db->prepare("UPDATE tekst SET home_title = :home_title, home_subtitle = :home_subtitle, home_howitworks_one_title = :home_howitworks_one_title, home_howitworks_one_subtitle = :home_howitworks_one_subtitle, home_howitworks_two_title = :home_howitworks_two_title, home_howitworks_two_subtitle = :home_howitworks_two_subtitle, home_howitworks_three_title = :home_howitworks_three_title, home_howitworks_three_subtitle = :home_howitworks_three_subtitle, home_extra_websites = :home_extra_websites, home_extra_bronnen = :home_extra_bronnen, home_extra_credits = :home_extra_credits");
  $stmt->bindParam(":home_title", $home_title);
  $stmt->bindParam(":home_subtitle", $home_subtitle);
  $stmt->bindParam(":home_howitworks_one_title", $home_howitworks_one_title);
  $stmt->bindParam(":home_howitworks_one_subtitle", $home_howitworks_one_subtitle);
  $stmt->bindParam(":home_howitworks_two_title", $home_howitworks_two_title);
  $stmt->bindParam(":home_howitworks_two_subtitle", $home_howitworks_two_subtitle);
  $stmt->bindParam(":home_howitworks_three_title", $home_howitworks_three_title);
  $stmt->bindParam(":home_howitworks_three_subtitle", $home_howitworks_three_subtitle);
  $stmt->bindParam(":home_extra_websites", $home_extra_websites);
  $stmt->bindParam(":home_extra_bronnen", $home_extra_bronnen);
  $stmt->bindParam(":home_extra_credits", $home_extra_credits);
  $stmt->execute();
}

function saveResult($db, $user_id, $result)
{
  $stmt = $db->prepare("INSERT INTO results (user_id, results) VALUES (:user_id, :results)");
  $stmt->bindParam(":user_id", $user_id);
  $stmt->bindParam(":results", $result);
  $stmt->execute();

  // Close the popup
  echo "<script>window.close();</script>";
}

function settings($db)
{
  $stmt = $db->prepare("SELECT * FROM settings");
  $stmt->execute();
  $arr = $stmt->fetch();

  return $arr;
}

function settingsUpdate($db, $name)
{
  $stmt = $db->prepare("UPDATE settings SET name = :name");
  $stmt->bindParam(":name", $name);
  $stmt->execute();
}

function settingsLogo($db, $logo)
{
  $stmt = $db->prepare("UPDATE settings SET logo = :logo");
  $stmt->bindParam(":logo", $logo);
  $stmt->execute();
}

function results($db, $user)
{
  $stmt = $db->prepare("SELECT * FROM results WHERE user_id = :user_id");
  $stmt->bindParam(":user_id", $user["id"]);
  $stmt->execute();
  $arr = $stmt->fetchAll();

  return $arr;
}

function user($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $arr = $stmt->fetch();

  return $arr;
}

function getResult($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM results WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $arr = $stmt->fetch();

  // Update result watched status
  $now = date("Y-m-d H:i:s");

  $stmt = $db->prepare("UPDATE results SET watched_at = :watched_at WHERE id = :id");
  $stmt->bindParam(":watched_at", $now);
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  return $arr;
}

function stats($db)
{
  // Create counter array
  $arr = array();

  // Count all filled in results
  $stmt = $db->prepare("SELECT COUNT(*) FROM results WHERE results != ''");
  $stmt->execute();
  $arr["results"] = $stmt->fetchColumn();

  // Count all articles
  $stmt = $db->prepare("SELECT COUNT(*) FROM articles");
  $stmt->execute();
  $arr["articles"] = $stmt->fetchColumn();

  // Count all categories
  $stmt = $db->prepare("SELECT COUNT(*) FROM category");
  $stmt->execute();
  $arr["categories"] = $stmt->fetchColumn();

  // Count all tips
  $stmt = $db->prepare("SELECT COUNT(*) FROM tips");
  $stmt->execute();
  $arr["tips"] = $stmt->fetchColumn();

  // Return the array
  return $arr;
}

function users($db)
{
  $stmt = $db->prepare("SELECT * FROM users");
  $stmt->execute();
  $arr = $stmt->fetchAll();
  $returnArr = array();
  foreach ($arr as $user) {
    $returnArr[$user["id"]] = array(
      "id" => $user["id"],
      "firstname" => $user["firstname"],
      "lastname" => $user["lastname"],
      "email" => $user["email"]
    );
  }

  return $arr;
}

function emails($db)
{
  $emails = array();
  foreach (users($db) as $user)
    $emails[] = $user["email"];

  return $emails;
}

function userCreate($db, $firstname, $lastname, $email, $password)
{
  $hashed = encrypt($password);

  $stmt = $db->prepare("INSERT INTO users (firstname, lastname, email, password, salt, status) VALUES (:firstname, :lastname, :email, :password, :salt, 'unchanged')");
  $stmt->bindParam(":firstname", $firstname);
  $stmt->bindParam(":lastname", $lastname);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":password", $hashed["password"]);
  $stmt->bindParam(":salt", $hashed["salt"]);
  $stmt->execute();

  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/config.dist.php";

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->CharSet = "utf-8";                                      //Send using SMTP
    $mail->Host       = "mail.m-vh.eu";                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = "noreply@m-vh.eu";                     //SMTP username
    $mail->Password   = "Neeltje123";                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("noreply@m-vh.eu", settings($db)["name"]);
    $mail->addAddress($email, $firstname . " " . $lastname);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Jou account voor " . settings($db)["name"] . " is aangemaakt";
    // Include HTML files as $mail->Body 
    $template = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/includes/emails/user-create.html");
    $template = str_replace("{firstname}", $firstname, $template);
    $template = str_replace("{lastname}", $lastname, $template);
    $template = str_replace("{email}", $email, $template);
    $template = str_replace("{password}", $password, $template);
    $template = str_replace("{login_url}", "https://" . $_SERVER["HTTP_HOST"] . "/login", $template);
    $template = str_replace("{name}", settings($db)["name"], $template);
    $template = str_replace("{url}", $_SERVER["HTTP_HOST"], $template);
    $mail->Body = $template;
    $mail->AltBody = "Er is een account aangemaakt voor " . $_SERVER["HTTP_HOST"] . " met de volgende gegevens: Voornaam: " . $firstname . ", Achternaam: " . $lastname . ", Email: " . $email . ", Wachtwoord: " . $password . "Verander dit wachtwoord nadat je bent ingelogd.";

    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

function userRemove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  adminRemove($db, $id);
}

function admins($db)
{
  $admins = array();
  $stmt = $db->prepare("SELECT * FROM admins");
  $stmt->execute();
  $arr = $stmt->fetchAll();
  foreach ($arr as $admin) {
    $admins[] = array(
      "id" => user($db, $admin["user_id"])["id"],
      "firstname" => user($db, $admin["user_id"])["firstname"],
      "lastname" => user($db, $admin["user_id"])["lastname"],
      "email" => user($db, $admin["user_id"])["email"]
    );
  }

  return $admins;
}

function adminRemove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM admins WHERE user_id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

function adminCreate($db, $id)
{
  $stmt = $db->prepare("INSERT INTO admins (user_id) VALUES (:id)");
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  $user = user($db, $id);

  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/config.dist.php";

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->CharSet = "utf-8";                                      //Send using SMTP
    $mail->Host       = "mail.m-vh.eu";                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = "noreply@m-vh.eu";                     //SMTP username
    $mail->Password   = "Neeltje123";                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("noreply@m-vh.eu", settings($db)["name"]);
    $mail->addAddress($user["email"], $user["firstname"] . " " . $user["lastname"]);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Jou account op " . settings($db)["name"] . " is nu een beheerders account";
    // Include HTML files as $mail->Body 
    $template = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/includes/emails/admin.html");
    $template = str_replace("{firstname}", $user["firstname"], $template);
    $template = str_replace("{lastname}", $user["lastname"], $template);
    $template = str_replace("{email}", $user["email"], $template);
    $template = str_replace("{name}", settings($db)["name"], $template);
    $template = str_replace("{url}", $_SERVER["HTTP_HOST"], $template);
    $mail->Body = $template;
    $mail->AltBody = "Jou account op " . settings($db)["name"] . " is nu een beheerders account, dat wilt zeggen dat jij nu de rechten hebt om de website te beheren.";

    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
