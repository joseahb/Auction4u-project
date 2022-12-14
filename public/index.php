<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

session_start();
// Session lifetime in seconds
$inactividad = 300;
if (isset($_SESSION["timeout"])){
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactividad) {
        session_destroy();
        header("Location: /");
    }
}
// Start timeout for later check
$_SESSION["timeout"] = time();

// Start the backend
require __DIR__ . "/../src/app.php";
