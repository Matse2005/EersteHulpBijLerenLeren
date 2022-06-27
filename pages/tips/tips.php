<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";
?>

<div class="px-4 sm:px-6 md:px-8">
  <div class="max-w-5xl mx-auto pb-28">
    <main>
      <div class="relative pt-10">
        <div class="mt-12 prose">
          <div class="max-w-screen-3xl h-full mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php
            foreach (categories($db) as $category) {
            ?>
              <div class="max-w-sm w-full lg:max-w-full lg:flex">
                <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                  <object class="h-full lg:h-auto lg:w-full flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" data="/assets/img/<?php print image($category["image"])["image"] ?>"></object>
                </div>
                <div class="rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal w-full">
                  <div class="mb-8">
                    <div class="font-bold text-xl mb-2"><?php print $category["title"] ?></div>
                  </div>
                  <div class="flex items-center w-full">
                    <button onclick="window.open('/pages/tips/category.php?id=<?php print $category['id'] ?>','name','width=800,height=800')" class="w-full bg-black text-white px-4 py-2 text-center rounded-lg">
                      Bekijk tips
                    </button>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>