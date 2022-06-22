<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";

if (!isset($_GET["slug"])) {
  location("/artikels");
  exit;
}

$article = getArticle($db, $_GET["slug"]);
if (!$article) {
  location("/artikels");
  exit;
}
?>

<title><?php print $article["title"] ?></title>

<!-- Hero -->
<div class="overflow-hidden bg-secondary">
  <div class="max-w-8xl mx-auto">
    <div class="flex px-4 pt-8 pb-10 lg:px-8">
      <!-- <a class="group flex font-semibold text-sm leading-6 text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white" href="/blog">
        <svg viewBox="0 -9 3 24" class="overflow-visible mr-3 text-slate-400 w-auto h-6 group-hover:text-slate-600 dark:group-hover:text-slate-300">
          <path d="M3 0L0 3L3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        Go back
      </a> -->
    </div>
  </div>
  <div class="px-4 sm:px-6 md:px-8">
    <div class="max-w-3xl mx-auto pb-28">
      <main>
        <article class="relative pt-20">
          <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-slate-200 md:text-3xl"><?php print $article["title"] ?></h1>
          <div class="text-sm leading-6">
            <dl>
              <dt class="sr-only">Datum</dt>
              <dd class="absolute top-10 inset-x-0 text-slate-700 dark:text-slate-400"><time dateTime="<?php print $article["created_at"] ?>"><?php print format($article["created_at"]) ?></time></dd>
            </dl>
          </div>
          <div class="mt-8 pl-7">
            <?php print $article["description"] ?>
          </div>
          <div class="mt-8">
            <?php print $article["content"] ?>
          </div>
        </article>
      </main>
    </div>
  </div>

  <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>