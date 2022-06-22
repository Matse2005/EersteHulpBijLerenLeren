<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_navigation.dashboard.php'; ?>
  <main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto ">
      <div class="grid md:grid-cols-2">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Categorieën
        </h2>
        <div class="md:my-6 w-full flex md:justify-end">
          <button onclick="window.open('/pages/dashboard/tips/create/categorie.php','name','width=800,height=800')" class="px-4 py-2 text-md bg-black text-white font-semibold rounded">
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
                <th class="px-4 py-3">Actions</th>
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
                      <button @click="openModal('#edit<?php print $category["id"] ?>')" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                      </button>
                      <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>

                <!-- Modal backdrop. This what you want to place close to the closing body tag -->
                <div id="edit<?php print $category["id"] ?>" x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
                  <!-- Modal -->
                  <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal">
                    <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                    <header class="flex justify-end">
                      <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
                        <i class="fa-solid fa-times text-2xl"></i>
                      </button>
                    </header>
                    <form action="" method="post">
                      <!-- Modal body -->
                      <div class="mb-6">
                        <!-- Modal title -->
                        <p class="mb-2 text-lg font-semibold">
                          Maak een nieuwe categorie aan
                        </p>
                        <!-- Modal form -->
                        <div class="w-full mb-2">
                          <label for="title" class="block text-sm font-medium leading-5 text-gray-700">
                            Titel
                          </label>
                          <div class="mt-1 relative rounded-md shadow-sm">
                            <input value="edit<?php print $category["title"] ?>" id="title" name="title" class="form-input block w-full leading-5 text-black border-b focus:outline-0 focus-visible:outline-0 border-black transition-colors duration-150 px-4 py-2 rounded ease-in-out sm:text-sm sm:leading-5" required />
                          </div>
                        </div>
                        <div class="w-full mb-2">
                          <label for="slug" class="block text-sm font-medium leading-5 text-gray-700">
                            Slug
                          </label>
                          <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="slug" name="slug" class="form-input block w-full ease-in-out leading-5 text-black border-b border-black transition-colors duration-150 px-4 py-2 rounded" required />
                          </div>
                        </div>
                        <div class="w-full mb-2">
                          <label for="question" class="block text-sm font-medium leading-5 text-gray-700">
                            Vraag
                          </label>
                          <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="question" name="question" class="form-input block w-full ease-in-out leading-5 text-black border-b border-black transition-colors duration-150 px-4 py-2 rounded" required />
                          </div>
                        </div>
                        <div class="w-full mb-2">
                          <label for="image" class="block text-sm font-medium leading-5 text-gray-700">
                            Afbeelding
                          </label>
                          <div class="mt-1 relative rounded-md shadow-sm">
                            <!-- Select with all poses from /assets/json/poses.json -->
                            <select id="image" name="image" class="form-select block w-full ease-in-out leading-5 bg-white text-black border-b border-black transition-colors duration-150 px-4 py-2 rounded">
                              <?php
                              foreach (images() as $image) {
                              ?>
                                <option value="<?php echo $image["name"]; ?>"><?php echo $image["name"]; ?></option>
                              <?php
                              }
                              ?>
                          </div>
                        </div>
                        <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 mb-3 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                          <!-- <button @click="closeModal" class="w-full text-sm font-medium leading-5 text-black border-2 border-black transition-colors duration-150 px-4 py-2 rounded">
              Verlaten
            </button> -->
                          <button class="w-full text-sm font-medium leading-5 text-white bg-black transition-colors duration-150 rounded px-4 py-2 ">
                            Aanmaken
                          </button>
                        </footer>
                    </form>
                  </div>
                </div>
                <!-- End of modal backdrop -->

              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
    <div id="new" x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
      <!-- Modal -->
      <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal" @keydown.escape="closeModal" class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog" id="modal">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
          <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
            <i class="fa-solid fa-times text-2xl"></i>
          </button>
        </header>
        <form action="" method="post">
          <!-- Modal body -->
          <div class="mb-6">
            <!-- Modal title -->
            <p class="mb-2 text-lg font-semibold">
              Maak een nieuwe categorie aan
            </p>
            <!-- Modal form -->
            <div class="w-full mb-2">
              <label for="title" class="block text-sm font-medium leading-5 text-gray-700">
                Titel
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input id="title" name="title" class="form-input block w-full leading-5 text-black border-b focus:outline-0 focus-visible:outline-0 border-black transition-colors duration-150 px-4 py-2 rounded ease-in-out sm:text-sm sm:leading-5" required />
              </div>
            </div>
            <div class="w-full mb-2">
              <label for="slug" class="block text-sm font-medium leading-5 text-gray-700">
                Slug
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input id="slug" name="slug" class="form-input block w-full ease-in-out leading-5 text-black border-b border-black transition-colors duration-150 px-4 py-2 rounded" required />
              </div>
            </div>
            <div class="w-full mb-2">
              <label for="question" class="block text-sm font-medium leading-5 text-gray-700">
                Vraag
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input id="question" name="question" class="form-input block w-full ease-in-out leading-5 text-black border-b border-black transition-colors duration-150 px-4 py-2 rounded" required />
              </div>
            </div>
            <div class="w-full mb-2">
              <label for="image" class="block text-sm font-medium leading-5 text-gray-700">
                Afbeelding
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <!-- Select with all poses from /assets/json/poses.json -->
                <select id="image" name="image" class="form-select block w-full ease-in-out leading-5 bg-white text-black border-b border-black transition-colors duration-150 px-4 py-2 rounded">
                  <?php
                  foreach (images() as $image) {
                  ?>
                    <option value="<?php echo $image["name"]; ?>"><?php echo $image["name"]; ?></option>
                  <?php
                  }
                  ?>
              </div>
            </div>
            <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 mb-3 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
              <!-- <button @click="closeModal" class="w-full text-sm font-medium leading-5 text-black border-2 border-black transition-colors duration-150 px-4 py-2 rounded">
              Verlaten
            </button> -->
              <button class="w-full text-sm font-medium leading-5 text-white bg-black transition-colors duration-150 rounded px-4 py-2 ">
                Aanmaken
              </button>
            </footer>
        </form>
      </div>
    </div>
    <!-- End of modal backdrop -->

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.dashboard.php'; ?>

    <script>
      $(document).ready(function() {
        $('#table').DataTable({
          // Disable pagination
          "paging": false,
          // Disable sorting
          "ordering": false,
          // Disable searching
          "searching": false,
          // Disable info
          "info": false,
          // Disable length change
          "lengthChange": false,
          // Disable scrollX
          "scrollX": false,
        });
      });
    </script>