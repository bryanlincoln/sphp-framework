<?php
include_once "definitions.php";
include_once "database.php";

function user_get($id) {
    $db_user = db_select("users", array("*"), "id=".$id)->fetch_assoc();
    return $db_user;
}

function user_register($email, $password) {
    if(db_insert(
        "users",
        array("email", "password"),
        array($email, password_hash(base64_encode($password), PASSWORD_DEFAULT))
    )) {
        return true;
    }
    return false;
}

function user_login($email, $password) {
    $password = base64_encode($password);

    // pega usuário
    $user = db_select("users", array("id", "password"), "email=\"" . $email . "\"")->fetch_assoc();
    if($user) { // se o usuário existe
        if(password_verify($password, $user["password"])) { // se as senhas batem
            // pega todos os dados do usuário
            $user = db_select("users", array("*"), "id=" . $user["id"])->fetch_assoc();

            // inicia a sessão
            $_SESSION["id"]           = $user["id"];
            $_SESSION["email"]        = $user["email"];
            $_SESSION["date_created"]        = $user["date_created"];

            return true;
        }
    }

    // algo deu errado
    return false;
}

function user_logout() {
    // desfaz todos os valores da sessão
    $_SESSION = array();

    // obtém os parâmetros da sessão
    $params = session_get_cookie_params();

    // Deleta o cookie em uso.
    setcookie(session_name(),
        '', time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]);

    // Destrói a sessão
    session_destroy();
}