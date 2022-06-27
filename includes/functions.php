<?php
/* ------------------------------------------------------------------------

    @ Name: functions.php
    @ Author: MatseVH - https://www.matsevh.eu
    @ Version: 1.0.1
    @ Date: 06-25-2022 <MM-DD-YYYY>
    @ Description: This file contains all the functions used in the website
    @ License: GNU General Public License v3.0
    @ License URI: http://www.gnu.org/licenses/gpl-3.0.html

------------------------------------------------------------------------ */

// Start the session
session_start();

// Active the PHPMailer class 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load the composer autoloader -> Load the PHPMailer class
require_once $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

/*
  # name: location 
  # description: 
      This function will replace the php header function to redirect to a specific page. 
      It will use the header function to redirect to the page if the headers are not sent.
      e.g. header("location: index.php");
      Otherwise it will use javascript or meta refresh to redirect to the page.
  # parameters:
      $location: The location to redirect to.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function location($location)
{
  if (headers_sent()) {
    echo '<script type="text/javascript">';
    echo 'window.location.href="' . $location . '";';
    echo '</script>';
    echo '<meta http-equiv="refresh" content="0; url=' . $location . '" />';
  } else {
    header("location: " . $location);
  }
}

/*
  # name: database_connect
  # description: 
      This function will connect to the database with pdo.
  # parameters:
      None
  # returns:
      $db: The database connection.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function database_connect()
{
  include $_SERVER["DOCUMENT_ROOT"] . "/includes/config.dist.php";

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

/* 
  # name: emails
  # description: 
      This function will return all the emails from the database.
  # parameters:
      $db: The database connection.
  # returns:
      $emails: The emails from the database.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function emails($db)
{
  $emails = array();
  foreach (users($db) as $user)
    $emails[] = $user["email"];

  return $emails;
}

/*
  # name: users
  # description: 
      This function will return the users from the database.
  # parameters:
      $db: The database connection.
  # returns:
      $users: The users from the database.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function users($db)
{
  $stmt = $db->prepare("SELECT * FROM users");
  $stmt->execute();
  $users = $stmt->fetchAll();
  $returnArr = array();
  foreach ($users as $user) {
    $returnArr[$user["id"]] = array(
      "id" => $user["id"],
      "firstname" => $user["firstname"],
      "lastname" => $user["lastname"],
      "email" => $user["email"]
    );
  }

  return $users;
}

/*
  # name: user 
  # description: 
      This function will return the user from the database.
  # parameters:
      $db: The database connection.
      $user_id: The user id.
  # returns:
      $user: The user.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function user($db, $user_id)
{
  $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
  $stmt->bindParam(":id", $user_id);
  $stmt->execute();
  $user = $stmt->fetch();

  return $user;
}

/*
  # name: user_by_email 
  # description: 
      This function will return the user from the database.
  # parameters:
      $db: The database connection.
      optional $email: The email.
        - If not set, it will return the current user.
  # returns:
      $user: The user.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function user_by_email($db, $email = "null")
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

/*
  # name: user_create
  # description: 
      This function will create a new user in the database.
  # parameters:
      $db: The database connection.
      $firstname: The firstname.
      $lastname: The lastname.
      $email: The email.
      $password: The password.
  # returns:
      $user: The user.
  # author: MatseVH
  # modified: 06-26-2022 <MM-DD-YYYY>
*/
function user_create($db, $firstname, $lastname, $email)
{
  $password = string_random(32);
  $hashed = string_encrypt($password);

  $stmt = $db->prepare("INSERT INTO users (firstname, lastname, email, password, salt) VALUES (:firstname, :lastname, :email, :password, :salt)");
  $stmt->bindParam(":firstname", $firstname);
  $stmt->bindParam(":lastname", $lastname);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":password", $hashed["string"]);
  $stmt->bindParam(":salt", $hashed["salt"]);
  $stmt->execute();

  // Send email to user
  $to = $email;
  $to_name = $firstname . " " . $lastname;
  $subject = "Welkom bij " . settings($db)["name"];
  $title = "Welkom bij " . settings($db)["name"];
  $content = "
    <p>
      Hallo " . $firstname . ",<br>
      <br>
      Jouw account voor " . settings($db)["name"] . " is aangemaakt.<br>
      De gegevens die bij je account behoren zijn:<br>
      <br>
      E-mail: " . $email . "<br>
      Wachtwoord: " . $password . "<br>
      Probeer je wachtwoord te wijzigen na het eerste login.<br>
      <br>
      <br>
      Met vriendelijke groet,<br>
      " . settings($db)["name"] . "
    </p>
  ";
  $button_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/login";
  $button_text = "Inloggen";
  email_send($db, $to, $to_name, $subject, $title, $content, $button_text, $button_link);
}

