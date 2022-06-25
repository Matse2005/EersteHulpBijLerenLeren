<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_navigation.php";
?>
<!--========== DATATABLES ==========-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="  https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>


<!-- Hero -->
<div class="overflow-hidden bg-secondary pt-20">
  <div class="px-4 sm:px-6 md:px-8">
    <div class="max-w-5xl mx-auto pb-28">
      <!-- 
        Table for showing the results
      -->
      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table id="table" class="w-full whitespace-no-wrap">
            <thead>
              <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">Eigenaar</th>
                <th class="px-4 py-3">Datum</th>
                <th class="px-4 py-3">Laatst bekeken</th>
                <th class="px-4 py-3"></th>
              </tr>
            </thead>
            <tbody class="dark:divide-gray-700 dark:bg-gray-800">
              <?php
              foreach (array_reverse(results($db, $user)) as $result) {
              ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div>
                        <p class="font-semibold">
                          <?php
                          print user($db, $result["user_id"])["firstname"] . " " . user($db, $result["user_id"])["lastname"];
                          ?>
                        </p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-sm">
                    <?php print format($result["created_at"]) ?>
                  </td>
                  <td class="px-4 py-3 text-sm">
                    <?php
                    if ($result["created_at"] == $result["watched_at"]) {
                      print "Nog niet bekeken";
                    } else {
                      print format($result["watched_at"]);
                    }
                    ?>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <a href="/hulp/<?php print $result["id"] ?>" class="flex bg-black text-white items-center justify-between px-4 py-2 text-sm font-medium leading-5 rounded-lg focus:outline-none">
                        Bekijken
                      </a>
                    </div>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_footer.php"; ?>