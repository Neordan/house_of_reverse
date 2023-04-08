<?php
require "./core/header.php";
//utilisation de phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

//récupération pour afficher le rdv validé par la cliente
if (isset($_POST['date-resa'])) {
    $date_resa = $_POST['date-resa'];
    $date = new DateTime($date_resa);
    $formattedDate = $date->format("d/m/Y H:i");

?>
    <h2>Votre rendez-vous</h2>
    <p>Date et heure du rendez-vous validé : <?= htmlspecialchars($formattedDate) ?></p>
    <p>Veuillez compléter les informations suivantes</p>
<?php
} else {
    echo "<p>Le rendez-vous n'a pas été pris</p>";
}
//récupération des variables de sessions
if (isset($_SESSION['utilisateur'])) {
    $prenom = $_SESSION['utilisateur']['prenom'];
    $nom = $_SESSION['utilisateur']['nom'];
    $email = $_SESSION['utilisateur']['email'];
}

if (isset($_POST['prestation']) && isset($_POST['precision'])) {
    $prestation = $_POST['prestation'];
    $precision = $_POST['precision'];

    $inspiration = $_FILES['inspiration'];
    $ongle_img = $_FILES['ongle-img'];

    // Envoyer un e-mail à l'administrateur
    $mail = new PHPMailer(true);
    try {
        // Configuration du serveur d'envoi
        // Utilisez vos propres informations d'authentification SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_username';
        $mail->Password = 'your_password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom('noreply@example.com', 'Your Name or Website');
        $mail->addAddress('admin@example.com');

        // Sujet et contenu
        $mail->isHTML(true);
        $mail->Subject = 'Nouvelle réservation';
        $mail->Body = "Nom: $prenom $nom<br>Email: $email<br>Date et heure du rendez-vous: $date_resa<br>Prestation: $prestation<br>Précisions: $precision";

        // Ajout des images en pièces jointes
        $mail->addAttachment($inspiration['tmp_name'], $inspiration['name']);
        $mail->addAttachment($ongle_img['tmp_name'], $ongle_img['name']);

        // Envoi de l'e-mail
        $mail->send();
        echo 'Le message a été envoyé.';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
    }

    // Envoyer un e-mail de confirmation à la cliente
    $mailClient = new PHPMailer(true);
    try {
        // Configuration du serveur d'envoi (identique à l'e-mail précédent)
        $mailClient->isSMTP();
        $mailClient->Host = 'smtp.example.com';
        $mailClient->SMTPAuth = true;
        $mailClient->Username = 'your_username';
        $mailClient->Password = 'your_password';
        $mailClient->SMTPSecure = 'tls';
        $mailClient->Port = 587;
   // Expéditeur et destinataire
    $mailClient->setFrom('noreply@example.com', 'Your Name or Website');
    $mailClient->addAddress($email);

    // Sujet et contenu
    $mailClient->isHTML(true);
    $mailClient->Subject = 'Confirmation de réservation';
    $mailClient->Body = "Bonjour $prenom $nom,<br><br>Votre rendez-vous a été confirmé pour le $date_resa. Voici les détails de votre réservation :<br><br>Prestation: $prestation<br><br>Merci de faire affaire avec nous. Nous avons hâte de vous voir !";

    // Envoi de l'e-mail
    $mailClient->send();
    echo 'Le message de confirmation a été envoyé à la cliente.';
} catch (Exception $e) {
    echo "Le message de confirmation n'a pas pu être envoyé. Erreur: {$mailClient->ErrorInfo}";
}
}

?>



<form action="" method="post">
    <div class="info">
        <label for="inspiration">Tes inspirations :</label>
        <input type="file" id="inspiration">
    </div>
    <div class="info">
        <label for="ongle-img">Tes ongles :</label>
        <input type="file" id="ongle-img">
    </div>

    <div class="info">
        <label for="prestation">Prestation souhaité :</label>
        <select name="prestation" id="prestation">
            <option value="">-- Sélectionner votre choix --</option>
            <option value="chablons">Pose de chablons</option>
            <option value="remplissage">Remplissage</option>
            <option value="gainage">Gainage</option>
            <option value="vsp">Vernis semi-permanent</option>
            <option value="reparation">Réparation</option>
        </select>
    </div>
    <div class="info">
        <label for="precision">Précisions:</label>
        <textarea name="precision" id="precision" rows="5" placeholder="Ton message .."></textarea>
    </div>
    <button>Envoyer</button>
</form>

<?php

require "./core/footer.php";

?>