/*
  # name: user_update
  # description: 
      This function will update a user in the database.
  # parameters:
      $db: The database connection.
      $user_id: The user id.
      $firstname: The firstname.
      $lastname: The lastname.
  # returns:
      None.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function user_update($db, $user_id = null, $firstname, $lastname)
{
  if ($user_id == null) {
    $user_id = $_SESSION["user"]["id"];
  }
  $stmt = $db->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname WHERE id = :id");
  $stmt->bindParam(":firstname", $firstname);
  $stmt->bindParam(":lastname", $lastname);
  $stmt->bindParam(":id", $user_id);
  $stmt->execute();

  // Update sessions
  $_SESSION["user"]["firstname"] = $firstname;
  $_SESSION["user"]["lastname"] = $lastname;
}

/*
  # name: user_remove
  # description: 
      This function will remove a user from the database.
  # parameters:
      $db: The database connection.
      $user_id: The user id.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function user_remove($db, $user_id)
{
  admin_remove($db, $user_id);

  $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
  $stmt->bindParam(":id", $user_id);
  $stmt->execute();
}

/* 
  # name: user_password_send
  # description: 
      This function will reset the password of a user.
  # parameters:
      $db: The database connection.
      $email: The email.
  # returns:
      None
  # author: MatseVH
  # modified: 06-26-2022 <MM-DD-YYYY>
*/
function user_password_send($db, $email)
{
  $user = user_by_email($db, $email);

  if ($user) {
    $new_password = string_random(32);
    $hashed = string_encrypt($new_password, 1);

    $stmt = $db->prepare("UPDATE users SET password = :password, salt = :salt WHERE id = :id");
    $stmt->bindParam(":password", $hashed["string"]);
    $stmt->bindParam(":salt", $hashed["salt"]);
    $stmt->bindParam(":id", $user["id"]);
    $stmt->execute();

    // Send email to user
    $to = $email;
    $to_name = $user["firstname"] . " " . $user["lastname"];
    $subject = "Wachtwoord reset bij " . settings($db)["name"];
    $title = "Wachtwoord reset bij " . settings($db)["name"];
    $content = "
      <p>
        Hallo " . $user["firstname"] . ",<br>
        <br>
        Je wachtwoord is gereset.<br>
        <strong>Je nieuwe wachtwoord is:</strong> " . $new_password . "<br>

        Pas je wachtwoord aan na de eerste keer opnieuw inloggen.<br>
        <br>
        <br>
        Met vriendelijke groet,<br>
        " . settings($db)["name"] . "
      </p>
    ";
    $button_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/profiel";
    $button_text = "Inloggen";
    email_send($db, $to, $to_name, $subject, $title, $content, $button_text, $button_link);

    location("/login");
  }
}

/*
  # name: user_password_update
  # description: 
      This function will update the current user's password in the database.
  # parameters:
      $db: The database connection.
      $current_password: The current password.
      $new_password: The new password.
      $confirm_password: The confirm password.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function user_password_update($db,  $current_password, $new_password, $confirm_password)
{
  // Check if current password is correct
  $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
  $stmt->bindParam(":id", $_SESSION["user"]["id"]);
  $stmt->execute();
  $user = $stmt->fetch();

  // Hash the current password
  $current_password = hash("sha256", $current_password . $user["salt"]);

  // Check if current password is correct
  if ($current_password != $user["password"]) {
    $_SESSION["error"] = array(
      "code" => "PASSWORD",
      "message" => "Het huidige wachtwoord is niet correct."
    );
    return false;
  }

  // Check if new password is the same as the confirm password
  if ($new_password != $confirm_password) {
    $_SESSION["error"] = array(
      "code" => "PASSWORD",
      "message" => "De nieuwe wachtwoorden komen niet overeen."
    );
    return false;
  }

  // Check if new password is too short
  if (strlen($new_password) < 8) {
    $_SESSION["error"] = array(
      "code" => "PASSWORD",
      "message" => "Het nieuwe wachtwoord is te kort."
    );
    return false;
  }

  // Check if new password is too long
  if (strlen($new_password) > 64) {
    $_SESSION["error"] = array(
      "code" => "PASSWORD",
      "message" => "Het nieuwe wachtwoord is te lang."
    );
    return false;
  }

  // Save new password
  if (!isset($_SESSION["error"])) {
    $salt = hash("sha256", rand(0, 999999999));
    $new_password = hash("sha256", $new_password . $salt);
    $stmt = $db->prepare("UPDATE users SET password = :password, salt = :salt WHERE id = :id");
    $stmt->bindParam(":password", $new_password);
    $stmt->bindParam(":salt", $salt);
    $stmt->bindParam(":id", $_SESSION["user"]["id"]);
    $stmt->execute();
  }
}

/*
  # name: user_login
  # description: 
      This function will log a user in.
  # parameters:
      $db: The database connection.
      $email: The email.
      $password: The password.
  # returns:
      None
  # author: MatseVH
  # modified: 06-26-2022 <MM-DD-YYYY>
*/
function user_login($db, $email, $password)
{
  $user = user_by_email($db, $email);
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
      // Check if there is a redirect url
      if (isset($_SESSION["redirect"])) {
        $redirect = $_SESSION["redirect"];
        unset($_SESSION["redirect"]);
        location($redirect);
      } else {
        location("/");
      }
      exit;
    } else {
      return array("error" => "Wachtwoord is incorrect", "status" => "401");
    };
  } else {
    return array("error" => "Gebruiker kon niet gevonden worden", "status" => "404");
  }
}

