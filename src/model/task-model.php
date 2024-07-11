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


function handleTaskInsert(PDO $pdo){
    // on test si le formulaire a été posté
    $isPosted = filter_has_var(INPUT_POST, "newTask");
    if($isPosted){
        // Récupération et validation de la saisie
        $taskName = filter_input(INPUT_POST, "taskName");
        //var_dump($taskName);
        if(! empty($taskName)){
            // Enregistrement de la saisie dans la base de données
            $sql = "INSERT INTO tasks (task_name) VALUES (?)";
            $query = $pdo->prepare($sql);
            $query->execute([$taskName]);
            // Redirection vers la page index pour ne plus poster les données
            header("location:index.php");
            exit;
        } else {
            // Affichage d'une erreur en cas de mauvaise saisie
            echo "Vous devez saisir un tâche";
        }
    }
}