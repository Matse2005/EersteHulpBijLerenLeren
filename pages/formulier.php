<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.php'; ?>

<?php
if (isset($_POST["submit"])) {
  $results = array();

  foreach (categories($db) as $category) {
    $results[$category["id"]] =  $_POST["q" . $category["id"]];
  }

  result_save($db, $user["id"], json_encode($results));
}
?>

<div class="flex h-screen">
  <form action="" method="post" class="w-full px-5 sm:px-10 md:px-20 h-full overflow-y-auto">
    <div class="px-1 md:px-6 mx-auto ">
      <div class="grid sm:grid-cols-2">
        <p class="my-6 w-full text-2xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0">Beantwoord de stellingen</p>
        <div class="sm:my-6 w-full flex sm:justify-end sm:py-3">
          <button type="submit" name="submit" class=" bg-black text-white px-4 py-2 sm:py-0 md:py-2 rounded-lg">
            Verzenden
            <i class="fa-regular fa-paper-plane text-lg"></i>
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full p-4">
          <p class="mb-10">
            Hallo, <?php print $user["firstname"] ?>! Hieronder staat een lijst met vragen die je moet beantwoorden. Elke vraag is een stelling waarop je een score van 0 tot 10 kunt geven. 0 betekend dat je niet akkoord gaat met de stelling en 10 betekend dat je zelfs niet weet waarom je dit niet aanvaard.
          </p>
          <?php
          foreach (categories($db) as $category) {
          ?>
            <div class="w-full mb-7">
              <div class="form-title">
                <label for="q<?php print $category["id"] ?>" class="form-title-cell"><?php print $category["question"] ?></label>
                <!-- <div class="value form-title-cell" id="val4">5</div> -->
              </div>
              <div class="flex h-full">
                <div class="flex w-full my-auto items-center">
                  <div class="font-semibold">0</div>
                  <input name="q<?php print $category["id"] ?>" type="range" min="0" max="10" value="5" steps="1" class="relative mx-4 w-full bg-black appearance-none h-[3px] rounded-full">
                  <div class="font-semibold">10</div>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </form>
</div>
</div>

<script>
  function setValue(value, id) {
    document.getElementById(id).innerText = value;
  }
</script>


</body>

</html>