/*
  # name: admins
  # description: 
      This function will return all admins.
  # parameters:
      $db: The database connection.
  # returns:
      An array of admins.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
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

/*
  # name: admin_add
  # description: 
      This function will add an admin.
  # parameters:
      $db: The database connection.
      $user_id: The user id.
  # returns:
      None
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function admin_add($db, $user_id)
{
  $stmt = $db->prepare("INSERT INTO admins (user_id) VALUES (:user_id)");
  $stmt->bindParam(":user_id", $user_id);
  $stmt->execute();

  $user = user($db, $user_id);

  // Send email to user
  $to = $user["email"];
  $to_name = $user["firstname"] . " " . $user["lastname"];
  $subject = "Je bent toegevoegd als beheerder";
  $title = "Je bent toegevoegd als beheerder";
  $content = "
    <p>
      Hallo " . $user["firstname"] . ",<br>
      Jou account op de website van " . settings($db)["name"] . " is aangepast naar een beheerders account. <br>
      <br>
      <br>
      Met vriendelijke groet,<br>
      " . settings($db)["name"] . "
  ";
  $button_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/dashboard/";
  $button_text = "Ga naar de dashboard";

  email_send($db, $to, $to_name, $subject, $title, $content, $button_text, $button_link);
}

/*
  # name: admin_remove
  # description: 
      This function will remove an admin.
  # parameters:
      $db: The database connection.
      $user_id: The user id.
  # returns:
      None
  # author: MatseVH
  # modified: 06-26-2022 <MM-DD-YYYY>
*/
function admin_remove($db, $user_id)
{
  $stmt = $db->prepare("DELETE FROM admins WHERE user_id = :user_id");
  $stmt->bindParam(":user_id", $user_id);
  $stmt->execute();

  $user = user($db, $user_id);

  // Send email to user
  $to = $user["email"];
  $to_name = $user["firstname"] . " " . $user["lastname"];
  $subject = "Je bent verwijderd als administrator";
  $title = "Je bent verwijderd als administrator";
  $content = "
      <p>
        Hallo " . $user["firstname"] . ",<br>
        Jou account op de website van " . settings($db)["name"] . " is aangepast naar een gebruiker account. <br>
        <br>
        <br>
        Met vriendelijke groet,<br>
        " . settings($db)["name"] . "
    ";
  $button_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
  $button_text = "Ga naar website";

  email_send($db, $to, $to_name, $subject, $title, $content, $button_text, $button_link);
}

