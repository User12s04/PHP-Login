<?php
	date_default_timezone_set('Europe/London');

    $db = new PDO("sqlite:User_db.db");
    $db -> exec('create table users (id number, username varchar35, password varchar35, access number)');

    print ("Table users created");
   $res = $db -> query('select * from users');


    echo print_r($res);
 


	
?>