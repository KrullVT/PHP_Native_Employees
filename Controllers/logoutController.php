<?php

define('BASE_PATH', dirname(__DIR__, 2));

session_start();
session_destroy();
header("Location: " . BASE_PATH . "index.php");
exit();
