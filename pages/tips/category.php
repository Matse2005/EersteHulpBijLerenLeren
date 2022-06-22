<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (!isset($_GET["id"])) print "<script>window.close();</script>";
$category = getCategoryByID($db, $_GET["id"]);
?>

<div class="flex h-screen">
  <div class="w-full h-full overflow-y-auto">
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
        <div class="px-1 md:px-6 mx-auto ">
          <div class="grid grid-cols-1 sm:grid-cols-4">
            <p class="my-6 col-span-3 text-xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0"><span class="font-bold"><?php print $category["title"] ?></span></p>
            <div class="my-6 w-full flex justify-end">
              <button @click="window.close();" class="absolute bottom-3 right-3 sm:mt-2 sm:max-h-10 h-12 w-12 sm:h-full sm:w-auto sm:relative px-4 py-2 text-md bg-black text-white font-semibold rounded-full sm:rounded">
                <i class="fa-regular fa-xmark"></i>
                <span class="hidden sm:inline">Sluiten</span>
              </button>
            </div>
          </div>
          <div class="relative sm:pb-12 mt-10">
            <div class="space-y-16">
              <?php
              foreach (getSubCategoriesByCategroyID($db, $_GET["id"]) as $subcategory) {
              ?>
                <article class="relative">
                  <div class="relative">
                    <h3 class="text-base font-bold tracking-tight text-slate-900 dark:text-slate-200 pt-8 lg:pt-0"><?php print $subcategory["title"] ?></h3>
                    <div class="mt-2 mb-4 prose prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
                      <p><?php print $subcategory["description"] ?></p>
                    </div>
                  </div><a class="flex items-center text-sm text-sky-500 font-medium" href="/pages/tips/subcategory.php?id=<?php print $subcategory["id"] ?>"><span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span>
                    <span class="relative">Meer weten</span>
                    <i class="fa-solid fa-chevron-right text-sm relative mt-px overflow-visible ml-2.5 text-sky-300 dark:text-sky-700"></i>
                  </a>
                </article>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</body>

</html>