<!-- this an application entry point, it delegates requests to controller -->
<?php
include_once("Controller/UserController.php");
$controller = new UserController();
$controller->invoke();
?>