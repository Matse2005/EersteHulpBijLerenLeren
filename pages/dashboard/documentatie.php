<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php';
?>

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_navigation.dashboard.php'; ?>
  <main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Hulp nodig?
      </h2>
      <!-- Cards -->
      <div class="grid gap-6 mb-8 lg:grid-cols-2">
        <!-- Tip aanmaken -->
        <div class="w-full">
          <iframe src="https://scribehow.com/embed/Eerste_Hulp_Bij_Leren_Leren__Maak_een_nieuwe_tip_aan__Nn187RzwQyqHFuwPyDouPQ" width="100%" height="640" allowfullscreen frameborder="0"></iframe>
        </div>
        <!-- Account aanmaken -->
        <iframe src="https://scribehow.com/embed/Account_aanmaken__1dgtLZivTsGfRn5AH0B7ug" width="100%" height="640" allowfullscreen frameborder="0"></iframe>
      </div>
    </div>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.dashboard.php'; ?>