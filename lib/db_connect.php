<?php
    /*
        Connect to the application DB
    */
	$db = 'mums';
	$db_host = 'localhost';
	$db_pass = 'bharat';
        $db_user = 'root';

    try{
    $pdo = new PDO('mysql:host='.$db_host.';dbname='.$db, $db_user, $db_pass, array(
        PDO::ATTR_PERSISTENT => false
    ));
    }
    catch(PDOException $e){
	echo $e->getMessage();
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
