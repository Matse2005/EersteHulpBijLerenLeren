<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $stmt = $db->prepare("SELECT * FROM articles WHERE id = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $article = $stmt->fetch();
}

if (isset($_POST["submit"])) {
  $title = $_POST["title"];
  if (isset($_POST["slug"])) {
    $slug = str_replace(" ", "-", $_POST["slug"]);
    $slug = strtolower($slug);
  } else {
    $slug = str_replace(" ", "-", $title);
    $slug = strtolower($slug);
  }
  $description = $_POST["description"];
  $content = $_POST["content"];

  article_edit($db, $id, $title, $slug, $description, $content);
}
?>

<div class="flex h-screen">
  <form action="" method="post" class="w-full px-5 sm:px-10 md:px-20 h-full overflow-y-auto">
    <div class="px-1 md:px-6 mx-auto ">
      <div class="grid sm:grid-cols-2">
        <p class="my-6 w-full text-2xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0">Bewerk artikel</p>
        <div class="my-6 w-full flex justify-end">
          <button type="submit" name="submit" class="absolute z-20 bottom-3 sm:bottom-0 sm:relative cursor-pointer hover:opacity-70 right-3 h-12 w-12 sm:h-full sm:w-auto px-4 py-2 text-md bg-black text-white font-semibold rounded-full sm:rounded">
            <span class="hidden sm:inline">Bewerken</span>
            <i class="fa-regular fa-paper-plane-top"></i>
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <input name="title" value="<?php print $article["title"] ?>" placeholder="Artikel naam..." class="my-6 w-full text-xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0" />
        <div class="slug mb-6">
          <input name="slug" value="<?php print $article["slug"] ?>" placeholder="Slug..." class="w-full my-6 bg-secondary border-none focus:outline-none focus:border-none focus:ring-0" />
        </div>
        <div class="description mb-6">
          <textarea placeholder="Een korte beschrijving waarover het volgende artikel zal gaan..." name="description" id="description" class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0 border-l-4" rows="2"><?php print $article["description"] ?></textarea>
        </div>

        <div class="editor">
          <textarea name="content" id="editor" cols="30" rows="10" placeholder="Begin met het typen van het artikel hier..."><?php print $article["content"] ?></textarea>
        </div id="editor">
      </div>
    </div>
  </form>
</div>
</div>

<script src="/assets/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#editor',
    menubar: false,
  });
</script>

</body>

</html>