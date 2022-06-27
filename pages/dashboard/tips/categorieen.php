<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php';
if (isset($_POST["remove"])) {
  category_remove($db, $_POST["remove"]);
}
?>

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_navigation.dashboard.php'; ?>
  <main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto ">
      <div class="grid md:grid-cols-2">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Categorieën
        </h2>
        <div class="md:my-6 w-full flex md:justify-end">
          <button onclick="window.open('/pages/dashboard/tips/create/category.php','name','width=800,height=800')" class="px-4 py-2 text-md bg-black text-white font-semibold rounded">
            <i class="fa-regular fa-plus"></i>
            Nieuwe categorie
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table id="table" class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">Naam</th>
                <!-- <th class="px-4 py-3">Slug</th> -->
                <th class="px-4 py-3">Stelling</th>
                <th class="px-4 py-3">Acties</th>
              </tr>
            </thead>
            <tbody class="dark:divide-gray-700 dark:bg-gray-800">
              <?php
              foreach (categories($db) as $category) {
              ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <!-- Avatar with inset shadow -->
                      <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                        <object class="object-cover w-full h-full rounded-full" data="/assets/img/<?php print image($category["image"])["image"] ?>" type="image/svg+xml">
                          Category image
                        </object>
                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                      </div>
                      <div>
                        <p class="font-semibold"><?php print $category["title"] ?></p>
                      </div>
                    </div>
                  </td>
                  <!-- <td class="px-4 py-3 text-sm">
                    <?php print $category["slug"] ?>
                  </td> -->
                  <td class="px-4 py-3 text-sm">
                    <?php print $category["question"] ?>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button onclick='window.open("/pages/dashboard/tips/edit/category.php?id=<?php print $category["id"] ?>","name","width=800,height=800")' class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                      </button>
                      <form method="post">
                        <input type="hidden" name="remove" value="<?php print $category["id"] ?>">
                        <button type="submit" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                          </svg>
                        </button>
                      </form>
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

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.dashboard.php'; ?>

    <script>
      $(document).ready(function() {
        $('#table').DataTable({
          // Disable pagination
          "paging": false,
          // Disable sorting
          "ordering": true,
          // Disable searching
          "searching": true,
          // Disable info
          "info": false,
          // Disable length change
          "lengthChange": false,
          // Disable scrollX
          "scrollX": false,
        });
      });
    </script>