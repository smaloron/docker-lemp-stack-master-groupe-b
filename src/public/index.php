<?php
// Démarrage de la session
session_start();


/*
* Connexion à la base de données
* depuis un fichier externe pour partager les infos de connexion
*/
require("include_database.php");

// Inclusion des fonction de traitement des tâches
require("../model/task-model.php");


// Récupération de toutes les tâches
$data = getAllTasks($pdo);

// Traitement du formulaire

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




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
</head>
<body>

    <?php if(array_key_exists("user", $_SESSION)): ?>
    <h2> 
        Bonjour <?= $_SESSION["user"] ?>
    </h2>
    <a href="logout.php">Déconnexion</a>
    <?php else : ?>
        <h2> Bonjour invité </h2>
        <a href="login.php">connexion</a>
    <?php endif ?>

    <h1>Liste des choses à faire</h1>
    Nous sommes le : 
    <?php
     echo date('d/m/Y');
    ?>

    <!-- Formulaire de saisie d'une tâche -->
    <form method="post">

    <input type="text" name="taskName">
    <button type="submit" name="newTask">Valider</button> 

    </form>


    <!-- Boucle sur le résultat de la requête pour afficher la liste des tâches -->
    <?php foreach($data as $line): ?>
        <div style="color:<?= $line["done"] == 1 ? "green": "red" ?>">
            <?php echo $line["task_name"] ?>
        </div>

    <?php endforeach ?>

</body>
</html>

