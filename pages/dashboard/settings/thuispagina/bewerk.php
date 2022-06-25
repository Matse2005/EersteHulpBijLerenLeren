<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (isset($_POST["save"])) {
  homepage_update($db, $_POST["home_title"], $_POST["home_subtitle"], $_POST["home_howitworks_one_title"], $_POST["home_howitworks_one_subtitle"], $_POST["home_howitworks_two_title"], $_POST["home_howitworks_two_subtitle"], $_POST["home_howitworks_three_title"], $_POST["home_howitworks_three_subtitle"], $_POST["home_extra_websites"], $_POST["home_extra_bronnen"], $_POST["home_extra_credits"]);
}
?>

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_navigation.dashboard.php'; ?>
  <main class="h-full overflow-y-auto">
    <form action="" method="POST" class="container px-6 mx-auto ">
      <div class="grid sm:grid-cols-2">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Bewerk
        </h2>
        <div class="sm:my-6 w-full sm:justify-end hidden lg:flex">
          <button id="save" name="save" type="submit" class="px-4 py-2 text-md bg-black text-white font-semibold rounded">
            <i class="fa-regular fa-gear"></i>
            Bewerk pagina
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs block lg:hidden">
        Sorry, voor deze actie uit te voeren heb je een groter scherm nodig. Het is niet mogelijk om deze pagina te bewerken op kleinere schermen (mobiel). <br>
        Ook is het niet mogelijk om deze pagina te bewerken op de meeste tablets en kleine pc's. Het is dus aangeraden om een breder scherm te gebruiken.
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs hidden lg:block">
        <p class=""><span class="font-bold">Opmerking: </span>Al de bewerkbare teksten zullen omringt worden met een rode rand... deze rand zal niet zichtbaar zijn op de uiteindelijke pagina</p>
        <?php
        $texts = texts($db);
        ?>
        <!-- Hero -->
        <section class="md:mt-0 md:h-screen flex flex-col justify-center text-center md:text-left md:flex-row md:justify-between md:items-center bg-secondary">
          <div class="md:flex-1 md:mr-10">
            <h1 class="mb-7">
              <textarea type="text" name="home_title" class="font-source-code-pro text-5xl font-bold  bg-secondary border-2 border-red-500 p-3 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_title"] ?></textarea>
            </h1>
            <p class="font-source-code-pro font-normal mb-7">
              <textarea type="text" name="home_subtitle" class="font-source-code-pro font-normal bg-secondary border-2 border-red-500 p-3 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_subtitle"] ?></textarea>
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
              <h3 class="font-source-code-pro font-medium text-xl mb-2">
                <textarea type="text" name="home_howitworks_one_title" rows="1" class="font-source-code-pro text-xl font-medium text-center bg-black border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_howitworks_one_title"] ?></textarea>
              </h3>
              <p class="text-center font-source-code-pro">
                <textarea type="text" name="home_howitworks_one_subtitle" class="font-source-code-pro font-normal text-center bg-black border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_howitworks_one_subtitle"] ?></textarea>
              </p>
            </div>
            <div class="flex-1 mx-8 flex flex-col items-center my-4">
              <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
                2
              </div>
              <h3 class="font-source-code-pro font-medium text-xl mb-2">
                <textarea type="text" name="home_howitworks_two_title" rows="1" class="font-source-code-pro text-xl font-medium text-center bg-black border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_howitworks_two_title"] ?></textarea>
              </h3>
              <p class="text-center font-source-code-pro">
                <textarea type="text" name="home_howitworks_two_subtitle" class="font-source-code-pro font-normal text-center bg-black border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_howitworks_two_subtitle"] ?></textarea>
              </p>
            </div>
            <div class="flex-1 mx-8 flex flex-col items-center my-4">
              <div class="border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
                3
              </div>
              <h3 class="font-source-code-pro font-medium text-xl mb-2">
                <textarea type="text" name="home_howitworks_three_title" rows="1" class="font-source-code-pro text-xl font-medium text-center bg-black border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_howitworks_three_title"] ?></textarea>
              </h3>
              <p class="text-center font-source-code-pro">
                <textarea type="text" name="home_howitworks_three_subtitle" class="font-source-code-pro font-normal text-center bg-black border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_howitworks_three_subtitle"] ?></textarea>
              </p>
            </div>
          </div>
        </section>

        <!-- FAQ  -->
        <section class="items-start pt-8 md:pt-36 bg-secondary text-black">
          <div>
            <h2 class=" text-2xl bg-highlight3 p-10 mb-0 bg-center bg-100%">
              Extra informatie
            </h2>
          </div>

          <div toggleElement class="w-full py-4">
            <div class="flex justify-between items-center">
              <div question class="font-source-code-pro font-medium mr-auto w-full">
                <textarea type="text" name="home_extra_websites" rows="1" class="font-source-code-pro font-medium bg-secondary border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_extra_websites"] ?></textarea>
              </div>
              <img src='/assets/img/template/logos/CaretRight.svg' alt="" class="transform transition-transform" />
            </div>
            <div answer class="font-source-code-pro text-sm font-extralight pb-8 hidden">

            </div>
          </div>
          <hr class="w-full bg-black" />

          <div toggleElement class="w-full py-4">
            <div class="flex justify-between items-center">
              <div question class="font-source-code-pro font-medium mr-auto w-full">
                <textarea type="text" name="home_extra_bronnen" rows="1" class="font-source-code-pro font-medium bg-secondary border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_extra_bronnen"] ?></textarea>
              </div>
              <img src='/assets/img/template/logos/CaretRight.svg' alt="" class="transform transition-transform" />
            </div>
            <div answer class="font-source-code-pro text-sm font-extralight pb-8 hidden">
              Yes! For you it is free.
            </div>
          </div>
          <hr class="w-full bg-black" />

          <div toggleElement class="w-full py-4">
            <div class="flex justify-between items-center">
              <div question class="font-source-code-pro font-medium mr-auto w-full">
                <textarea type="text" name="home_extra_credits" rows="1" class="font-source-code-pro font-medium bg-secondary border-2 border-red-500 rounded focus:outline-none focus:border-none focus:ring-0 w-full h-auto resize-none"><?php print $texts["home_extra_credits"] ?></textarea>
              </div>
              <img src='/assets/img/template/logos/CaretRight.svg' alt="" class="transform transition-transform" />
            </div>
            <div answer class="font-source-code-pro text-sm font-extralight pb-8 hidden">
              Yes! No doubt about it.
            </div>
          </div>
          <hr class="w-full bg-black" />

        </section>
      </div>
    </form>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.dashboard.php'; ?>

    <script>
      const tx = document.getElementsByTagName("textarea");
      for (let i = 0; i < tx.length; i++) {
        tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
        tx[i].addEventListener("input", OnInput, false);
      }

      // Auto save after 1 minute when not in a textarea
      setInterval(function() {
        if (document.activeElement.tagName != "TEXTAREA") {
          document.getElementById("save").click();
        }
      }, 60 * 1000);

      function OnInput() {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
      }

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

      // Save on control + s
      $(document).keydown(function(e) {
        if (e.which == 83 && e.ctrlKey) {
          e.preventDefault();
          $('#save').click();
        }
      });
    </script>