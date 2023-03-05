<?php
if (
    isset($_POST["email"]) && $_POST["email"] != "" &&
    isset($_POST["pwd"]) && $_POST["pwd"] != ""
) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["pwd"]);
    var_dump($email);
    var_dump($password);

    try {
        require_once "core/config.php";
        $db = new PDO($dsn, $dbuser, $dbpassword);
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $query = $db->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $query->fetch();
        if ($user && password_verify($password, $user['pwd'])) {
            // Connexion réussie
            echo "Bienvenue House of reverse";
        } else {
            // Mot de passe ou email incorrect
            echo "Mot de passe ou email incorrect";
        }
    } catch (Exception | PDOException | Error $e) {
        echo $e->getMessage();
        $message = "<p>Une erreur s'est produite</p>";
    }
}
?>
<div class="login">
    <i class="fa-solid fa-xmark close-admin"></i>
    <div class="formulaire">
        <p>Connexion réservée à l'administrateur</p>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="Mot de passe">
            <a href="">Mot de passe oublié ?</a>
            <button><i class="fa-solid fa-unlock"></i></button>
        </form>
    </div>
</div>