/*
  # name: admin_check
  # description: 
      This function will check if a user is an admin.
  # parameters:
      $db: The database connection.
      $user_id: The user id.
  # returns:
      True if the user is an admin, false if not.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function admin_check($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM admins WHERE user_id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $user = $stmt->fetch();

  if ($user)  return true;
  else return false;
}

/*
  # name: bronnen
  # description: 
      This function will return all bronnen.
  # parameters:
      $db: The database connection.
  # returns:
      An array of sources.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function bronnen($db)
{
  $bronnen = array();
  $stmt = $db->prepare("SELECT * FROM bronnen");
  $stmt->execute();
  $sources = $stmt->fetchAll();

  return $sources;
}

/*
  # name: bron_add
  # description: 
      This function will add a bron.
  # parameters:
      $db: The database connection.
      $name: The name of the bron.
      optional: $url: The url of the bron.
  # returns:
      None
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function bron_add($db, $content, $type, $url = "N/A")
{
  $stmt = $db->prepare("INSERT INTO bronnen (content, type, url) VALUES (:content, :type, :url)");
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":url", $url);
  $stmt->execute();
}

/*
  # name: bron_remove
  # description: 
      This function will remove a bron.
  # parameters:
      $db: The database connection.
      $id: The id of the bron.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function bron_remove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM bronnen WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/* 
  # name: websites
  # description: 
      This function will return all websites. 
  # parameters:
      $db: The database connection.
  # returns:
      An array of websites.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function websites($db)
{
  $websites = array();
  $stmt = $db->prepare("SELECT * FROM websites");
  $stmt->execute();
  $websites = $stmt->fetchAll();

  return $websites;
}

/*
  # name: website_add
  # description: 
      This function will add a website.
  # parameters:
      $db: The database connection.
      $name: The name of the website.
      $url: The url of the website.
  # returns:
      None
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function website_add($db, $content, $url)
{
  $stmt = $db->prepare("INSERT INTO websites (content, url) VALUES (:content, :url)");
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":url", $url);
  $stmt->execute();
}

/*
  # name: website_remove
  # description: 
      This function will remove a website.
  # parameters:
      $db: The database connection.
      $id: The id of the website.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function website_remove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM websites WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/*
  # name: credits
  # description: 
      This function will return all credits.
  # parameters:
      $db: The database connection.
  # returns:
      An array of credits.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function credits($db)
{
  $credits = array();
  $stmt = $db->prepare("SELECT * FROM credits");
  $stmt->execute();
  $credits = $stmt->fetchAll();

  return $credits;
}

/*
  # name: credit_add
  # description: 
      This function will add a credit.
  # parameters:
      $db: The database connection.
      $name: The name of the credit.
      $url: The url of the credit.
  # returns:
      None
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function credit_add($db, $content, $url)
{
  $stmt = $db->prepare("INSERT INTO credits (content, url) VALUES (:content, :url)");
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":url", $url);
  $stmt->execute();
}

/*
  # name: credit_remove
  # description: 
      This function will remove a credit.
  # parameters:
      $db: The database connection.
      $id: The id of the credit.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function credit_remove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM credits WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/*
  # name: categories
  # description: 
      This function will return all categories.
  # parameters:
      $db: The database connection.
  # returns:
      An array of categories.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function categories($db)
{
  $stmt = $db->prepare("SELECT * FROM category");
  $stmt->execute();
  $categories = $stmt->fetchAll();

  return $categories;
}

/*
  # name: category_get_by_id
  # description: 
      This function will return a category.
  # parameters:
      $db: The database connection.
      $id: The id of the category.
  # returns:
      A category.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function category_get_by_id($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM category WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $category = $stmt->fetch();

  return $category;
}

/*
  # name: category_add
  # description: 
      This function will add a category.
  # parameters:
      $db: The database connection.
      $title: The title of the category.
      $question: The question of the category.
      $image: The image of the category.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function category_add($db, $title, $question, $image)
{
  $slug = str_replace(" ", "-", $title);
  $slug = strtolower($slug);
  $stmt = $db->prepare("INSERT INTO category (title, question, slug, image) VALUES (:title, :question, :slug, :image)");
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":question", $question);
  $stmt->bindParam(":slug", $slug);
  $stmt->bindParam(":image", $image);
  $stmt->execute();

  // Close popup
  echo '<script>window.close();</script>';
}

/*
  # name: category_remove
  # description: 
      This function will remove a category.
  # parameters:
      $db: The database connection.
      $id: The id of the category.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function category_remove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM category WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/*
  # name: category_edit
  # description: 
      This function will update a category.
  # parameters:
      $db: The database connection.
      $id: The id of the category.
      $title: The title of the category.
      $question: The question of the category.
      $image: The image of the category.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function category_edit($db, $id, $title, $question, $image)
{
  $slug = str_replace(" ", "-", $title);
  $slug = strtolower($slug);
  $stmt = $db->prepare("UPDATE category SET title = :title, question = :question, slug = :slug, image = :image WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":question", $question);
  $stmt->bindParam(":slug", $slug);
  $stmt->bindParam(":image", $image);
  $stmt->execute();

  // Close popup
  echo '<script>window.close();</script>';
}

/*
  # name: subcategories
  # description: 
      This function will return all subcategories.
  # parameters:
      $db: The database connection.
      optional $category_id: The id of the category.
  # returns:
      An array of subcategories.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function subcategories($db, $category_id = "null")
{
  if ($category_id == "null") $stmt = $db->prepare("SELECT * FROM subcategory");
  else $stmt = $db->prepare("SELECT * FROM subcategory WHERE category = $category_id");
  $stmt->execute();
  $subcategories = $stmt->fetchAll();

  return $subcategories;
}

/*
  # name: subcategory
  # description: 
      This function will return a subcategory.
  # parameters:
      $db: The database connection.
      $id: The id of the subcategory.
  # returns:
      A subcategory.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function subcategory($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM subcategory WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $subcategory = $stmt->fetch();

  return $subcategory;
}

/*
  # name: subcategory_add
  # description: 
      This function will add a subcategory.
  # parameters:
      $db: The database connection.
      $title: The title of the subcategory.
      $category_id: The question of the subcategory.
      $description: The description of the subcategory.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function subcategory_add($db, $title, $category_id, $description)
{
  $slug = str_replace(" ", "-", $title);
  $slug = strtolower($slug);
  $stmt = $db->prepare("INSERT INTO subcategory (title, category, slug, description) VALUES (:title, :category_id, :slug, :description)");
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":category_id", $category_id);
  $stmt->bindParam(":slug", $slug);
  $stmt->bindParam(":description", $description);
  $stmt->execute();

  // Close popup
  echo '<script>window.close();</script>';
}

/*
  # name: subcategory_remove
  # description: 
      This function will remove a subcategory.
  # parameters:
      $db: The database connection.
      $id: The id of the subcategory.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function subcategory_remove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM subcategory WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/*
  # name: subcategory_edit
  # description: 
      This function will update a subcategory.
  # parameters:
      $db: The database connection.
      $id: The id of the subcategory.
      $title: The title of the subcategory.
      $category_id: The question of the subcategory.
      $description: The description of the subcategory.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function subcategory_edit($db, $id, $title, $category_id, $description)
{
  $slug = str_replace(" ", "-", $title);
  $slug = strtolower($slug);
  $stmt = $db->prepare("UPDATE subcategory SET title = :title, category = :category_id, slug = :slug, description = :description WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":category_id", $category_id);
  $stmt->bindParam(":slug", $slug);
  $stmt->bindParam(":description", $description);
  $stmt->execute();

  // Close popup
  echo '<script>window.close();</script>';
}


/*
  # name: tips
  # description: 
      This function will return all tips. 
  # parameters:
      $db: The database connection.
      optional $subcategory_id: The id of the subcategory.
  # returns:
      An array of tips.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function tips($db, $subcategory_id = "null")
{
  if ($subcategory_id == "null") $stmt = $db->prepare("SELECT * FROM tips");
  else $stmt = $db->prepare("SELECT * FROM tips WHERE subcategory = $subcategory_id");
  $stmt->execute();
  $tips = $stmt->fetchAll();

  return $tips;
}

/*
  # name: tip
  # description: 
      This function will return a tip.
  # parameters:
      $db: The database connection.
      $id: The id of the tip.
  # returns:
      A tip.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function tip($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM tips WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $tip = $stmt->fetch();

  return $tip;
}

/*
  # name: tip_add
  # description: 
      This function will add a tip.
  # parameters:
      $db: The database connection.
      $title: The title of the tip.
      $subcategory_id: The subcategory of the tip.
      $content: The content of the tip.
      $imgage: The image of the tip.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function tip_add($db, $subcategory_id, $content, $image)
{
  $stmt = $db->prepare("INSERT INTO tips (subcategory, content, image) VALUES (:subcategory_id, :content, :image)");
  $stmt->bindParam(":subcategory_id", $subcategory_id);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":image", $image);
  $stmt->execute();

  // Close popup
  echo '<script>window.close();</script>';
}

/*
  # name: tip_remove
  # description: 
      This function will remove a tip.
  # parameters:
      $db: The database connection.
      $id: The id of the tip.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function tip_remove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM tips WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/*
  # name: tip_edit
  # description: 
      This function will update a tip.
  # parameters:
      $db: The database connection.
      $id: The id of the tip.
      $title: The title of the tip.
      $subcategory_id: The subcategory of the tip.
      $content: The content of the tip.
      $imgage: The image of the tip.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function tip_edit($db, $id, $subcategory_id, $content)
{
  $stmt = $db->prepare("UPDATE tips SET subcategory = :subcategory_id, content = :content WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":subcategory_id", $subcategory_id);
  $stmt->bindParam(":content", $content);
  $stmt->execute();

  // Close popup
  echo '<script>window.close();</script>';
}

/*
  # name: articles
  # description: 
      This function will return all articles.
  # parameters:
      $db: The database connection.
  # returns:
      An array of articles.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function articles($db)
{
  $stmt = $db->prepare("SELECT * FROM articles");
  $stmt->execute();
  $articles = $stmt->fetchAll();

  return $articles;
}

/*
  # name: article_get
  # description: 
      This function will return an article.
  # parameters:
      $db: The database connection.
      $slug: The slug of the article.
  # returns:
      An article.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function article_get($db, $slug)
{
  $stmt = $db->prepare("SELECT * FROM articles WHERE slug = :slug");
  $stmt->bindParam(":slug", $slug);
  $stmt->execute();
  $article = $stmt->fetch();

  return $article;
}

/* 
  # name: article_new
  # description: 
      This function will create a new article.
  # parameters:
      $db: The database connection.
      $title: The title of the article.
      $slug: The slug of the article.
      $description: The description of the article.
      $content: The content of the article.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function article_new($db, $title, $slug, $description, $content)
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

/*
  # name: article_edit
  # description: 
      This function will edit an article.
  # parameters:
      $db: The database connection.
      $id: The id of the article.
      $title: The title of the article.
      $slug: The slug of the article.
      $description: The description of the article.
      $content: The content of the article.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function article_edit($db, $id, $title, $slug, $description, $content)
{
  $stmt = $db->prepare("UPDATE articles SET title = :title, slug = :slug, description = :description, content = :content WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":slug", $slug);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":content", $content);
  $stmt->execute();

  // Close the popup
  echo "<script>window.close();</script>";
}

/*
  # name: article_remove
  # description: 
      This function will delete an article.
  # parameters:
      $db: The database connection.
      $id: The id of the article.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function article_remove($db, $id)
{
  $stmt = $db->prepare("DELETE FROM articles WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/*
  # name: results
  # description: 
      This function will return all results for a specific user.
  # parameters:
      $db: The database connection.
      $user_id: The id of the user.
  # returns:
      An array of results.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function results($db, $user_id)
{
  $stmt = $db->prepare("SELECT * FROM results WHERE user_id = :user_id");
  $stmt->bindParam(":user_id", $user_id);
  $stmt->execute();
  $results = $stmt->fetchAll();

  return $results;
}

/*
  # name: result_save
  # description: 
      This function will save a result.
  # parameters:
      $db: The database connection.
      $user_id: The id of the user.
      $result: The result.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function result_save($db, $user_id, $result)
{
  $stmt = $db->prepare("INSERT INTO results (user_id, results) VALUES (:user_id, :result)");
  $stmt->bindParam(":user_id", $user_id);
  $stmt->bindParam(":result", $result);
  $stmt->execute();

  // Close the popup
  echo "<script>window.close();</script>";
}

/*
  # name: result_get
  # description: 
      This function will return a result.
  # parameters:
      $db: The database connection.
      $id: The id of the result.
  # returns:
      A result.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function result_get($db, $id)
{
  $stmt = $db->prepare("SELECT * FROM results WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $result = $stmt->fetch();

  // Update result watched status
  $now = date("Y-m-d H:i:s");

  $stmt = $db->prepare("UPDATE results SET watched_at = :now WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":now", $now);
  $stmt->execute();

  return $result;
}

/*
  # name: settings 
  # description: 
      This function will return all settings.
  # parameters:
      $db: The database connection.
  # returns:
      An array of settings.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function settings($db)
{
  $stmt = $db->prepare("SELECT * FROM settings LIMIT 1");
  $stmt->execute();
  $settings = $stmt->fetch();

  return $settings;
}

/*
  # name: settings_update
  # description: 
      This function will update a setting.
  # parameters:
      $db: The database connection.
      $name: The name of the setting.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function settings_update($db, $name)
{
  $stmt = $db->prepare("UPDATE settings SET name = :name");
  $stmt->bindParam(":name", $name);
  $stmt->execute();
}

/*
  # name: settings_update_logo
  # description: 
      This function will update the logo.
  # parameters:
      $db: The database connection.
      $logo: The logo.
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function settings_update_logo($db, $logo)
{
  $stmt = $db->prepare("UPDATE settings SET logo = :logo");
  $stmt->bindParam(":logo", $logo);
  $stmt->execute();
}

/* 
  # name: homepage_update
  # description: 
      This function will update the homepage.
  # parameters:
      $db: The database connection.
      $home_title: The title of the homepage.
      $home_subtitle: The subtitle of the homepage.
      $home_howitworks_one_title: The title of the first how it works section.
      $home_howitworks_one_subtitle: The subtitle of the first how it works section.
      $home_howitworks_two_title: The title of the second how it works section.
      $home_howitworks_two_subtitle: The subtitle of the second how it works section.
      $home_howitworks_three_title: The title of the third how it works section.
      $home_howitworks_three_subtitle: The subtitle of the third how it works section.
      $home_extra_website: The extra websites
      $home_extra_bronnen: The extra bronnen
      $home_extra_credits: The extra credits
  # returns:
      None
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function homepage_update($db, $home_title, $home_subtitle, $home_howitworks_one_title, $home_howitworks_one_subtitle, $home_howitworks_two_title, $home_howitworks_two_subtitle, $home_howitworks_three_title, $home_howitworks_three_subtitle, $home_extra_websites, $home_extra_bronnen, $home_extra_credits)
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

/*
  # name: texts 
  # description: 
      This function will return all text that can be found on the homepage.
  # parameters:
      $db: The database connection.
  # returns:
      An array of texts.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function texts($db)
{
  $stmt = $db->prepare("SELECT * FROM tekst LIMIT 1");
  $stmt->execute();
  $texts = $stmt->fetch();

  return $texts;
}

/* 
  # name: images
  # description: 
      This function will return all images.
  # parameters:
      none
  # returns:
      An array of images.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function images()
{
  $json = $_SERVER['DOCUMENT_ROOT'] . "/assets/json/poses.json";
  $json = file_get_contents($json);
  $json = json_decode($json, true);

  return $json;
}

/* 
  # name: image
  # description: 
      This function will return an image.
  # parameters:
      $id: The id of the image.
  # returns:
      An image.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
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

/*
  # name: string_random
  # description: 
      This function will return a random string.
  # parameters:
      optional: $length: The length of the string.
  # returns:
      A random string.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function string_random($length = 25)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:<>,.?/';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

/*
  # name: string_encrypt
  # description: 
      This function will encrypt a string.
  # parameters:
      $string: The string that needs to be encrypted.
  # returns:
      The encrypted string.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
function string_encrypt($string, $salt = 0)
{
  if ($salt == 0) return array(
    "string" => $string,
    "salt" => 0
  );
  else {
    $salt = string_random(25);
    return array(
      "string" => hash("sha256", $string . $salt),
      "salt" => $salt
    );
  }
}

/*
  # name: format
  # description: 
      This function will format a timestamp to a readable date.
  # parameters:
      $timestamp: The timestamp that needs to be formatted.
  # returns:
      A formatted timestamp.
  # author: MatseVH
  # modified: 06-25-2022 <MM-DD-YYYY>
*/
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

