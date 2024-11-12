<?php 

session_start();
session_unset();
session_destroy();
header("Location: http://midterm-exam-liwanag.test/root/");
exit();

?>