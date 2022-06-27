<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/includes/_header.php"; ?>

<?php
if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  user_password_send($db, $email);
}
?>

<div class="2xl:container h-screen m-auto font-source-code-pro">
  <div hidden class="fixed inset-0 w-7/12 lg:block">
    <img class="w-full h-full object-cover" src="/assets/img/signin.webp" alt="Sign in screen image">
  </div>
  <div hidden role="hidden" class="fixed inset-0 w-6/12 ml-auto bg-secondary bg-opacity-100 backdrop-blur-3xl lg:block"></div>
  <div class="relative h-full ml-auto lg:w-6/12">
    <div class="m-auto py-12 px-6 sm:p-20 xl:w-10/12">
      <div class="space-y-4">
        <p class="text-2xl text-gray-600 font-bold">Wachtwoord vergeten</p>
      </div>

      <form method="POST" class="space-y-6 py-6 mt-12">
        <div class=" flex w-full">
          <p class="mx-auto text-red-400 text-sm"><?php if (isset($error)) print $error["error"] ?></p>
        </div>

        <div class="w-full">
          <small id="emailErr" class="hidden mx-auto text-red-400"></small>
        </div>
        <div class="flex flex-col items-end">
          <input required type="email" name="email" id="email" onchange="validate()" onmousedown="validate()" autofocus placeholder="Vul je e-mail in..." class="w-full py-3 px-6 ring-1 ring-gray-300 rounded-xl placeholder-gray-600 bg-transparent transition disabled:ring-gray-200 disabled:bg-gray-100 disabled:placeholder-gray-400 invalid:ring-red-400 focus:invalid:outline-none">
          <a href="/login" class="w-max p-3 -mr-3">
            <span class="text-sm tracking-wide text-black">Terug naar inloggen</span>
          </a>
        </div>

        <div>
          <button type="submit" disabled name="submit" id="submit" class="w-full px-6 py-3 rounded-xl bg-black transition">
            <span class="font-semibold text-white text-lg">Resetten</span>
          </button>
        </div>
      </form>

      <div class="border-t pt-12">
        <div class="space-y-2 text-center">
          <!-- Place svg object -->
          <object type="image/svg+xml" data="/assets/img/logo.svg" class="w-40 m-auto grayscale" aria-label="MatseVH Logo">
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
    var emails = <?php print json_encode(emails($db)) ?>;
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    var email = document.getElementById("email").value;
    if (email == "") {
      document.getElementById("emailErr").innerHTML = "Vul een e-mailadres in";
      document.getElementById("emailErr").classList.remove("hidden");
      document.getElementById("email").classList.add("invalid");
      document.getElementById("submit").disabled = true;
    } else
    if (!email.match(validRegex)) {
      document.getElementById("emailErr").innerHTML = "Vul een geldig e-mailadres in";
      document.getElementById("emailErr").classList.remove("hidden");
      document.getElementById("email").classList.add("invalid");
      document.getElementById("submit").disabled = true;
    } else
    if (!emails.includes(email)) {
      document.getElementById("emailErr").innerHTML = "Dit e-mailadres is niet bekend";
      document.getElementById("emailErr").classList.remove("hidden");
      document.getElementById("email").classList.add("invalid");
      document.getElementById("submit").disabled = true;
    } else {
      document.getElementById("emailErr").classList.add("hidden");
      document.getElementById("email").classList.remove("invalid");
      document.getElementById("submit").disabled = false;
    }
  }
</script>
</body>

</html>