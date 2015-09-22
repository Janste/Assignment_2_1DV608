<?php
// We turn on PHP output buffering feature
ob_start();

include_once("controller/Controller.php");

// Run the controller
$controller = new Controller();
$controller->run();




