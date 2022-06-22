<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";

if (!isset($_GET["id"])) {
  location("/hulp");
  exit();
}

$result = getResult($db, $_GET["id"]);
if (!$result) {
  location("/hulp");
  exit();
}
?>

<!-- Hero -->
<div class="overflow-hidden bg-secondary pt-20">
  <div class="overflow-hidden">
    <div class="max-w-8xl mx-auto">
      <div class="flex px-4 pt-8 pb-10 lg:px-8">
        <a class="group flex font-semibold text-sm leading-6" href="/blog">
          <svg viewBox="0 -9 3 24" class="overflow-visible mr-3 w-auto h-6">
            <path d="M3 0L0 3L3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          Ga alle resultaten
        </a>
      </div>
    </div>
    <div class="px-4 sm:px-6 md:px-8">
      <div class="max-w-5xl mx-auto pb-28">
        <main>
          <div class="relative pt-10">
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-slate-200 md:text-3xl">Welkom, <?php print $user["firstname"] . " " . $user["lastname"] ?></h1>
            <div class="text-sm leading-6">
              <dl>
                <dt class="sr-only">Datum</dt>
                <dd class="absolute top-0 inset-x-0 text-slate-700 dark:text-slate-400"><time dateTime="<?php print $result["created_at"] ?>"><?php print format($result["created_at"]) ?></time></dd>
              </dl>
            </div>
            <div class="mt-6">
              <?php
              if ($user["id"] != $result["user_id"]) {
              ?>
                <ul class="flex flex-wrap text-sm leading-6 -mt-6 -mx-5">
                  <li class="flex items-center font-medium whitespace-nowrap px-5 mt-6">
                    <!-- Profile picture -->
                    <div class="relative w-9 h-9 bg-gray-200 rounded-full overflow-hidden shadow-inner mr-2">
                      <img class="absolute inset-0 w-full h-full object-cover" src="/assets/img/signin.jpg" alt="<?php print $user["firstname"] . " " . $user["lastname"] ?>">
                    </div>
                    <div class="text-sm leading-4">
                      <div class="text-slate-900 dark:text-slate-200"><?php print user($db, $result["user_id"])["firstname"] . " " . user($db, $result["user_id"])["lastname"] ?></div>
                      <div class="mt-1">
                        <?php
                        if (str_starts_with($result["user_id"], "sm_")) {
                          print "Smartschool gebruiker";
                        } else {
                          print "Gebruiker";
                        }
                        ?>
                      </div>
                    </div>
                  </li>
                </ul>
              <?php
              }
              ?>
            </div>
            <div class="mt-12 prose">
              <div class="max-w-screen-3xl h-full mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php
                $array = json_decode($result["results"], true);
                arsort($array);
                foreach ($array as $key => $value) {
                  $category = getCategoryByID($db, $key);
                  if (!$category) {
                    continue;
                  }
                ?>
                  <div class="max-w-sm w-full lg:max-w-full lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                      <object class="h-full lg:h-auto lg:w-full flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" data="/assets/img/<?php print image($category["image"])["image"] ?>"></object>
                    </div>
                    <div class="rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                      <div class="mb-8">
                        <p class="text-sm flex items-center">
                          <i class="fa-regular fa-star"></i>
                          <span class="ml-1">
                            <?php
                            if ($value > 7) {
                              print "Het is ten zeerste aangeraden om deze tips te lezen en te gebruiken.";
                            } else if ($value > 5) {
                              print "Het is aangeraden om deze tips te lezen en te gebruiken.";
                            } else if ($value > 3) {
                              print "Het is nog een beetje aangeraden om deze tips te lezen en te gebruiken.";
                            } else {
                              print "Het is mogelijk om deze tips te lezen en te gebruiken.";
                            }
                            ?>
                          </span>
                        </p>
                        <div class="font-bold text-xl mb-2"><?php print $category["title"] ?></div>
                      </div>
                      <div class="flex items-center aangeraden">
                        <button onclick="window.open('/pages/tips/category.php?id=<?php print $category['id'] ?>','name','width=800,height=800')" class="w-full bg-black text-white px-4 py-2 text-center rounded-lg">
                          Bekijk tips
                        </button>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</div>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>