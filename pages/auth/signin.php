<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php"; ?>

<?php
if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $error = login($db, $email, $password);
}
?>

<div class="2xl:container h-screen m-auto font-source-code-pro">
  <div hidden class="fixed inset-0 w-7/12 lg:block">
    <img class="w-full h-full object-cover" src="/assets/img/signin.jpg" alt="Sign in screen image">
  </div>
  <div hidden role="hidden" class="fixed inset-0 w-6/12 ml-auto bg-secondary bg-opacity-100 backdrop-blur-3xl lg:block"></div>
  <div class="relative h-full ml-auto lg:w-6/12">
    <div class="m-auto py-12 px-6 sm:p-20 xl:w-10/12">
      <div class="space-y-4">
        <p class="text-2xl text-gray-600 font-bold">Meld je aan om verder te gaan</p>
      </div>

      <div class="mt-12">
        <button class="py-3 px-6 w-full rounded-xl bg-orange-100 hover:bg-orange-200 focus:bg-orange-100 active:bg-orange-200">
          <div class="flex gap-3 justify-center">
            <object type="image/svg+xml" data="/assets/img/smartschool.svg" class="w-5">
              Smartschool App Logo
            </object>
            <span class="block w-max font-medium tracking-wide text-sm text-orange-700">met Smartschool</span>
          </div>
        </button>
      </div>

      <div role="hidden" class="mt-12 border-t">
        <span class="block w-max mx-auto -mt-3 px-4 text-center text-gray-500 bg-secondary">Of</span>
      </div>

      <form action="#" method="POST" class="space-y-6 py-6">
        <div class=" flex w-full">
          <p class="mx-auto text-red-400 text-sm"><?php if (isset($error)) print $error["error"] ?></p>
        </div>

        <div>
          <input required type="email" name="email" autofocus placeholder="Vul je e-mail in" class="w-full py-3 px-6 ring-1 ring-gray-300 rounded-xl placeholder-gray-600 bg-transparent transition disabled:ring-gray-200 disabled:bg-gray-100 disabled:placeholder-gray-400 invalid:ring-red-400 focus:invalid:outline-none" onchange="validate()" oninvalid="validate()">
          <small id="emailErr" class="hidden"></small>
        </div>

        <div class="flex flex-col items-end">
          <input required type="password" name="password" placeholder="Wat is jou geheime woord?" class="w-full py-3 px-6 ring-1 ring-gray-300 rounded-xl placeholder-gray-600 bg-transparent transition disabled:ring-gray-200 disabled:bg-gray-100 disabled:placeholder-gray-400 invalid:ring-red-400 focus:invalid:outline-none">
          <button type="reset" class="w-max p-3 -mr-3">
            <span class="text-sm tracking-wide text-black">Wachtwoord vergeten?</span>
          </button>
        </div>

        <div>
          <button type="submit" name="submit" class="w-full px-6 py-3 rounded-xl bg-black transition">
            <span class="font-semibold text-white text-lg">Aanmelden</span>
          </button>
        </div>
      </form>

      <div class="border-t pt-12">
        <div class="space-y-2 text-center">
          <!-- Place svg object -->
          <object type="image/svg+xml" data="/assets/img/logo.svg" class="w-40 m-auto grayscale">
            MatseVH Logo
          </object>
          <span class="block text-sm tracking-wide text-gray-500">&copy; Copyright <?php print date("Y") ?> <br>Matse Van Horebeek</span>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function validate() {
    var emails = <?php print emails($db) ?>;
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    var email = document.getElementById("email").value;
    if (email == "") {
      document.getElementById("emailErr").innerHTML = "Vul een e-mailadres in";
      document.getElementById("emailErr").classList.remove("hidden");
      document.getElementById("email").classList.add("invalid");
    }
    if (!email.match(validRegex)) {
      document.getElementById("emailErr").innerHTML = "Vul een geldig e-mailadres in";
      document.getElementById("emailErr").classList.remove("hidden");
      document.getElementById("email").classList.add("invalid");
    }
    if (!emails.includes(email)) {
      document.getElementById("emailErr").innerHTML = "Dit e-mailadres is niet bekend";
      document.getElementById("emailErr").classList.remove("hidden");
      document.getElementById("email").classList.add("invalid");
    }
  }
</script>
</body>

</html>