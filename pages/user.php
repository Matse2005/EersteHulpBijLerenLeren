<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";

if (isset($_POST["name"])) updateUser($db, $_POST["firstname"], $_POST["lastname"]);
else if (isset($_POST["password"])) updatePassword($db, $_POST["current"], $_POST["password"], $_POST["password_confirmation"]);
?>

<?php if (isset($_SESSION["error"]["code"]) === "PASSWORD") { ?>
  <div id="password_incorrect" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
      </svg>
    </div>
    <div class="ml-3 text-sm font-normal"><?php print $_SESSION["error"]["message"] ?></div>
    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#password_incorrect" aria-label="Close">
      <span class="sr-only">Sluiten</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>
    </button>
  </div>
<?php
  unset($_SESSION["error"]);
}
?>

<!-- Hero -->
<div class="overflow-hidden bg-secondary pt-20">
  <div class="px-4 sm:px-6 md:px-8">
    <div class="max-w-5xl mx-auto pb-28">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="rounded-lg h-full w-full">
          <form method="post" class="w-full">
            <!-- Firstname -->
            <div class="flex flex-col p-4 w-full">
              <label for="firstname" class="text-sm font-medium leading-5 text-gray-700">
                Voornaam
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input id="firstname" name="firstname" required value="<?php print $_SESSION["user"]["firstname"] ?>" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" />
              </div>
            </div>
            <!-- Lastname -->
            <div class="flex flex-col p-4 w-full">
              <label for="lastname" class="text-sm font-medium leading-5 text-gray-700">
                Achternaam
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input id="lastname" name="lastname" required value="<?php print $_SESSION["user"]["lastname"] ?>" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" />
              </div>
            </div>
            <!-- Email -->
            <div class="flex flex-col  p-4 w-full">
              <label for="email" class="text-sm font-medium leading-5 text-gray-700">
                E-mail
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input id="email" disabled name="email" required value="<?php print $_SESSION["user"]["email"] ?>" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" />
              </div>
            </div>
            <!-- Submit button -->
            <div class="flex flex-col p-4 w-full">
              <button type="submit" name="name" class="w-full flex justify-center py-2 px-4 border border-black text-sm leading-5 font-medium rounded-md text-white bg-black hover:bg-gray-500 focus:outline-none transition duration-150 ease-in-out">
                Opslaan
              </button>
            </div>
          </form>
        </div>
        <div class="rounded-lg h-full w-full">
          <form method="post" id="passwordEdit" class="w-full">
            <!-- Error message -->
            <?php if (isset($_SESSION["error"]["code"]) && $_SESSION["error"]["code"] === "PASSWORD") { ?>
              <p class="text-sm text-red-500"><?php print $_SESSION["error"]["message"] ?></p>
            <?php
              unset($_SESSION["error"]);
            } ?>
            <!-- Huidig Wachtwoord -->
            <div class="flex flex-col p-4 w-full">
              <label for="password" class="text-sm font-medium leading-5 text-gray-700">
                Huidig Wachtwoord
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input id="current" name="current" required type="password" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" />
              </div>
            </div>
            <!-- Nieuw Wachtwoord -->
            <div class="flex flex-col p-4 w-full">
              <label for="password" class="text-sm font-medium leading-5 text-gray-700">
                Nieuw Wachtwoord
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input id="password" name="password" required type="password" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" />
              </div>
            </div>
            <!-- Wachtwoord bevestigen -->
            <div class="flex flex-col p-4 w-full">
              <label for="password_confirmation" class="text-sm font-medium leading-5 text-gray-700">
                Nieuw Wachtwoord bevestigen
              </label>
              <div class="mt-1 rounded-md shadow-sm">
                <input id="password_confirmation" required name="password_confirmation" type="password" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" />
              </div>
            </div>
            <div class="flex flex-col p-4 w-full">
              <button type="submit" class="w-full flex justify-center py-2 px-4 border border-black text-sm leading-5 font-medium rounded-md text-white bg-black hover:bg-gray-500 focus:outline-none transition duration-150 ease-in-out">
                Opslaan
              </button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>