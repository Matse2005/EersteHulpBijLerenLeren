<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";
?>

<div class="px-4 sm:px-6 md:px-8">
  <div class="max-w-5xl mx-auto pb-28">
    <main>
      <div class="relative pt-10">
        <div class="mt-12 prose">
          <div class="max-w-screen-3xl h-full mx-auto grid grid-cols-1 sm:grid-cols-3 gap-4">
            <?php
            foreach (files($db) as $file) {
              if ($file["visible"] !== 1) continue;
            ?>
              <div class="max-w-sm w-full lg:max-w-full lg:flex">
                <div class="rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal w-full">
                  <div class="mb-8">
                    <div class="font-bold text-xl mb-2"><?php print $file["title"] ?></div>
                  </div>
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 items-center w-full">
                    <a href="/assets/uploads/<?php print $file["file"] ?>" target="_blank" class="w-full bg-black border-2 border-black text-white px-4 py-2 text-center rounded-lg">
                      Bekijk
                    </a>
                    <a href="/download/<?php print $file["id"] ?>" target="_blank" class="w-full border-black border-2 text-black px-4 py-2 text-center rounded-lg">
                      Download
                    </a>
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