<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";
$texts = texts($db);
?>

<!-- Articles -->

<section class="sectionSize bg-secondary font-source-code-pro">
  <main class="max-w-[52rem] mx-auto px-4 pb-28 sm:px-6 md:px-8 xl:px-12 lg:max-w-6xl">
    <header class="py-16 sm:text-center">
      <h1 class="mb-4 text-3xl sm:text-4xl tracking-tight text-slate-900 font-extrabold dark:text-slate-200">Artikels</h1>
    </header>
    <div class="relative sm:pb-12 sm:ml-[calc(2rem+1px)] md:ml-[calc(3.5rem+1px)] lg:ml-[max(calc(14.5rem+1px),calc(100%-48rem))]">
      <div class="hidden absolute top-3 bottom-0 right-full mr-7 md:mr-[3.25rem] w-px bg-slate-200 dark:bg-slate-800 sm:block"></div>
      <div class="space-y-16">
        <?php
        foreach (array_reverse(articles($db)) as $article) {
        ?>
          <article class="relative group">
            <div class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl group-hover:bg-slate-50/70 dark:group-hover:bg-slate-800/50"></div><svg viewBox="0 0 9 9" class="hidden absolute right-full mr-6 top-2 text-slate-200 dark:text-slate-600 md:mr-12 w-[calc(0.5rem+1px)] h-[calc(0.5rem+1px)] overflow-visible sm:block">
              <circle cx="4.5" cy="4.5" r="4.5" stroke="currentColor" class="fill-white dark:fill-slate-900" stroke-width="2"></circle>
            </svg>
            <div class="relative">
              <h3 class="text-base font-bold tracking-tight text-slate-900 dark:text-slate-200 pt-8 lg:pt-0"><?php print $article["title"] ?></h3>
              <div class="mt-2 mb-4 prose prose-slate prose-a:relative prose-a:z-10 dark:prose-dark line-clamp-2">
                <p><?php print $article["description"] ?></p>
              </div>
              <dl class="absolute left-0 top-0 lg:left-auto lg:right-full lg:mr-[calc(6.5rem+1px)]">
                <dt class="sr-only">Datum</dt>
                <dd class="whitespace-nowrap text-sm leading-6 dark:text-slate-400"><time dateTime="2022-02-24T12:00:00.000Z"><?php print format($article["created_at"]) ?></time></dd>
              </dl>
            </div><a class="flex items-center text-sm text-sky-500 font-medium" href="/articles/<?php print $article["slug"] ?>"><span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span><span class="relative">Lees meer<span class="sr-only">,
                  <!-- --><?php print $article["title"] ?>
                </span></span><svg class="relative mt-px overflow-visible ml-2.5 text-sky-300 dark:text-sky-700" width="3" height="6" viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M0 0L3 3L0 6"></path>
              </svg></a>
          </article>
        <?php
        }
        ?>
      </div>
    </div>
  </main>
  <!-- <div class="md:grid md:grid-cols-2 md:grid-rows-2">

    <?php
    foreach (articles($db) as $article) {
    ?>

      <a href="/articles/<?php print $article["slug"] ?>" class="flex items-start font-source-code-pro my-6 mr-10">
        <div>
          <h3 class="font-semibold text-2xl"><?php print $article["title"] ?></h3>
          <p>
            <?php print $article["description"] ?>
          </p>
        </div>
      </a>

    <?php
    }
    ?>

  </div> -->
</section>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>