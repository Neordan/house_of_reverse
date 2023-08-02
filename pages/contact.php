<?php
$page_title = "Rendez-vous";
require "../core/header.php";
require "../core/config.php";
require "../actions/function.php";

// Vérification du rôle de l'utilisateur, si ce n'est ni "admin" ni "utilisateur", redirection vers la page index.php
if ($_SESSION['utilisateur']['role'] !== "admin" && $_SESSION['utilisateur']['role'] !== "utilisateur") {
    header('Location: ../index.php');
    exit;
}

// Traitement des dates de réservations
require "../actions/dateProcessing.php";

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
    if (isset($_POST["date-resa"]) && isset($_SESSION["utilisateur"]["id"]) && !empty($_POST['prestations']) && !empty($_FILES['inspiration']['name'])) {
        // Si la date et l'heure sont sélectionnées via le calendrier mobile, les utiliser
        if (is_array($_POST["date-resa"]) && count($_POST["date-resa"]) > 1) {
            $rdv = $_POST["date-resa"][0] . " " . $_POST["date-resa"][1];
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
        $ongle_actuel = ""; // Initialiser la variable $ongle_actuel
        if (!empty($_FILES['ongle_actuel']['name'])) {
            $ongleActuelFileName = $_FILES['ongle_actuel']['name'];
            $ongleActuelFilePath = "../assets/img/clients/" . $ongleActuelFileName;
            if (move_uploaded_file($_FILES['ongle_actuel']['tmp_name'], $ongleActuelFilePath)) {
                $ongle_actuel = "assets/img/clients/" . $ongleActuelFileName;
            }
        }

        if (empty($errors)) {
            // Récupérer la valeur du checkbox "Pédicure"
            $pedicure = isset($_POST['pedicure']) ? 1 : 0;

            // Requête SQL pour l'insertion de la réservation
            $sql = "INSERT INTO rdv (id_utilisateur, jour_heure, inspiration, ongle_actuel, prestation, pedicure, message) 
   VALUES (:id, :rdv, :inspiration, :ongle_actuel, :prestation, :pedicure, :message)";

            $id = $_SESSION["utilisateur"]["id"];
            $rdv = $_POST["date-resa"][0] . " " . $_POST["date-resa"][1];
            $prestation = $_POST['prestations'];
            $inspiration = "assets/img/clients/" . $inspirationFileName;
            $message = $_POST["message"];

            // Préparation de la requête et exécution
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':rdv', $rdv);
            $stmt->bindParam(':inspiration', $inspiration);
            $stmt->bindParam(':ongle_actuel', $ongle_actuel);
            $stmt->bindParam(':prestation', $prestation);
            $stmt->bindParam(':pedicure', $pedicure);
            $stmt->bindParam(':message', $message);
            $stmt->execute();

            // Confirmation de la réservation
            // Mise à jour de la variable de session 'rdv'
            $_SESSION['rdv'] = [
                'jour_heure' => $rdv
            ];

            // Envoi de l'e-mail de confirmation à la cliente
            $to = $_SESSION['utilisateur']['email'];
            $subject = "Confirmation de ton rendez-vous";
            $message = "Hello " . $_SESSION['utilisateur']['prenom'] . ",\n\n";
            $message .= "Tu as pris rendez-vous pour le " . formatDateHeureEnFrancais($rdv) . ".\n";
            $message .= "pour la prestation suivante : " . $prestation;
            if ($pedicure == 1) {
                $message_admin .= " et pour une pédicure.\n";
            } else {
                $message_admin .= "\n";
            };
            $message .= "Afin de le valider n'oublie pas de régler   l'accompte de 10€ :
            https://www.paypal.me/prisciliadebas?locale.x=fr_FR\n";
            $message .= "Merci de me faire confiance ! À très vite :)\n";
            $headers = "From: House of Reverse <contact@houseofreverse.fr>\r\n";

            // Envoi de l'e-mail de confirmation à la cliente
            if (mail($to, $subject, $message, $headers)) {
                // L'e-mail a été envoyé avec succès
                echo "E-mail de confirmation envoyé à la cliente.";
            } else {
                // Une erreur s'est produite lors de l'envoi de l'e-mail
                echo "Erreur lors de l'envoi de l'e-mail de confirmation.";
            }

            $to_admin = "contact@houseofreverse.fr";
            $subject_admin = "Nouveau rendez-vous enregistré";
            $message_admin = "Un nouveau rendez-vous a été enregistré :\n";
            $message_admin .= "Nom de la cliente : " . $_SESSION['utilisateur']['nom'] . " " . $_SESSION['utilisateur']['prenom'] . "\n";
            $message_admin .= "Date et heure du rendez-vous : " . formatDateHeureEnFrancais($rdv) . "\n";
            $message_admin .= "Prestation : " . $prestation;
            
            // Ajout de l'information sur la pédicure si la valeur est égale à 1
            if ($pedicure == 1) {
                $message_admin .= " et pour une pédicure\n";
            } else {
                $message_admin .= "Pas de pédicure\n";
            }
            
            $message_admin .= "Message de la cliente : " . $message . "\n\n";
            
            $headers_admin = "From: House of reverse <contact@houseofreverse.fr>\r\n";
            

            // Envoi de l'e-mail de notification à l'administrateur
            if (mail($to_admin, $subject_admin, $message_admin, $headers_admin)) {
                // L'e-mail a été envoyé avec succès
                echo "E-mail de notification envoyé à l'administrateur.";
            } else {
                // Une erreur s'est produite lors de l'envoi de l'e-mail
                echo "Erreur lors de l'envoi de l'e-mail de notification à l'administrateur.";
            }

            $_SESSION['confirmation_message'] = "Votre rendez-vous a été enregistré avec succès. Un email de confirmation a été envoyé à votre adresse e-mail.";

            header('Location: ./profil.php');
            exit;
        } else {
            $errors[] = "Veuillez remplir tous les champs obligatoires.";
        }
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
        <label class="labelMobile" for="mobile-date">Choisir la date : <span>*</span></label>
        <input type="date" name="date-resa[]" id="mobile-date" require>
        <label for="mobile-time">Choisir l'heure :<span>*</span></label>
        <select name="date-resa[]" id="mobile-time" require>
            <option value="">---</option>
            <?php foreach ($slots as $slot) : ?>
                <option value="<?= $slot; ?>"><?= $slot; ?></option>
            <?php endforeach; ?>
        </select>
        <?php
        if (!empty($_POST)) : ?>
            <?php
            // Si les champs date et heure ne sont pas remplis, afficher un message d'erreur
            if (empty($_POST['date-resa'][0]) || empty($_POST['date-resa'][1])) : ?>
                <p class="error-container">Veuillez remplir les deux champs.</p>
            <?php endif; ?>
        <?php endif; ?>
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
        <label for="inspiration">Ton inspiration : <span>*</span></label>
        <input type="file" name="inspiration" id="inspiration" require>
    </div>
    <div class="info">
        <label for="ongle_actuel">Tes ongles actuels:</label>
        <input type="file" name="ongle_actuel" id="ongle_actuel">
    </div>
    <div class="info">
        <label for="prestation">Prestation souhaitée : <span>*</span></label>
        <select name="prestations" id="prestations">
            <option value="">---</option>
            <?php foreach ($prestations as $prestation) : ?>
                <option value="<?= $prestation; ?>"><?= $prestation; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="info">
        <label for="checkbox-pedicure">Pédicure :</label>
        <input type="checkbox" name="pedicure" value="Pédicure" id="checkbox-pedicure">
    </div>
    <div class="info">
        <label for="message">Précisions :</label>
        <textarea name="message" id="message" rows="5" placeholder="Ton message .."></textarea>
    </div>
    <button class="formulaire"><i class="fa-solid fa-check"></i></button>
</form>
<?php

require_once "../core/footer.php";
?>