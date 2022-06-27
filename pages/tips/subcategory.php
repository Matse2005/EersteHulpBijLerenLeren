<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (!isset($_GET["id"])) print "<script>window.close();</script>";
$subcategory = subcategory($db, $_GET["id"]);
?>

<style>
  ul {
    list-style-type: inside !important;
    list-style: inside !important;
    list-style-position: inside !important;
  }

  li {
    list-style-type: inside !important;
    list-style: inside !important;
    list-style-position: inside !important;
  }
</style>

<div class="flex h-screen">
  <div class="w-full px-5 sm:px-5 md:px-5 h-full overflow-y-auto">
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
        <div class="px-1 md:px-6 mx-auto ">
          <div class="grid grid-cols-1 sm:grid-cols-4">
            <p class="my-6 col-span-3 text-xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0"><a class="underline" href="/pages/tips/category.php?id=<?php print category_get_by_id($db, $subcategory["category"])['id'] ?>"><?php print category_get_by_id($db, $subcategory["category"])["title"] ?></a> <i class="fa-solid fa-chevron-right relative mt-px overflow-visible mx-2.5"></i> <span class="font-bold"><?php print $subcategory["title"] ?></span></p>
            <div class="my-6 w-full flex justify-end">
              <button @click="window.close();" class="absolute bottom-3 right-3 sm:mt-2 sm:max-h-10 h-12 w-12 sm:h-full sm:w-auto sm:relative px-4 py-2 text-md bg-black text-white font-semibold rounded-full sm:rounded">
                <i class="fa-regular fa-xmark"></i>
                <span class="hidden sm:inline">Sluiten</span>
              </button>
            </div>
          </div>
          <div class="relative sm:pb-12">
            <div class="space-y-16">
              <?php
              foreach (tips($db, $_GET["id"]) as $tip) {
              ?>
                <section class="pt-12 overflow-hidden">
                  <div class="container">
                    <?php if ($tip["image"] !== "none") { ?>
                      <div class="grid grid-cols-1 md:grid-cols-2 justify-between items-center">
                        <div class="w-full px-4">
                          <div class="flex items-center -mx-3 sm:-mx-4">
                            <div class="w-full sm:w-4/6 px-3 sm:px-4">
                              <div class="py-3 sm:py-4">
                                <img loading="lazy" src="/assets/img/uploads/<?php print $tip["image"] ?>" alt="" class="rounded-2xl w-full" />
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="w-full px-4">
                        <div class="lg:mt-0">
                          <p class="text-base text-body-color mb-8">
                            <?php print $tip["content"] ?>
                          </p>
                        </div>
                      </div>
                      <?php if ($tip["image"] !== "none") { ?>
                      </div>
                    <?php } ?>
                  </div>
                </section>
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