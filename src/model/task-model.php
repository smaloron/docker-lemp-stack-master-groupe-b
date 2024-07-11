<?php

/** 
 * Requête sur la base de donnée pour récupérer l'ensemble des tâches
 * Arguments
 * $pdo : une instance de PDO
 * 
 * return array : un tableau ordinal de tableaux associatifs 
 * représentant le résultat de la requête
*/
function getAllTasks(PDO $pdo): array{
    // Exécution d'une requête SQL
    $query = $pdo->query("SELECT * FROM tasks");
    // Extraction des données depuis la requête
    return $query->fetchAll(PDO::FETCH_ASSOC);
}