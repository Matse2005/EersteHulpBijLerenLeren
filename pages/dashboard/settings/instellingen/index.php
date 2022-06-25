<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (isset($_POST["save"])) {
  if (isset($_FILES["logo"])) {
    $filename = explode(".", $_FILES["logo"]["name"]);
    $tempname = $_FILES["logo"]["tmp_name"];
    $folder = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/uploads/";
    $newfilename = round(microtime(true)) . '.' . end($filename);

    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $folder . $newfilename)) {
      settings_update_logo($db, $newfilename);
    }
  }

  if (isset($_POST["name"])) {
    settings_update($db, $_POST["name"]);
  }
}
?>

<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_navigation.dashboard.php'; ?>
  <main class="h-full overflow-y-auto">
    <form action="" method="POST" enctype="multipart/form-data" class="container px-6 mx-auto ">
      <!-- 
        Settings form
        Settings: 
          - Name
          - Logo
      -->
      <div class="grid md:grid-cols-2">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Website instellingen
        </h2>
        <div class="md:my-6 w-full flex md:justify-end">
          <button type="submit" name="save" id="save" class="px-4 py-2 text-md bg-black text-white font-semibold rounded">
            <i class="fa-regular fa-save"></i>
            Opslaan
          </button>
        </div>
      </div>
      <div class="grid md:grid-cols-2 gap-2">
        <!-- 
          Website name
         -->
        <div class="md:my-6">
          <label for="home_title" class="block text-gray-700 dark:text-gray-200">
            Naam
          </label>
          <input type="text" name="name" id="name" class="w-full px-4 py-2 rounded-lg " value="<?php print settings($db)["name"]; ?>">
        </div>
        <!-- 
          Website logo
         -->
        <div class="md:my-6">
          <div class="flex items-center space-x-6">
            <div class="shrink-0">
              <img class="object-cover h-16" src="/assets/img/uploads/<?php print settings($db)["logo"] ?>" alt="Current logo" />
            </div>
            <label class="block">
              <input type="file" name="logo" id="logo" class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white file:text-black" />
            </label>
          </div>
          <label for="logo">Selecteer geen nieuwe afbeelding als het logo niet geupdate moet worden...</label>
        </div>
      </div>
    </form>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.dashboard.php'; ?>

    <script>
      // Save on control + s
      $(document).keydown(function(e) {
        if (e.which == 83 && e.ctrlKey) {
          e.preventDefault();
          $('#save').click();
        }
      });
    </script>