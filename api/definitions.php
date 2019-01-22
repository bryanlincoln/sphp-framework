<?php

// TODO replace <CHG HERE> with correct data

date_default_timezone_set('America/Sao_Paulo');

// --- DEFINITIONS
define("DB_LOCAL_HOST", "localhost");
define("DB_LOCAL_USER", "root");
define("DB_LOCAL_PASS", "senha");
define("DB_LOCAL_DB", "sphp");

define("DB_REMOTE_HOST", "<CHG HERE>");
define("DB_REMOTE_USER", "<CHG HERE>");
define("DB_REMOTE_PASS", "<CHG HERE>");
define("DB_REMOTE_DB", "<CHG HERE>");

define("API_URL", "api");
if(in_array($_SERVER['HTTP_HOST'], array('localhost', "::1"))) {
    define("LOCAL", true);
    define("BASE_URL", "http://localhost/sphp-framework");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    define("LOCAL", false);
    define("BASE_URL", "http://<CHG HERE>");

    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
define("DEFAULT_RESPONSE", BASE_URL);

$this_page = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$this_page = remove_var_url($this_page, "msg");
$this_page = remove_var_url($this_page, "err");
$this_page = urlencode($this_page);
define("THIS_PAGE", $this_page);
$referer = isset($_SERVER['HTTP_REFERER']) ? (strpos($_SERVER['HTTP_REFERER'], API_URL) !== false ? DEFAULT_RESPONSE : $_SERVER['HTTP_REFERER']) : DEFAULT_RESPONSE;
$referer = remove_var_url($referer, "msg");
$referer = remove_var_url($referer, "err");
define("BACK_RESPONSE", $referer);
define("DEFAULT_LOGGED", BASE_URL . "/dashboard");


// --- FUNÇÕES GLOBAIS
// remove uma mensagem da url
function remove_var_url($url, $varname) {
    return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
}
// insere uma mensagem numa url
function fit_var_url($url, $data) {
    if(strpos($url, "?") !== false) {
        if(explode("?", $url)[1] == "")
            $url .= $data;
        else {
            if(strpos($url, "&") !== false)
                if(explode("&", $url)[1] == "")
                    $url .= $data;
                else
                    $url .= "&" . $data;
            else
                $url .= "&" . $data;
        }
    } else {
        $url .= "?" . $data;
    }
    return $url;
}
// redireciona ou responde após uma requisição
function continue_request($to = DEFAULT_RESPONSE, $data = "") {
    global $requested;

    if($requested) {
        // esta função já foi chamada, não modifique os headers
        return;
    }

    // verifica o tipo de resposta e prepara
    if(strpos($data, 'err') === false) {
        if(isset($_POST['continue'])) {
            $response = $_POST['continue'];
        } else if(isset($_GET['continue'])) {
            $response = $_GET['continue'];
        } else {
            $response = $to;
        }
    } else {
        $response = $to;
    }

    // compila a url
    if(!empty($response))
        $response = urldecode($response);

    // coloca os dados
    if(!empty($data))
        $response = fit_var_url($response, $data);

    // responde em texto
    if(isset($_GET['ajax']) || isset($_POST['ajax'])) {
        echo $response;
    }
    // responde em redirecionamento
    else {
        header("Location: " . $response);
    }
    exit();
}


// --- LIBRARIES
include_once "database.php";


// --- SYSTEM SETTINGS
global $db;
$db = db_connect();

session_start();

// verifica se o usuário está logado
define("LOGGED_IN", isset($_SESSION["id"]));