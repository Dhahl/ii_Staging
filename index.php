<?php

define('DACCESS',1);
//session_save_path("tmp"); //activate for dev.irisihinterest.ie!!
session_start();
require 'framework.php';
/*    	var_dump($_GET);
    	var_dumP($_POST);
    	var_dump($_REQUEST);
*/
//echo "framework<br />";
//echo "application<br />";
$app = new Application();


//var_dump($app);
//echo "route<br />";
$app->route();


//var_dump($app);
//echo "dispatch<br />";
$app->dispatch();

//var_dump($app);

$app->render();

//echo "render<br />";
//var_dump($app);

?>