<?php
session_start();
session_unset();
session_destroy();
setcookie("auth", "", time() - 3600); // remove cookie

header("Location: login.html");
exit;
?>
