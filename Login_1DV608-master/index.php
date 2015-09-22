<?php

//Start a session to know if user logged in
session_start();
//INCLUDE THE FILES NEEDED...
require_once('controller/ViewController.php');
$controller = new ViewController();
$controller->run();




