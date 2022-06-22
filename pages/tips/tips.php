<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";
?>

<!-- Hero -->
<section class="w-full bg-secondary py-24 md:mt-0">
  <div class="max-w-screen-xl h-full mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php
    foreach (categories($db) as $category) {
    ?>
      <button onclick="window.open('/pages/tips/category.php?id=<?php print $category['id'] ?>','name','width=800,height=800')" class="flex flex-col items-center bg-secondary shadow-lg rounded-lg md:flex-row md:max-w-xl p-1">
        <object class="object-cover w-full h-96 rounded-t-lg md:h-auto md:w-48 md:rounded-none md:rounded-l-lg" data="/assets/img/<?php print image($category["image"])["image"] ?>"></object>
        <div class="flex flex-col justify-between p-4 leading-normal">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900"><?php print $category["title"] ?></h5>
          <!-- <p class="mb-3 font-normal text-gray-700"><?php print $category["description"] ?></p> -->
        </div>
      </button>
    <?php
    }
    ?>
  </div>
</section>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>