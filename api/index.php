<?php
// --- LIBRARIES
include_once "definitions.php";
include_once "database.php";
include_once "users.php";


// --- INTERFACE

// user

if(isset($_GET["register"])) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    if(user_register($email, $password)) {
        continue_request(BASE_URL, "msg=User successfully registered!");
    } else {
        continue_request(BACK_RESPONSE, "err=An error ocurred.");
    }
}
else if(isset($_GET["login"])) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    if(user_login($email, $password)) {
        continue_request(BASE_URL, "msg=Welcome!");
    } else {
        continue_request(BACK_RESPONSE, "err=An error ocurred.");
    }
}
else if(isset($_GET["logout"])) {
    user_logout();
    continue_request(BACK_RESPONSE, "msg=Bye.");
}

else {
    continue_request(BACK_RESPONSE, "err=Invalid request.");
}