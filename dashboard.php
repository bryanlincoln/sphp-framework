<?php
// definições desta página
define("URL_PREFIX", "");
define("PAGE_TITLE", "Dashboard");
define("NO_INDEX", true);

// bibliotecas
include_once "api/definitions.php";

// verificações
if(!LOGGED_IN) {
    continue_request(DEFAULT_RESPONSE, "err=Poucos privilégios!");
}

// views
include_once "views/default/head.php";
include_once "views/default/header.php";
?>

<div class="container">
    <h1>Dashboard</h1>

    <p>Your email: <?php echo $_SESSION["email"]; ?></p>
</div>

<?php
include_once "views/default/footer.php";