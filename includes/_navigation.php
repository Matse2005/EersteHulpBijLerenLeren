<!-- Navigation -->
<nav class="fixed flex justify-between py-6 w-full lg:px-48 md:px-12 px-4 content-center z-10">
  <div class="flex items-center">
    <?php
    if (str_ends_with(settings($db)["logo"], ".svg")) {
      print '<object data="/assets/img/uploads/' . settings($db)["logo"] . '" alt="' . settings($db)["name"] . '" class="h-12"></object>';
    } else {
      print '<img class="h-12" src="/assets/img/uploads/' . settings($db)["logo"] . '" alt="' . settings($db)["name"] . '" />';
    }
    ?>
  </div>
  <ul class="font-source-code-pro items-center hidden lg:flex">
    <li class="mx-3 ">
      <a class="growing-underline" href="/">Start</a>
    </li>
    <li class="growing-underline mx-3">
      <a href="/tips">Tips</a>
    </li>
    <li class="growing-underline mx-3">
      <a href="/artikels">Artikels</a>
    </li>
    <li class="growing-underline mx-3">
      <a href="/hulp">Mijn Hulp</a>
    </li>
    <li class="growing-underline mx-3">
      <a href="/profiel">Mijn Profiel</a>
    </li>
    <?php if (admin_check($db, $user["id"])) { ?>
      <li class="growing-underline mx-3">
        <a href="/dashboard/">Dashboard</a>
      </li>
    <?php } ?>
  </ul>
  <div class="font-source-code-pro hidden lg:block mt-3">
    <a href="/loguit" class="py-2 px-4 text-white bg-black rounded-3xl">
      Log uit
    </a>
  </div>
  <div id="showMenu" class="lg:hidden p-3">
    <img src='/assets/img/template/logos/Menu.svg' alt="Menu icon" />
  </div>
</nav>
<div id='mobileNav' class="hidden px-4 py-6 fixed top-0 left-0 h-full w-full bg-secondary z-20 animate-fade-in-down">
  <div id="hideMenu" class="flex justify-end">
    <img src='/assets/img/template/logos/Cross.svg' alt="" class="h-16 w-16" />
  </div>
  <ul class="font-source-code-pro flex flex-col mx-8 my-24 items-center text-3xl">
    <li class="my-6">
      <a href="/">Start</a>
    </li>
    <li class="my-6">
      <a href="/tips">Tips</a>
    </li>
    <li class="my-6">
      <a href="/artikels">Artikels</a>
    </li>
    <li class="my-6">
      <a href="/hulp">Mijn Hulp</a>
    </li>
    <li class="my-6">
      <a href="/profiel">Mijn Profiel</a>
    </li>
    <?php if (admin_check($db, $user["id"])) { ?>
      <li class="my-6">
        <a href="/dashboard/">Dashboard</a>
      </li>
    <?php } ?>
    <li class="my-6">
      <a href="/loguit" class="py-2 px-4 text-white bg-black rounded-3xl">Log uit</a>
    </li>
  </ul>
</div>