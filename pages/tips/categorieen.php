<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php");

if (!isset($_GET["cSlug"])) {
  location("/tips");
  exit;
}
$category = category_get($db, $_GET["cSlug"]);
?>

<!-- Hero -->
<section class="pt-24 md:mt-0 md:h-screen flex flex-col justify-center text-center md:text-left md:flex-row md:justify-between md:items-center lg:px-48 md:px-12 px-4 bg-secondary">
  <div class="md:flex-1 md:mr-10">
    <h1 class="font-source-code-pro text-5xl font-bold mb-7">
      <?php print $category["title"] ?>
    </h1>
    <!-- <p class="font-source-code-pro font-normal mb-7">
      <?php print $category["description"] ?>
    </p> -->
  </div>
  <?php
  if (isset($_GET["resultID"])) {
    if (resultID($db, $_GET["resultID"])) {
  ?>
      <div class="md:grid md:grid-cols-2">
        <a class="/" class="w-full border-2">
          <p>Vorige tip</p>
          <p>Tip naam</p>
        </a>
      </div>
  <?php
    }
  }
  ?>
  <div class="flex justify-around md:block mt-8 md:mt-0 md:flex-1 w-full">
    <object data="/assets/img/<?php print image($category["image"])["image"] ?>" class="mx-auto w-[417px] h-[500px]" type="image/svg+xml">
      Header image
    </object>
  </div>
</section>

<section class="sectionSize sectionSizeWithoutCenter bg-secondary md:mt-0">
  <div class="md:grid md:mt-2 md:grid-cols-2 md:grid-rows-2">
    <?php
    foreach (subcategories_get_by_category_id($db, $category["id"]) as $subcategory) {
    ?>

      <a href="/tips/<?php print $subcategory["slug"] ?>" class="flex items-start font-source-code-pro my-6 mr-10">
        <div>
          <h3 class="font-semibold text-2xl"><?php print $subcategory["title"] ?></h3>
          <p>
            <?php print $subcategory["description"] ?>
          </p>
        </div>
      </a>
    <?php
    }
    ?>

  </div>
</section>

<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php");; ?>