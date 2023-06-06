<?php

$page_title = "Rendez-vous";
require "../core/header.php";
require "../core/config.php";



// Traitement des dates de réservations
require "./dateProcessing.php";

$slots = ['10:00', '13:30', '16:30'];

$debutSemainePrecedente = (new DateTime($calendrier["lundi"]->format("Y-m-d")))->modify("previous monday");
$debutSemaineSuivante = (new DateTime($calendrier["dimanche"]->format("Y-m-d")))->modify("next monday");

if (isset($_POST['date-resa']) && !is_array($_POST['date-resa'])) {
    $_POST['date-resa'] = [substr($_POST['date-resa'], 0, 10), substr($_POST['date-resa'], 11)];
}

// Insertion d'une réservation
if (!empty($_POST)) {
    // Vérification des champs obligatoires
    if (isset($_POST["date-resa"]) && isset($_SESSION["utilisateur"]["id"]) && !empty($_POST['prestation']) && !empty($_FILES['inspiration']['name'])) {
        // Si la date et l'heure sont sélectionnées via le calendrier mobile, les utiliser
        if (is_array($_POST["date-resa"]) && count($_POST["date-resa"]) > 1) {
            $rdv = $_POST["date-resa"][0] . " " . $_POST["date-resa"][1];
        } else {
            echo "vous n'avez choisi qu'un seul champ";
        }
        // Requête SQL
        $sql = "INSERT INTO rdv (id_utilisateur, jour_heure, inspiration, ongle_actuel, prestation, message) 
                VALUES (:id, :rdv, :inspiration, :ongle_actuel, :prestation, :message)";
        $id = $_SESSION["utilisateur"]["id"];
        $rdv = $_POST["date-resa"][0] . " " . $_POST["date-resa"][1];
        $prestation = $_POST["prestation"];
        $inspiration = "assets/img/clients/" . $_FILES['inspiration']['name'];
        $ongle_actuel = !empty($_FILES['ongle_actuel']['name']) ? "assets/img/clients/" . $_FILES['ongle_actuel']['name'] : null;
        $message = !empty($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : null;

        // Préparation et exécution de la requête
        $query = $pdo->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_STR);
        $query->bindParam(":rdv", $rdv, PDO::PARAM_STR);
        $query->bindParam(":inspiration", $inspiration, PDO::PARAM_STR);
        $query->bindParam(":ongle_actuel", $ongle_actuel, PDO::PARAM_STR);
        $query->bindParam(":prestation", $prestation, PDO::PARAM_STR);
        $query->bindParam(":message", $message, PDO::PARAM_STR);

        if ($query->execute()) {
            $_SESSION['utilisateur']['id'] = $id;
            // Rediriger vers la page d'accueil
            $_SESSION['rdv']['jour_heure'] = $rdv;
            header('Location: ./profil.php');
        } else {
            echo "Erreur 1.";
        }
    } else {
        echo "Vous avez déjà pris rdv";
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

<h2>Rendez-vous</h2>
<form class="contact" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_utilisateur" value="<?= $_SESSION['utilisateur']['id'] ?>">
    
    <!-- Sélection de la date et de l'heure pour les appareils mobiles -->
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
    
    <div class="agenda">
        <!-- Navigation de l'agenda -->
        <div class="agenda-nav">
            <!-- Lien pour la semaine précédente -->
            <div class="previous">
                <a href="?start-date=<?= $debutSemainePrecedente->format("Y-m-d"); ?>">&lt;&lt; <?= $dateFormater->format($debutSemainePrecedente); ?></a>
            </div>
            <!-- Lien pour la semaine actuelle -->
            <div class="current">
                <a href="?start-date=<?= (new DateTime())->format("Y-m-d"); ?>"><?= $dateFormater->format($startDate); ?></a>
            </div>
            <!-- Lien pour la semaine suivante -->
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
                <!-- En-têtes des jours -->
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
                        <!-- Créneau horaire -->
                        <div class="slot">
                            <?php if ((new DateTime()) < $jour && $jour->format('Y-m-d') >= date("Y-m-d")) : ?>
                                <!-- Vérifier si le créneau est disponible -->
                                <input type="radio" name="date-resa[]" value="<?= $jour->format('Y-m-d') . ' ' . $slot; ?>">
                            <?php endif; ?>
                            <!-- Afficher l'heure du créneau -->
                            <span><?= $jour->format('H:i'); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Sélection de l'inspiration -->
    <div class="info">
        <label for="inspiration">Tes inspirations : <span>*</span></label>
        <input type="file" name="inspiration" id="inspiration" required>
    </div>
    
    <!-- Sélection de l'image des ongles actuels -->
    <div class="info">
        <label for="ongle_actuel">Tes ongles :</label>
        <input type="file" name="ongle_actuel" id="ongle_actuel">
    </div>
    
    <!-- Sélection de la prestation -->
    <div class="info">
        <label for="prestation">Prestation souhaitée : <span>*</span></label>
        <select name="prestation" id="prestation" required>
            <option value="0">Sélectionner votre choix</option>
            <?php foreach ($prestations as $prestation) : ?>
                <!-- Options pour les prestations -->
                <option value="<?= $prestation; ?>"><?= $prestation; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <!-- Champ pour les précisions -->
    <div class="info">
        <label for="message">Précisions:</label>
        <textarea name="message" id="message" rows="5" placeholder="Ton message .."></textarea>
    </div>
    
    <!-- Bouton de soumission -->
    <button class="formulaire"><i class="fa-solid fa-check"></i></button>
</form>


<?php 
require_once "../core/footer.php";
?>