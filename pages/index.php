  <?php
  include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
  include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";
  $texts = texts($db);
  ?>
  <!-- Hero -->
  <section class="pt-24 md:mt-0 md:h-screen flex flex-col justify-center text-center md:text-left md:flex-row md:justify-between md:items-center lg:px-48 md:px-12 px-4 bg-secondary">
    <div class="md:flex-1 md:mr-10">
      <h1 class="font-source-code-pro text-5xl font-bold mb-7">
        <?php print $texts["home_title"] ?>
      </h1>
      <p class="font-source-code-pro font-normal mb-7">
        <?php print $texts["home_subtitle"] ?>
      </p>
      <div class="font-source-code-pro">
        <button onclick="window.open('/pages/formulier.php','name','width=800,height=800')" class="bg-black w-full xl:w-auto text-center px-6 py-4 rounded-lg border-2 border-black border-solid text-white mr-2 mb-2">
          Ga naar formulier
        </button>
        <a href="/hulp" class="mt-2 xl:mt-0 block xl:inline text-center w-full lg:w-auto px-6 py-4 border-2 border-black border-solid rounded-lg">
          Ga naar mijn hulp
        </a>
      </div>
    </div>
    <div class="flex justify-around md:block mt-8 md:mt-0 md:flex-1 w-full">
      <object data="/assets/img/header.svg" class="mx-auto" type="image/svg+xml">
        Header image
      </object>
    </div>
  </section>

  <!-- How it works -->
  <section class="bg-black text-white sectionSize">
    <div>
      <h2 class="bg-underline2 bg-100% text-2xl">Hoe werkt het</h2>
    </div>
    <div class="flex flex-col md:flex-row">
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          1
        </div>
        <h3 class="font-source-code-pro font-medium text-xl mb-2"><?php print $texts["home_howitworks_one_title"] ?></h3>
        <p class="text-center font-source-code-pro">
          <?php print $texts["home_howitworks_one_subtitle"] ?>
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          2
        </div>
        <h3 class="font-source-code-pro font-medium text-xl mb-2"><?php print $texts["home_howitworks_two_title"] ?></h3>
        <p class="text-center font-source-code-pro">
          <?php print $texts["home_howitworks_two_subtitle"] ?>
        </p>
      </div>
      <div class="flex-1 mx-8 flex flex-col items-center my-4">
        <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
          3
        </div>
        <h3 class="font-source-code-pro font-medium text-xl mb-2"><?php print $texts["home_howitworks_three_title"] ?></h3>
        <p class="text-center font-source-code-pro">
          <?php print $texts["home_howitworks_three_subtitle"] ?>
        </p>
      </div>
    </div>
  </section>

  <!-- FAQ  -->
  <section class="sectionSize items-start pt-8 md:pt-36 bg-secondary text-black">
    <div>
      <h2 class=" text-2xl bg-highlight3 p-10 mb-0 bg-center bg-100%">
        Extra informatie
      </h2>
    </div>

    <div toggleElement class="w-full py-4">
      <div class="flex justify-between items-center">
        <div question class="font-source-code-pro font-medium mr-auto">
          <?php print $texts["home_extra_websites"] ?>
        </div>
        <img src='/assets/img/template/logos/CaretRight.svg' alt="" class="transform transition-transform" />
      </div>
      <div answer class="font-source-code-pro text-sm font-extralight pb-8 hidden">
        <?php
        foreach (websites($db) as $website) {
          print "<a href='" . $website["url"] . "' target='_blank' class='text-black block mb-1 underline'>" . $website["content"] . " <i class='bx bx-link-external'></i></a><br>";
        }
        ?>
      </div>
    </div>
    <hr class="w-full bg-black" />

    <div toggleElement class="w-full py-4">
      <div class="flex justify-between items-center">
        <div question class="font-source-code-pro font-medium mr-auto">
          <?php print $texts["home_extra_bronnen"] ?>
        </div>
        <img src='/assets/img/template/logos/CaretRight.svg' alt="" class="transform transition-transform" />
      </div>
      <div answer class="font-source-code-pro text-sm font-extralight pb-8 hidden">
        <?php
        foreach (bronnen($db) as $bron) {
          if ($bron["type"] != "url") {
            print "<p class='mb-1'>" . $bron["content"] . "</p><br>";
          } else {
            print "<a href='" . $bron["url"] . "' target='_blank' class='text-black block mb-1 underline'>" . $bron["content"] . " <i class='bx bx-link-external'></i></a><br>";
          }
        }
        ?>
      </div>
    </div>
    <hr class="w-full bg-black" />

    <div toggleElement class="w-full py-4">
      <div class="flex justify-between items-center">
        <div question class="font-source-code-pro font-medium mr-auto">
          <?php print $texts["home_extra_credits"] ?>
        </div>
        <img src='/assets/img/template/logos/CaretRight.svg' alt="" class="transform transition-transform" />
      </div>
      <div answer class="font-source-code-pro text-sm font-extralight pb-8 hidden">
        <?php
        foreach (credits($db) as $credit) {
          print "<a href='" . $credit["url"] . "' target='_blank' class='text-black block mb-1 underline'>" . $credit["content"] . " <i class='bx bx-link-external'></i></a><br>";
        }
        ?>
      </div>
    </div>
    <hr class="w-full bg-black" />

  </section>

  <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>