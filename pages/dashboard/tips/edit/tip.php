<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (!isset($_GET['id'])) exit;
if (!tip($db, $_GET['id'])) exit;
else $tip = tip($db, $_GET['id']);
if (isset($_POST["submit"])) tip_edit($db, $_GET['id'], $_POST["subcategory"], $_POST["content"]);
?>

<div class="flex h-screen">
  <form action="" method="post" enctype="multipart/form-data" class="w-full px-5 sm:px-5 md:px-5 h-full overflow-y-auto">
    <div class="px-1 md:px-6 mx-auto ">
      <div class="grid grid-cols-4">
        <div class="col-span-3"></div>
        <div class="my-6 w-full flex justify-end">
          <button type="submit" name="submit" class="absolute bottom-3 right-3 h-12 w-12 sm:h-full sm:w-auto sm:relative px-4 py-2 text-md bg-black text-white font-semibold rounded-full sm:rounded">
            <span class="hidden sm:inline">Publiceer</span>
            <i class="fa-regular fa-paper-plane-top"></i>
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <!-- Question input -->
        <div class="w-full mt-5 bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
          <select name="subcategory" id="subcategory" class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0">
            <option value="<?php print $tip["subcategory"] ?>" selected><?php print subcategory($db, $tip["subcategory"])["title"] ?></option>
            <?php
            foreach (subcategories($db) as $subcategory) {
              if ($subcategory["id"] == $tip["subcategory"]) continue;
            ?>
              <option value="<?php echo $subcategory["id"]; ?>"><?php echo $subcategory["title"]; ?></option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="editor mt-5">
          <textarea name="content" placeholder="Begin met het typen van de tip..." id="editor" cols="30" rows="10">
            <?php print $tip["content"] ?>
          </textarea>
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