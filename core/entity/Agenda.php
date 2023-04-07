<?php

namespace core\entity;

use PDO;


class Agenda
{
    public array $lundi;
    public array $mardi;
    public array $mercredi;
    public array $jeudi;
    public array $vendredi;
    public array $samedi;
    public array $dimanche;

    public function __construct()
    {
        $lundi = [];
    }

    public static function TakeIt(string $daterdv)
    {
        // Connexion à la base de données
        require "./core/config.php";

        // requête SQL
        $sql = "SELECT * FROM rdv WHERE jour_heure=:date";


        // Préparer la requête
        $query = $lienDB->prepare($sql);

        // Liaison des paramètres de la requête préparée
        $query->bindParam(":date", $daterdv, PDO::PARAM_STR);

        // Exécution de la requête
        if ($query->execute()) {
            // traitement des résultats
            $results = $query->fetch();
            
            // var_dump($results);
            return $results;
        }
    }
}
