<?php
require "./core/header.php";
require "./core/config.php";
require "./date_formater.php";

// Traitement des dates de réservations
require "./date_processing.php";

$debutSemainePrecedente = (new DateTime($calendrier["lundi"]->format("Y-m-d")))->modify("previous monday");
$debutSemaineSuivante = (new DateTime($calendrier["dimanche"]->format("Y-m-d")))->modify("next monday");

// Insertion d'une réservation
if (!empty($_POST)) {
    // Vérification des champs obligatoires
    if (isset($_POST["date-resa"]) && isset($_SESSION["utilisateur"]["id"]) && !empty($_POST['prestation'])) {
        // Requête SQL
        $sql = "INSERT INTO rdv (id_utilisateur, jour_heure, inspiration, ongle_actuel, prestation, message) 
                VALUES (:id, :rdv, :inspiration, :ongle_actuel, :prestation, :message)";
        $id = $_SESSION["utilisateur"]["id"];
        $rdv = $_POST["date-resa"];
        $prestation = $_POST["prestation"];
        $inspiration = !empty($_FILES['inspiration']['name']) ? "assets/img/clients/" . $_FILES['inspiration']['name'] : null;
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
                    // Rediriger vers la page d'accueil
                    header('Location: ./index.php');
                } else {
                    echo "Erreur 1.";
                }
                
            } else {
                echo "Une erreur 2";
            }
        }
    

// Récupération des prestations de la base de données (ENUM)
require "./core/config.php";
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
<input type="hidden" name="id_utilisateur" value="<?= $_SESSION['utilisateur']['id'] ?>">
<div class="agenda">

    <!-- Navigation de l'agenda -->
    <div class="agenda-nav">
        <div class="previous">
            <a href="?start-date=<?= $debutSemainePrecedente->format("Y-m-d"); ?>">&lt;&lt; <?= $dateFormater->format($debutSemainePrecedente); ?></a>
        </div>
        <div class="current">
            <a href="?start-date=<?= (new DateTime())->format("Y-m-d"); ?>"><?= $dateFormater->format($startDate); ?></a>
        </div>
        <div class="next">
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
                <?php
                // Définir les créneaux horaires souhaités
                $slots = ['10:00', '13:30', '16:30'];
                ?>
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
    <label for="inspiration">Tes inspirations :</label>
    <input type="file" name="inspiration" id="inspiration">
</div>
<div class="info">
    <label for="ongle_actuel">Tes ongles :</label>
    <input type="file" name="ongle_actuel" id="ongle_actuel">
</div>
<div class="info">
    <label for="prestation">Prestation souhaitée :</label>
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
<button type="submit">Envoyer</button>