/*
  # name: stats
  # description: 
      This function will return the stats of the website.
  # parameters:
      $db: The database connection.
  # returns:
      An array of stats.
  # author: MatseVH
  # modified: 06-26-2022 <MM-DD-YYYY>
*/
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

  // Count all subcategories
  $stmt = $db->prepare("SELECT COUNT(*) FROM subcategory");
  $stmt->execute();
  $arr["subcategories"] = $stmt->fetchColumn();

  // Count all tips
  $stmt = $db->prepare("SELECT COUNT(*) FROM tips");
  $stmt->execute();
  $arr["tips"] = $stmt->fetchColumn();

  // Count all users
  $stmt = $db->prepare("SELECT COUNT(*) FROM users");
  $stmt->execute();
  $arr["users"] = $stmt->fetchColumn();

  // Count all bronnen
  $stmt = $db->prepare("SELECT COUNT(*) FROM bronnen");
  $stmt->execute();
  $arr["bronnen"] = $stmt->fetchColumn();

  // Count all websites
  $stmt = $db->prepare("SELECT COUNT(*) FROM websites");
  $stmt->execute();
  $arr["websites"] = $stmt->fetchColumn();

  // Count all credits
  $stmt = $db->prepare("SELECT COUNT(*) FROM credits");
  $stmt->execute();
  $arr["credits"] = $stmt->fetchColumn();

  // Return the array
  return $arr;
}

