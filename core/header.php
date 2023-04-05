<?php

session_start();
// Vérifie si les champs email et mot_de_passe sont définis et non vides
if (isset($_POST["email"]) && $_POST["email"] != "" && 
isset($_POST["hash_mdp"]) && $_POST["hash_mdp"] != "") {
    // Récupère les valeurs des champs email et mot_de_passe et supprime les espaces en début et fin de chaîne
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["mot_de_passe"]));

    try {
        // Charge la configuration de la base de données
        require_once "./core/config.php";
        // Prépare la requête SQL pour récupérer l'utilisateur correspondant à l'email fourni
        $sql = "SELECT * FROM utilisateur WHERE email LIKE :email";
        $query = $pdo->prepare($sql);
        
        $query->bindParam(':email', $email);
        // Exécute la requête
        $query->execute();
        // Récupère la première ligne du résultat de la requête
        $user = $query->fetch();
        // Vérifie si l'utilisateur existe et si le mot de passe fourni est correct
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'utilisateur';
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['age'] = $user['nom'];
            $_SESSION['allergie'] = $user['allergie'];
            // Connexion réussie
            if ($_SESSION[$role] = "admin") {
                header ("location: ./fichierclient.php");
            } else {
                header ("location: ./profil.php");
            }

        } else {
            // Mot de passe ou email incorrect
            $default = "Mot de passe ou email incorrect";
        }
    } catch (Exception | PDOException | Error $e) {
        // En cas d'erreur, affiche le message d'erreur
        $message = "Une erreur s'est produite : " . $e->getMessage();
    }
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House of reverse</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../script/script.js" defer></script>
</head>

<body>


    <!------ Partie du header ------->

    <header>
        <i class="fa-solid fa-user"></i>
        <div class="login">
            <i class="fa-solid fa-xmark close-admin"></i>
            <div class="formulairelog">
                <p>Connexion réservée à l'administrateur</p>
                <form method="post">
                    <input type="email" name="email" placeholder="Email">
                    <!-- <input type="hidden" name="role" value="admin"> -->
                    <input type="password" name="mot_de_passe" placeholder="Mot de passe">
                    <a href="">Mot de passe oublié ?</a>
                    <a href="">S'inscrire</a>
                    <button><i class="fa-solid fa-unlock"></i></button>
                </form>
            </div>
        </div>
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
                <li><a href="./contact.php">Rendez-vous</a></li>
            </ul>
            <a href="./index.php"><i class="fa-solid fa-house"></i></a>
        </nav>
    </header>
    <div class="logo">
        <h1>house of reverse</h1>
        <img src="./assets/img/Logo1.PNG" alt="Logo de House of reverse">
    </div>
    <main>