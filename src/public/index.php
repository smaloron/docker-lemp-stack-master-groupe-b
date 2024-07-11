<?php
// Démarrage de la session
session_start();


// vérification si l'utilisateur est connecté
if(! isset($_SESSION["userId"])){
    header("location:login.php");
    exit;
}

/*
* Connexion à la base de données
* depuis un fichier externe pour partager les infos de connexion
*/
require("../model/database.php");

// Inclusion des fonction de traitement des tâches
require("../model/task-model.php");

// Récupération d'une instance de PDO
$pdo = getPDO();

// Traitement du formulaire pour l'insertion de tâche
handleTaskInsert($pdo);

// Récupération de toutes les tâches
$data = getAllTasks($pdo);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>

    <script>
        // Attend le chargement de la page
        window.onload = function(){
            // Sélection de toutes les cases à cocher
            const checkboxes = document.querySelectorAll(".task input");
            for(let item of checkboxes){
                item.addEventListener("change", function(ev){
                    // Définition de l'url pour la modification
                    let url = "update-task-status.php";
                    url += "?id=" + ev.target.value;
                    url += "&done=" + ev.target.checked;
                    // Envoi de la requête
                    fetch(url)
                        .then( res => res.text().then(text=> console.log(text)))
                        .catch( err => alert('Impossible de réaliser cette opération'));
                });
            }
        };
    </script>
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
        <div class="task" style="color:<?= $line["done"] == 1 ? "green": "red" ?>">
            <input 
                type="checkbox" 
                <?= $line["done"]==1?"checked":""  ?>
                value="<?= $line["id"] ?>"
            >
            <?php echo $line["task_name"] ?>
            
        </div>
        

    <?php endforeach ?>

</body>
</html>