/*
  # name: email_send
  # description: 
      This function will send an email.
  # parameters:
      $to: The email address of the recipient.
      $to_name: The name of the recipient.
      $subject: The subject of the email.
      $title: The title of the email.
      $content: The content of the email.
      $button_text: The text of the button.
      $button_link: The link of the button.
  # returns:
      A boolean.
  # author: MatseVH
  # modified: 06-26-2022 <MM-DD-YYYY>
*/
function email_send($db, $to, $to_name, $subject, $title, $content, $button_text, $button_link)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
    include $_SERVER["DOCUMENT_ROOT"] . "/includes/config.dist.php";

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->CharSet = "utf-8";                                      //Send using SMTP
    $mail->Host       = $smtp_host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtp_user;                     //SMTP username
    $mail->Password   = $smtp_pass;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("noreply@m-vh.eu", settings($db)["name"]);
    $mail->addAddress($to, $to_name);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;

    // Include HTML file as $mail->Body 
    $template = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/includes/emails/template.php");
    // Replace the placeholders with the actual data
    $template = str_replace("{url}", $_SERVER["HTTP_HOST"], $template);
    $template = str_replace("{title}", $title, $template);
    $template = str_replace("{content}", $content, $template);
    $template = str_replace("{button_text}", $button_text, $template);
    $template = str_replace("{button_link}", $button_link, $template);

    // Set the message body to the HTML message template we just loaded
    $mail->Body = $template;
    $mail->AltBody = strip_tags($content);

    // Send the message
    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

