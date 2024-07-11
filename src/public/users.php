<?php
/*
* Connexion à la base de données
* depuis un fichier externe pour partager les infos de connexion
*/
require("include_database.php");


// Traitement du formulaire

// on test si le formulaire a été posté
$isPosted = filter_has_var(INPUT_POST, "newUser");


if($isPosted){
    // Récupération et validation de la saisie
    $userName = filter_input(INPUT_POST, "userName");
    $userPassword = filter_input(INPUT_POST, "userPassword");

    // Validation de la saisie
    // Le nom d'utilisateur et le mot de passe sont requis
    $isFormValid = ! empty($userName) && ! empty ($userPassword);

    if($isFormValid){
        // Hashage du mot de passe
        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        // Enregistrement de la saisie dans la base de données
        $sql = "INSERT INTO users (user_name, user_password) VALUES (?,?)";
        $query = $pdo->prepare($sql);
        $query->execute([$userName, $hashedPassword]);
        // Redirection vers la page user pour ne plus poster les données
        header("location:users.php");
        exit;
    } else {
        // Affichage d'une erreur en cas de mauvaise saisie
        echo "Vous devez saisir toutes les infos utilisateur";
    }

}

// Exécution d'une requête SQL
$query = $pdo->query("SELECT * FROM users");
// Extraction des données depuis la requête
$data = $query->fetchAll();
// Affichage des données pour test
//var_dump($data);



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    

    <!-- Formulaire de saisie d'une tâche -->
    <form method="post">

    <input type="text" name="userName" placeholder="votre nom d'utilisateur">
    <input type="text" name="userPassword" placeholder="votre mot de passe">
    <button type="submit" name="newUser">Valider</button> 

    </form>


    <!-- Boucle sur le résultat de la requête pour afficher la liste des tâches -->
    <?php foreach($data as $line): ?>
        <div>
            <?php echo $line["user_name"] ?>
        </div>

    <?php endforeach ?>

</body>
</html>

