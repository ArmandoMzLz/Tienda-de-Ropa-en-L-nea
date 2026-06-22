<?php
require_once dirname(__DIR__) . '/bootstrap.php';

$_SESSION = [];
session_destroy();

header('Location: /view/loginRegister.php');
exit;