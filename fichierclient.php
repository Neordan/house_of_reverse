<?php

require "./core/header.php";

session_start();

//Autorisation à l'admin d'aaler au fichier client
if ($_SESSION[$role] = "admin") {
    header ("location: ./fichierclient.php");
} else {
    header ("location: ./index.php");
}