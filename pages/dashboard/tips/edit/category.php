<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (!isset($_GET['id'])) exit;
if (!category_get_by_id($db, $_GET['id'])) exit;
else $category = category_get_by_id($db, $_GET['id']);
if (isset($_POST["submit"])) category_edit($db, $_GET['id'], $_POST["title"], $_POST["question"], $_POST["image"]);
?>

<div class="flex h-screen">
  <form action="" method="post" class="w-full px-5 sm:px-5 md:px-5 h-full overflow-y-auto">
    <div class="px-1 md:px-6 mx-auto ">
      <div class="grid grid-cols-4">
        <input name="title" placeholder="Categorie titel..." value="<?php print $category["title"] ?>" class="my-6 col-span-3 text-xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0" />
        <div class="my-6 w-full flex justify-end">
          <button type="submit" name="submit" class="absolute bottom-3 right-3 h-12 w-12 sm:h-full sm:w-auto sm:relative px-4 py-2 text-md bg-black text-white font-semibold rounded-full sm:rounded">
            <span class="hidden sm:inline">Publiceer</span>
            <i class="fa-regular fa-paper-plane-top"></i>
          </button>
        </div>
      </div>
      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <!-- Question input -->
        <div class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
          <input name="question" value="<?php print $category["question"] ?>" placeholder="Welke stelling hoort er bij deze categorie?..." class="my-6 w-full h-full text-xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0" />
        </div>
        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-3">
          <!-- Image Selector Dropdown -->
          <div class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
            <select name="image" id="image" onchange="selectImage()" class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
              <option value="<?php print $category["image"] ?>" selected><?php print image($category["image"])["name"] ?></option>
              <?php
              foreach (images() as $image) {
                if ($image["id"] == $category["image"]) continue;
              ?>
                <option value="<?php echo $image["id"]; ?>"><?php echo $image["name"]; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <!-- Show image when selected -->
          <div class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
            <img src="/assets/img/<?php print image($category["image"])["image"] ?>" id="newImg" class="w-full max-9/10 bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0" />
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</div>

<script>
  function selectImage() {
    var e = document.getElementById("image");
    var imageId = e.value;
    var returnImg = document.getElementById("newImg");
    var poses = <?php print json_encode(images()); ?>;
    var image = poses.find(function(img) {
      return img.id == imageId;
    });
    returnImg.src = "/assets/img/" + image.image;
  }
</script>

</body>

</html>