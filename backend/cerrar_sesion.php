<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');
session_destroy();

header("Location: ../1Inisiodesesion.html");
exit();

?>
