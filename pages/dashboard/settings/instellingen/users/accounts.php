<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (isset($_POST["create"])) {
  user_create($db, $_POST["firstname"], $_POST["lastname"], $_POST["email"]);
} else if (isset($_POST["remove"])) {
  user_remove($db, $_POST["remove"]);
}
?>

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_navigation.dashboard.php'; ?>
  <main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto ">
      <div class="grid md:grid-cols-2">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Gebruikers
        </h2>
        <div class="md:my-6 w-full flex md:justify-end">
          <button @click="openModal" class="px-4 py-2 text-md bg-black text-white font-semibold rounded">
            <i class="fa-regular fa-plus"></i>
            Nieuwe gebruiker
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table id="table" class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">Naam</th>
                <th class="px-4 py-3">E-mail</th>
                <th class="px-4 py-3"></th>
              </tr>
            </thead>
            <tbody class="dark:divide-gray-700 dark:bg-gray-800">
              <?php
              foreach (users($db) as $user) {
              ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div>
                        <p class="font-source-code-pro font-semibold bg-secondary focus:outline-none focus:border-none focus:ring-0 w-full h-auto"><?php print $user["firstname"] . " " . $user["lastname"] ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-sm">
                    <p class="font-source-code-pro font-semibold bg-secondary focus:outline-none focus:border-none focus:ring-0 w-full h-auto"><?php print $user["email"] ?></p>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm relative">
                      <div class="absolute right-0 flex">
                        <!-- <form action="" method="POST">
                          <button type="submit" name="edit" value="<?php print $user["id"] ?>" class="flex items-center mr-3 text-white bg-black px-4 py-2 justify-between text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                            Bewerken
                          </button>
                        </form> -->
                        <form action="" method="POST">
                          <button onclick='return confirm(" Ben je zeker dat je <?php print $user["firstname"] ?> <?php print $user["lastname"] ?> <<?php print $user["email"] ?>> wilt verwijderen." );' type="submit" name="remove" value="<?php print $user["id"] ?>" class="flex items-center text-white bg-black px-4 py-2 justify-between text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                            Verwijderen
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
      <!-- Modal -->
      <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
          <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
              <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
          </button>
        </header>
        <!-- Modal body -->
        <div class="mt-4 mb-6">
          <!-- Modal title -->
          <p class="mb-2 text-lg font-semibold text-gray-700">
            Creeër een nieuwe gebruiker
          </p>
          <!-- Modal description -->
          <p class="text-sm text-gray-700">
          <form method="post" action="">
            <!-- Form -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-1">
              <div class="">
                <label for="firstname" class="block text-sm font-medium leading-5 text-black">
                  Voornaam
                </label>
                <div class="mt-1 rounded-md shadow-sm">
                  <input id="firstname" name="firstname" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" required />
                </div>
                <div class="">
                  <label for="lastname" class="block text-sm font-medium leading-5 text-black">
                    Achternaam
                  </label>
                  <div class="mt-1 rounded-md shadow-sm">
                    <input id="lastname" name="lastname" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" required />
                  </div>
                </div>
                <div class="">
                  <label for="email" class="block text-sm font-medium leading-5 text-black">
                    E-mail
                  </label>
                  <div class="mt-1 rounded-md shadow-sm">
                    <input id="email" name="email" type="email" onchange="validate()" oninvalid="validate()" class="form-input block w-full transition duration-150 drop-shadow-xl ease-in-out sm:text-sm sm:leading-5 p-2 rounded" required />
                  </div>
                  <small id="emailErr" class="text-red-500 hidden"></small>
                </div>
              </div>
            </div>
            <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row">
              <button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-black transition-colors duration-150 border border-black rounded-lg sm:px-4 sm:py-2 sm:w-auto focus:outline-none focus:shadow-outline-gray">
                Sluiten
              </button>
              <button type="submit" id="create" name="create" disabled class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-black rounded-lg sm:w-auto sm:px-4 sm:py-2 focus:outline-none focus:shadow-outline-purple">
                Aanmaken
              </button>
            </footer>
          </form>
          </p>
        </div>
      </div>
    </div>
    <!-- End of modal backdrop -->

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.dashboard.php'; ?>

    <script>
      function validate() {
        var emails = <?php print json_encode(emails($db)) ?>;
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        var email = document.getElementById("email").value;
        if (email == "") {
          document.getElementById("emailErr").innerHTML = "Vul een e-mailadres in";
          document.getElementById("emailErr").classList.remove("hidden");
          document.getElementById("email").classList.add("invalid");
          document.getElementById("create").disabled = true;
        } else if (!email.match(validRegex)) {
          document.getElementById("emailErr").innerHTML = "Vul een geldig e-mailadres in";
          document.getElementById("emailErr").classList.remove("hidden");
          document.getElementById("email").classList.add("invalid");
          document.getElementById("create").disabled = true;
        } else if (emails.includes(email)) {
          document.getElementById("emailErr").innerHTML = "Dit e-mailadres is al in gebruik";
          document.getElementById("emailErr").classList.remove("hidden");
          document.getElementById("email").classList.add("invalid");
          document.getElementById("create").disabled = true;
        } else {
          document.getElementById("emailErr").classList.add("hidden");
          document.getElementById("email").classList.remove("invalid");
          document.getElementById("create").disabled = false;
        }
      }

      function OnInput() {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
      }

      $(document).ready(function() {
        $('#table').DataTable({
          // Disable pagination
          "paging": false,
          // Disable sorting
          "ordering": false,
          // Disable searching
          "searching": true,
          // Disable info
          "info": false,
          // Disable scrollX
          "scrollX": false,
          // Enable auto width
          "autoWidth": true,
        });
      });
    </script>