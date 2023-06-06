<?php


$page_title = "Rendez-vous";
require "../core/header.php";
require "../core/config.php";

// Traitement des dates de réservations
require "../dateProcessing.php";

$slots = ['10:00', '13:30', '16:30'];

// Obtention de la date de début de la semaine précédente
$debutSemainePrecedente = (new DateTime($calendrier["lundi"]->format("Y-m-d")))->modify("previous monday");

// Obtention de la date de début de la semaine suivante
$debutSemaineSuivante = (new DateTime($calendrier["dimanche"]->format("Y-m-d")))->modify("next monday");

if (isset($_POST['date-resa']) && !is_array($_POST['date-resa'])) {
    // Si la date et l'heure sont sélectionnées via le calendrier mobile, les découper en date et heure distinctes
    $_POST['date-resa'] = [substr($_POST['date-resa'], 0, 10), substr($_POST['date-resa'], 11)];
}

$errors = []; // Tableau pour stocker les erreurs

// Insertion d'une réservation
if (!empty($_POST)) {
    // Vérification des champs obligatoires
    if (isset($_POST["date-resa"]) && isset($_SESSION["utilisateur"]["id"]) && !empty($_POST['prestation']) && !empty($_FILES['inspiration']['name'])) {
        // Si la date et l'heure sont sélectionnées via le calendrier mobile, les utiliser
        if (is_array($_POST["date-resa"]) && count($_POST["date-resa"]) > 1) {
            $rdv = $_POST["date-resa"][0] . " " . $_POST["date-resa"][1];
        } else {
            $errors[] = "Veuillez sélectionner une date et une heure pour le rendez-vous.";
        }

        // Enregistrement du fichier d'inspiration
        if (!empty($_FILES['inspiration']['name'])) {
            $inspirationFileName = $_FILES['inspiration']['name'];
            $inspirationFilePath = "../assets/img/clients/" . $inspirationFileName;
            if (move_uploaded_file($_FILES['inspiration']['tmp_name'], $inspirationFilePath)) {
                $inspiration = "assets/img/clients/" . $inspirationFileName;
            } else {
                $errors[] = "Une erreur s'est produite lors de l'enregistrement du fichier d'inspiration.";
            }
        } else {
            $errors[] = "Veuillez sélectionner un fichier d'inspiration.";
        }

        // Enregistrement du fichier d'ongles actuels
        if (!empty($_FILES['ongle_actuel']['name'])) {
            $ongleActuelFileName = $_FILES['ongle_actuel']['name'];
            $ongleActuelFilePath = "../assets/img/clients/" . $ongleActuelFileName;
            if (move_uploaded_file($_FILES['ongle_actuel']['tmp_name'], $ongleActuelFilePath)) {
                $ongle_actuel = "assets/img/clients/" . $ongleActuelFileName;
            }
        }
        if (empty($errors)) {
            // Requête SQL pour l'insertion de la réservation
            $sql = "INSERT INTO rdv (id_utilisateur, jour_heure, inspiration, ongle_actuel, prestation, message) 
                VALUES (:id, :rdv, :inspiration, :ongle_actuel, :prestation, :message)";
            $id = $_SESSION["utilisateur"]["id"];
            $rdv = $_POST["date-resa"][0] . " " . $_POST["date-resa"][1];
            $prestation = $_POST["prestation"];
            $inspiration = "assets/img/clients/" . $inspirationFileName;

            // Préparation de la requête et exécution
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':rdv', $rdv);
            $stmt->bindParam(':inspiration', $inspiration);
            $stmt->bindParam(':ongle_actuel', $ongle_actuel);
            $stmt->bindParam(':prestation', $prestation);
            $stmt->bindParam(':message', $_POST["message"]);
            $stmt->execute();

            // Confirmation de la réservation
            header('Location: ./profil.php');
            exit;
        }
    } else {
        $errors[] = "Veuillez remplir tous les champs obligatoires.";
    }
}

// Récupération des prestations de la base de données (ENUM)

$sql = "SHOW COLUMNS FROM rdv WHERE Field = 'prestation';";
$stmt = $pdo->prepare($sql);
$stmt->execute();
// Récupérer les informations de la colonne 'prestation' sous forme de tableau associatif
$enum = $stmt->fetch(PDO::FETCH_ASSOC);

// Utiliser une expression régulière pour extraire les valeurs de l'ENUM
// Les valeurs se trouvent entre guillemets simples ('value')
// Les résultats sont stockés dans le tableau $matches
preg_match_all("/'(.*?)'/", $enum['Type'], $matches);

// Assigner les valeurs de l'ENUM extraites (situées dans $matches[1]) à la variable $prestations
$prestations = $matches[1];
?>

