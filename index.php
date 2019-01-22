<?php
// definições desta página
define("URL_PREFIX", "");
define("PAGE_TITLE", "");
define("NO_INDEX", false);

// bibliotecas
include_once "api/definitions.php";

// verificações
if(LOGGED_IN) {
    continue_request(DEFAULT_LOGGED);
}

// views
include_once "views/default/head.php";
include_once "views/default/header.php";
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <h1 class="panel-heading">Login</h1>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="<?php echo URL_PREFIX; ?>api/?login">

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label pl-0">Email</label>

                                <div class="col-md-6 pl-0">
                                    <input id="email" type="text" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label pl-0">Password</label>

                                <div class="col-md-6 pl-0">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 pl-0">
                                    <input type="submit" class="btn btn-primary" value="Sign in!">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include_once "views/default/footer.php";