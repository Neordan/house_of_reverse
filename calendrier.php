<?php
require "./core/header.php";
require "./core/config.php";
require "./date_formater.php";

// Traitement des dates de réservations
require "./date_processing.php";

$debutSemainePrecedente = (new DateTime($calendrier["lundi"]->format("Y-m-d")))->modify("previous monday");
$debutSemaineSuivante = (new DateTime($calendrier["dimanche"]->format("Y-m-d")))->modify("next monday");

// Insertion d'une réservation
if (isset($_POST["date-resa"]) && isset($_SESSION["utilisateur"]["id"])) {
    // Requête SQL
    $sql = "INSERT INTO rdv (id_utilisateur, jour_heure) VALUES (:id, :rdv)";
    $id = $_SESSION["utilisateur"]["id"];
    $rdv = $_POST["date-resa"];

    // Préparation et exécution de la requête
    $query = $pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_STR);
    $query->bindParam(":rdv", $rdv, PDO::PARAM_STR);
    $query->execute();
}

?>
<h2>contact</h2>
<form action="./index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_utilisateur" value="<?php $_SESSION['utilisateur']['id'] ?>">
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
            <!-- Affichage des heures -->
            <div class="hours">
                <?php
                $hour = new DateTime($calendrier["lundi"]->format("Y-m-d H:i"));
                for ($i = 0; $i < 5; $i++) : ?>
                    <div class="hour">
                        <?= $hour->format("H:i"); ?>
                    </div>
                    <?php $hour->modify("+120 minute"); ?>
                <?php endfor;
                $hour->setTime(10, 0); ?>
            </div>

            <!-- Affichage des créneaux -->
            <?php foreach ($calendrier as $jour) : ?>
                <div class="slots">
                    <?php $jour->setTime(10, 0); ?>
                    <?php for ($i = 0; $i < 5; $i++) : ?>
                        <div class="slot">
                            <?php if ((new DateTime()) < $jour) : ?>
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
                                        <form action="" method="post">
                                            <input type="hidden" name="date-resa" value="<?= $jour->format("Y-m-d H:i"); ?>">
                                            <button>Réserver pour <?= $jour->format("H:i"); ?></button>
                                        </form>
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
                        <?php $jour->modify("+120 minutes"); ?>
                    <?php endfor; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</form>
<?php
require "./core/footer.php";
?>