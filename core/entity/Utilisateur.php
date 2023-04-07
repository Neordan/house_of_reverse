<?php

namespace core\entity;

use PDOException;
use Exception;
use Error;
use PDO;

class Utilisateur
{
    private int $id;
    private string $role;
    private string $nom;
    private string $age;
    private string $allergies;
    private string $ongles_ronges;
    private string $email;
    private string $hash_mdp;

    /** Contrustructeur */
    public function __construct($id = 0, $role = "", $nom = "", $prenom = "", $age = "", $allergies = "", $ongles_ronges = "", $email = "", $hash_mdp = "")
    {
        $this->id = $id;
        $this->role = $role;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->allergies = $allergies;
        $this->ongles_ronges = $ongles_ronges;
        $this->email = $email;
        $this->hash_mdp = $hash_mdp;
    }

    /** Accesseurs */

    /** Setter */
    public function __set($propriete, $valeur)
    {
        $this->$propriete = $valeur;
    }

    /** Getter */
    public function __get($propriete)
    {
        return $this->$propriete;
    }

    public function findByPseudo(string $pseudo): Utilisateur
    {
        try {
        } catch (PDOException | Exception | Error $e) {
        }

        return new Utilisateur();
    }

    public function findById(int $id): Utilisateur
    {
        return new Utilisateur();
    }

    public static function IsAdmin(string $email)
    {
        // Connexion à la base de données
        require "./core/config.php";

        // requête SQL
        $sql = "SELECT admin FROM utilisateurs WHERE email=:email";


        // Préparer la requête
        $query = $pdo->prepare($sql);

        // Liaison des paramètres de la requête préparée
        $query->bindParam(":email", $email, PDO::PARAM_STR);

        // Exécution de la requête
        if ($query->execute()) {
            // traitement des résultats
            $results = $query->fetch();

            // var_dump($results);
            return $results["admin"];
        }
    }

    public static function AllInfos(string $email)
    {
        // Connexion à la base de données
        require "./core/config.php";

        // requête SQL
        $sql = "SELECT * FROM utilisateur WHERE email=:email";


        // Préparer la requête
        $query = $pdo->prepare($sql);

        // Liaison des paramètres de la requête préparée
        $query->bindParam(":email", $email, PDO::PARAM_STR);

        // Exécution de la requête
        if ($query->execute()) {
            // traitement des résultats
            $results = $query->fetch();

            // var_dump($results);
            return $results;
        }
    }
}