<h2>contact</h2>
<form class="contact" method="post" enctype="multipart/form-data">
    <!-- Affichage des erreurs -->
    <?php if (!empty($errors)) : ?>
        <div class="error-container">
            <ul class="error-list">
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <input type="hidden" name="id_utilisateur" value="<?= $_SESSION['utilisateur']['id'] ?>">
    <div class="mobile-calendar">
        <label class="labelMobile" for="mobile-date">Choisir la date :</label>
        <input type="date" name="date-resa[]" id="mobile-date">
        <label for="mobile-time">Choisir l'heure :</label>
        <select name="date-resa[]" id="mobile-time">
            <?php foreach ($slots as $slot) : ?>
                <option value="<?= $slot; ?>"><?= $slot; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="desktop-calendar">

        <!-- Navigation de l'agenda -->
        <div class="agenda-nav">
            <div class="previous">
                <a href="?start-date=<?= $debutSemainePrecedente->format("Y-m-d"); ?>">&lt;&lt; <?= $dateFormater->format($debutSemainePrecedente); ?></a>
            </div>
            <div class="current">
                <a href="?start-date=<?= (new DateTime())->format("Y-m-d"); ?>"><?= $dateFormater->format($startDate); ?></a>
            </div>
            <div class="next1">
                <a href="?start-date=<?= $debutSemaineSuivante->format("Y-m-d"); ?>"><?= $dateFormater->format($debutSemaineSuivante); ?> &gt;&gt;</a>
            </div>
        </div>

        <!-- En-têtes des jours -->
        <div class="agenda-header">
            <div class="hours-header">
                <!-- En-tête de la colonne des créneaux horaires -->
            </div>
            <?php foreach ($calendrier as $jour) :
                $jour->setTime(10, 0); ?>
                <div class="day">
                    <?= $dateFormater->format($jour); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="hr"></div>

        <!-- Corps de l'agenda -->
        <div class="agenda-body">
            <!-- Affichage des créneaux -->
            <?php foreach ($calendrier as $jour) : ?>
                <div class="slots">
                    <?php foreach ($slots as $slot) : ?>
                        <?php
                        // Configurer l'heure du jour en cours avec le créneau actuel
                        $jour->setTime(...explode(':', $slot));
                        ?>
                        <div class="slot">
                            <?php if ((new DateTime()) < $jour && $jour->format("w") != 0 && $jour->format("w") != 1) : ?>
                                <?php if (isset($_SESSION['utilisateur']["id"])) : ?>
                                    <?php
                                    // Recherche du rendez-vous pour le créneau actuel
                                    $sql = "SELECT * FROM rdv WHERE jour_heure=:rdv";
                                    $query = $pdo->prepare($sql);
                                    $rdv_time = $jour->format("Y-m-d H:i");
                                    $query->bindParam(":rdv", $rdv_time, PDO::PARAM_STR);
                                    $query->execute();
                                    $rdv = $query->fetch();

                                    // Remplir la variable de session 'rdv' avec les informations de rendez-vous
                                    if ($rdv) {
                                        $_SESSION['rdv'] = $rdv;
                                    }
                                    ?>
                                    <?php if ($rdv == null) : ?>
                                        <input type="radio" name="date-resa" value="<?= $jour->format("Y-m-d H:i"); ?>" id="slot-<?= $jour->format("Y-m-d-H-i"); ?>" class="slot-radio">
                                        <label for="slot-<?= $jour->format("Y-m-d-H-i"); ?>"><?= $jour->format("H:i"); ?></label>
                                    <?php else : ?>
                                        <button class="reserved">Reservé</button>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <button class="reserved">Reservé</button>
                                <?php endif; ?>
                            <?php else : ?>
                                <button class="reserved"></button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="info">
        <label for="inspiration">Tes inspirations : <span>*</span></label>
        <input type="file" name="inspiration" id="inspiration" require>
    </div>
    <div class="info">
        <label for="ongle_actuel">Tes ongles :</label>
        <input type="file" name="ongle_actuel" id="ongle_actuel">
    </div>
    <div class="info">
        <label for="prestation">Prestation souhaitée : <span>*</span></label>
        <select name="prestation" id="prestation">
            <option value="0">Sélectionner votre choix</option>
            <?php foreach ($prestations as $prestation) : ?>
                <option value="<?= $prestation; ?>"><?= $prestation; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="info">
        <label for="message">Précisions:</label>
        <textarea name="message" id="message" rows="5" placeholder="Ton message .."></textarea>
    </div>
    <button class="formulaire"><i class="fa-solid fa-check"></i></button>

    <?php

    require_once "../core/footer.php";
    ?>