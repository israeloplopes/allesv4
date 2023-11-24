<?php

session_start();
session_unset();
session_destroy();
header('location: pages/samples/login.php');
?>