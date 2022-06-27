<!-- Desktop sidebar -->
<aside class="z-1 hidden w-64 overflow-y-auto bg-secondary dark:bg-gray-800 md:block flex-shrink-0">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <div class="flex items-center px-6 py-3">
      <?php
      if (str_ends_with(settings($db)["logo"], ".svg")) {
        print '<object data="/assets/img/uploads/' . settings($db)["logo"] . '" alt="' . settings($db)["name"] . '" class="h-12"></object>';
      } else {
        print '<img class="h-12" src="/assets/img/uploads/' . settings($db)["logo"] . '" alt="' . settings($db)["name"] . '" />';
      }
      ?>
    </div>
    <ul class="mt-6">
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/pages/dashboard/settings/instellingen/index.php">
          <i class="fa-regular fa-gear text-lg"></i>
          <span class="ml-4">Instellingen</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/dashboard/documentatie">
          <i class="fa-regular fa-circle-question text-lg"></i>
          <span class="ml-4">Hulp nodig?</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" @click="togglePagesMenu" aria-haspopup="true">
          <span class="inline-flex items-center">
            <i class="fa-regular fa-users text-lg"></i>
            <span class="ml-4">Gebruikers</span>
          </span>
          <i class="fa-solid fa-chevron-down font-lg"></i>
        </button>
        <template x-if="isPagesMenuOpen">
          <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/settings/instellingen/users/accounts.php">Accounts</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/settings/instellingen/users/admins.php">
                Beheerders
              </a>
            </li>
          </ul>
        </template>
      </li>
      <li class="relative px-6 py-3">
        <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" @click="togglePagesMenu" aria-haspopup="true">
          <span class="inline-flex items-center">
            <i class="fa-regular fa-lightbulb text-lg"></i>
            <span class="ml-4">Tips</span>
          </span>
          <i class="fa-solid fa-chevron-down font-lg"></i>
        </button>
        <template x-if="isPagesMenuOpen">
          <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/tips/categorieen.php">Categorieën</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/tips/subcategorieen.php">
                Subcategorieën
              </a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/tips/tips.php">
                Tips
              </a>
            </li>
          </ul>
        </template>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/pages/dashboard/articles/index.php">
          <i class="fa-regular fa-input-text text-lg"></i>
          <span class="ml-4">Artikels</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/pages/dashboard/settings/thuispagina/bewerk.php">
          <i class="fa-regular fa-home text-lg"></i>
          <span class="ml-4">Startpagina</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/pages/dashboard/settings/instellingen/files.php">
          <i class="fa-regular fa-file text-lg"></i>
          <span class="ml-4">Bestanden</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/pages/dashboard/settings/instellingen/bronnen.php">
          <i class="fa-regular fa-chart-bar text-lg"></i>
          <span class="ml-4">Bronnen</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/pages/dashboard/settings/instellingen/websites.php">
          <i class="fa-regular fa-browser text-lg"></i>
          <span class="ml-4">Handige websites</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="/pages/dashboard/settings/instellingen/credits.php">
          <i class="fa-regular fa-memo-circle-info text-lg"></i>
          <span class="ml-4">Credits</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
