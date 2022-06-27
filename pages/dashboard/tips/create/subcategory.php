<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (isset($_POST["submit"])) subcategory_add($db, $_POST["title"], $_POST["category"], $_POST["content"]);
?>

<div class="flex h-screen">
  <form action="" method="post" class="w-full px-5 sm:px-5 md:px-5 h-full overflow-y-auto">
    <div class="px-1 md:px-6 mx-auto ">
      <div class="grid grid-cols-4">
        <input name="title" placeholder="Subcategorie titel..." class="my-6 col-span-3 text-xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0" />
        <div class="my-6 w-full flex justify-end">
          <button type="submit" name="submit" class="absolute bottom-3 right-3 h-12 w-12 sm:h-full sm:w-auto sm:relative px-4 py-2 text-md bg-black text-white font-semibold rounded-full sm:rounded">
            <span class="hidden sm:inline">Publiceer</span>
            <i class="fa-regular fa-paper-plane-top"></i>
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <!-- QUestion input -->
        <div class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
          <select name="category" id="category" class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
            <option value="" disabled selected>Selecteer een categorie</option>
            <?php
            foreach (categories($db) as $categories) {
            ?>
              <option value="<?php echo $categories["id"]; ?>"><?php echo $categories["title"]; ?></option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="editor mt-5">
          <textarea name="content" placeholder="Begin met de uitleg over deze subcategorie..." id="editor" cols="30" rows="10"></textarea>
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
    menubar: true,
    plugins: [
      "list",
      "advlist",
      "autolink",
      "link",
      "image",
      "charmap",
      "code",
      "table",
      "textcolor",
      "colorpicker",
      "emoticons",
      "hr",
      "media",
      "paste",
      "fullscreen",
      "insertdatetime",
      "preview",
      "searchreplace",
      "wordcount",
      "visualblocks",
      "visualchars",
      "nonbreaking",
      "contextmenu",
      "directionality",
      "fullpage",
      "pagebreak",
      "save",
      "template",
      "paste",
      "textcolor",
      "colorpicker",
      "textpattern",
      "toc",
      "code",
    ],
    toolbar: "insert | undo redo | blocks | fontsize | bold italic forecolor backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | fullscreen",
  });
</script>

</body>

</html>