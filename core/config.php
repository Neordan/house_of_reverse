<?php 
//informations de connexion
    $dbhost = trim("localhost");
    $dbport = trim("3306");
    $dbname = trim("houseofreverse");

    $dbuser = "root";
    $dbpassword = "";

    // DATA SOURCE NAME
    $dsn = "mysql:host=$dbhost; port=$dbport; dbname=$dbname; charset=utf8";

    $pdo = new PDO($dsn, $dbuser, $dbpassword);

    