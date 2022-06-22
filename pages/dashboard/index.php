<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php';
?>

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_navigation.dashboard.php'; ?>
  <main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Dashboard
      </h2>
      <!-- Cards -->
      <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
          <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
            <i class="fa-regular fa-box-archive text-3xl"></i>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              Formulieren ingevuld
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              <?php print stats($db)["results"]; ?>
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
          <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
            <i class="fa-regular fa-file-lines text-3xl"></i>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              Artikels
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              <?php print stats($db)["articles"]; ?>
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
          <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
            <i class="fa-regular fa-layer-group text-3xl"></i>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              Categorieën
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              <?php print stats($db)["categories"]; ?>
            </p>
          </div>
        </div>
        <!-- Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
          <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
            <i class="fa-regular fa-lightbulb text-3xl"></i>
          </div>
          <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
              Tips
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
              <?php print stats($db)["tips"]; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.dashboard.php'; ?>