/*
  # name: files
  # description: 
      This function will return the extra files of the website.
  # parameters:
      $db: The database connection.
  # returns:
      An array of files.
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function files($db)
{
  // Create array
  $arr = array();

  // Get all files
  $stmt = $db->prepare("SELECT * FROM files");
  $stmt->execute();
  $arr = $stmt->fetchAll();

  // Return the array
  return $arr;
}

/*
  # name: file_upload
  # description: 
      This function will upload a file.
  # parameters:
      $db: The database connection.
      $file: The file to upload.
  # returns:
      A file name.
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function file_upload($db, $file)
{
  $filename = explode(".", $file["name"]);
  $tempname = $file["tmp_name"];
  $folder = $_SERVER["DOCUMENT_ROOT"] . "/assets/uploads/";
  $newfilename = round(microtime(true)) . '.' . end($filename);

  if (move_uploaded_file($file["tmp_name"], $folder . $newfilename))
    return $newfilename;
}

/*
  # name: file_to_database
  # description: 
      This function will upload a file to the database.
  # parameters:
      $db: The database connection.
      $title: The title of the file.
      $note: The note of the file.
      $file: The file to upload.
  # returns:
      None
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function file_to_database($db, $title, $note, $file)
{
  // Upload the file
  $filename = file_upload($db, $file);
  // Insert the file into the database
  $stmt = $db->prepare("INSERT INTO files (title, note, file) VALUES (:title, :note, :file)");
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":note", $note);
  $stmt->bindParam(":file", $filename);
  $stmt->execute();
}

/*
  # name: file_delete
  # description: 
      This function will delete a file.
  # parameters:
      $db: The database connection.
      $id: The id of the file to delete.
  # returns:
      None
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function file_delete($db, $id)
{
  // Get the file
  $stmt = $db->prepare("SELECT * FROM files WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $file = $stmt->fetch();
  // Delete the file
  unlink($_SERVER["DOCUMENT_ROOT"] . "/assets/uploads/" . $file["file"]);
  // Delete the file from the database
  $stmt = $db->prepare("DELETE FROM files WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
}

/*
  # name: file_download
  # description: 
      This function will download a file.
  # parameters:
      $db: The database connection.
      $id: The id of the file to download.
  # returns:
      None
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function file_download($db, $id)
{
  // Get the file
  $stmt = $db->prepare("SELECT * FROM files WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $file = $stmt->fetch();
  if ($file) {
    // Download the file
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $file["file"]);
    readfile($_SERVER["DOCUMENT_ROOT"] . "/assets/uploads/" . $file["file"]);
    return true;
  } else return false;
}

/*
  # name: file_download_link
  # description: 
      This function will return a download link for a file.
  # parameters:
      $db: The database connection.
      $id: The id of the file to download.
  # returns:
      A download link.
  # author: MatseVH
  # modified: 06-27-2022 <MM-DD-YYYY>
*/
function file_download_link($db, $id)
{
  // Get the file
  $stmt = $db->prepare("SELECT * FROM files WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $file = $stmt->fetch();
  // Return the download link
  return $_SERVER["HTTP_HOST"] . "/download/" . $id;
}
