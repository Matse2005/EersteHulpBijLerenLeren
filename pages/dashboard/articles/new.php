<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_header.dashboard.php'; ?>

<?php
if (isset($_POST["submit"])) {
  $title = $_POST["title"];
  $slug = str_replace(" ", "-", $title);
  $slug = strtolower($slug);
  $description = $_POST["description"];
  $content = $_POST["content"];

  newArticle($db, $title, $slug, $description, $content);
}
?>

<div class="flex h-screen">
  <form action="" method="post" class="w-full px-5 sm:px-5 md:px-5 h-full overflow-y-auto">
    <div class="px-1 md:px-6 mx-auto ">
      <div class="grid grid-cols-2">
        <input name="title" placeholder="Artikel naam..." class="my-6 text-2xl font-semibold bg-secondary border-none focus:outline-none focus:border-none focus:ring-0" />
        <div class="my-6 w-full flex justify-end">
          <button type="submit" name="submit" class="absolute bottom-3 right-3 h-12 w-12 sm:h-full sm:w-auto sm:relative px-4 py-2 text-md bg-black text-white font-semibold rounded-full sm:rounded">
            <span class="hidden sm:inline">Publiceer</span>
            <i class="fa-regular fa-paper-plane-top"></i>
          </button>
        </div>
      </div>

      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="description mb-6">
          <textarea placeholder="Een korte beschrijving waarover het volgende artikel zal gaan..." name="description" id="description" class="w-full bg-secondary resize-none border-none focus:outline-none focus:border-none focus:ring-0 border-l-4" rows="2"></textarea>
        </div>

        <div class="editor">
          <textarea name="content" placeholder="Begin met het typen van je artikel..." id="editor" cols="30" rows="10"></textarea>
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
    ],
    toolbar: "insert | undo redo | blocks | fontsize | bold italic forecolor backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image media | fullscreen",
  });
</script>

</body>

</html>