<!-- Mobile sidebar -->
<!-- Backdrop -->
<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-secondary dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <div class="flex items-center px-6 py-3">
      <object data='/assets/img/logo.svg' alt="Logo" class="h-8"></object>
    </div>
    <ul class="mt-6">
      <li class="relative px-6 py-3 font-semibold">Dashboard</li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/dashboard/documentatie">
          <i class="fa-regular fa-circle-question text-lg"></i>
          <span class="ml-4">Hulp nodig?</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/pages/dashboard/settings/instellingen/index.php">
          <i class="fa-regular fa-gear text-lg"></i>
          <span class="ml-4">Instellingen</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <div class="flex">
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
          <button class="inline-flex items-center w-full text-sm font-source-code-pro" @click="togglePagesMenu" aria-haspopup="true">
            <i class="fa-regular fa-users text-lg"></i>
            <span class="ml-4">Gebruikers</span>
          </button>
          <i class="fa-solid fa-chevron-down font-lg"></i>
        </div>
        <template x-if="isPagesMenuOpen">
          <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/settings/instellingen/users/accounts.php">Accounts</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/settings/instellingen/users/admins.php">
                Beheerders
              </a>
            </li>
          </ul>
        </template>
      </li>
      <li class="relative px-6 py-3">
        <div class="flex">
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
          <button class="inline-flex items-center w-full text-sm font-source-code-pro" @click="togglePagesMenu" aria-haspopup="true">
            <i class="fa-regular fa-lightbulb text-lg"></i>
            <span class="ml-4">Tips</span>
          </button>
          <i class="fa-solid fa-chevron-down font-lg"></i>
        </div>
        <template x-if="isPagesMenuOpen">
          <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/tips/categorieen.php">Categroieën</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/tips/subcategorieen.php">
                Subcategorieën
              </a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="/pages/dashboard/tips/tips.php">
                Tips
              </a>
            </li>
          </ul>
        </template>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/pages/dashboard/articles/index.php">
          <i class="fa-regular fa-newspaper text-lg"></i>
          <span class="ml-4">Artikels</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/pages/dashboard/settings/thuispagina/bewerk.php">
          <i class="fa-regular fa-home text-lg"></i>
          <span class="ml-4">Startpagina</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/pages/dashboard/settings/instellingen/files.php">
          <i class="fa-regular fa-file text-lg"></i>
          <span class="ml-4">Bestanden</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/pages/dashboard/settings/instellingen/bronnen.php">
          <i class="fa-regular fa-chart-bar text-lg"></i>
          <span class="ml-4">Bronnen</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/pages/dashboard/settings/instellingen/websites.php">
          <i class="fa-regular fa-browser text-lg"></i>
          <span class="ml-4">Handige websites</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/pages/dashboard/settings/instellingen/credits.php">
          <i class="fa-regular fa-memo-circle-info text-lg"></i>
          <span class="ml-4">Credits</span>
        </a>
      </li>
      <li class="relative px-6 py-3 font-semibold">Website</li>
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/">
          <i class="fa-regular fa-home text-lg"></i>
          <span class="ml-4">Start</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/tips">
          <i class="fa-regular fa-lightbulb text-lg"></i>
          <span class="ml-4">Tips</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/artikels">
          <i class="fa-regular fa-newspaper text-lg"></i>
          <span class="ml-4">Artikels</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/hulp">
          <i class="fa-regular fa-square-poll-vertical text-lg"></i>
          <span class="ml-4">Mijn Hulp</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        <a class="inline-flex items-center w-full text-sm font-source-code-pro" href="/profiel">
          <i class="fa-regular fa-user text-lg"></i>
          <span class="ml-4">Profiel</span>
        </a>
      </li>
    </ul>
    <div class="px-6 my-6">
      <a href="/loguit" class="items-center font-source-code-pro py-2 px-4 text-white bg-black rounded-3xl">
        Log uit
      </a>
    </div>
  </div>
</aside>
<div class="flex flex-col flex-1 w-full">
  <header class="z-10 py-4 bg-secondary dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
      <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="toggleSideMenu" aria-label="Menu">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
        </svg>
      </button>
      <div class="hidden md:flex justify-center flex-1 lg:mr-32">
        <ul class="items-center font-source-code-pro flex">
          <li class="mx-3">
            <a class="text-black growing-underline" href="/">
              Start
            </a>
          </li>
          <li class="mx-3">
            <a class="text-black growing-underline" href="/tips">
              Tips
            </a>
          </li>
          <li class="mx-3">
            <a class="text-black growing-underline" href="/artikels">
              Artikels
            </a>
          </li>
          <li class="mx-3">
            <a class="text-black growing-underline" href="/hulp">
              Mijn Hulp
            </a>
          </li>
          <li class="mx-3">
            <a class="text-black growing-underline" href="/profiel">Profiel</a>
          </li>
        </ul>
      </div>
      <ul class="hidden md:flex items-center flex-shrink-0 space-x-6">
        <li class="relative">
          <div class="font-source-code-pro hidden md:block">
            <a href="/pages/auth/signout.php" class="py-2 px-4 text-white bg-black rounded-3xl">
              Log uit
            </a>
          </div>
        </li>
      </ul>
    </div>
  </header>