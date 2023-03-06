<?php
session_start();
require_once('inc/php/core.php');
$mainCore = new mainCore();
require_once TS_CLASS.'c.util.php';
$util = new util();

//Clear Session
$_SESSION["member_id"] = "";
session_destroy();

// clear cookies
$util->clearAuthCookie();

header("Location: ./");
?>