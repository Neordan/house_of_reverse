<?php
session_start();
// Fuseau horaire par défaut du serveur
date_default_timezone_set("Europe/Paris");
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House of reverse</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../script/script.js" defer></script>
</head>
<body>

    <!------ Partie du header ------->

    <header>
        <div class="menu">
        <?php if(isset($_SESSION['utilisateur']))  {  ?>
            <a class="logout" href='./logout.php'>Déconnexion</a>
                 <?php } else { ?>
                    <a href='../login.php'><i class='fa-solid fa-user'></i></a> 
                <?php } ?>
        
        <div class="menu-toggle">
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
        </div>
        <nav id="navigation">
            <i class="fa-solid fa-xmark close-menu"></i>
            <ul>
                <li><a href="./prestations.php">Prestations</a></li>
                <li><a href="./galerie.php">Galerie</a></li>
                <li><a href="./tarifs.php">Tarifs</a></li>
                <?php if(!empty($_SESSION['utilisateur'])) {  ?>
                    <li><a href='./profil.php'>Profil</a></li>
                    <li><a href='./contact.php'>Rendez-vous</a></li>
                 <?php } ?>
            </ul>
            <a href="./index.php"><i class="fa-solid fa-house"></i></a>
        </nav>
        </div>
        <div class="logo">
            <h1>house of reverse</h1>
            <img src="./assets/img/Logo1.PNG" alt="Logo de House of reverse">
        </div>
    </header>
    <main>