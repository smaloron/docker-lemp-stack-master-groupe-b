<?php
// lancement de la session
session_start();

/*
* Connexion à la base de données
* depuis un fichier externe pour partager les infos de connexion
*/
require("../model/database.php");
$pdo = getPDO();


// Traitement du formulaire

// on test si le formulaire a été posté
$isPosted = filter_has_var(INPUT_POST, "loginButton");


if($isPosted){
    // Récupération et validation de la saisie
    $userName = filter_input(INPUT_POST, "userName");
    $userPassword = filter_input(INPUT_POST, "userPassword");

    // Validation de la saisie
    // Le nom d'utilisateur et le mot de passe sont requis
    $isFormValid = ! empty($userName) && ! empty ($userPassword);

    if($isFormValid){
        // Recherche de l'utilisateur dans la base de données
        $sql = "SELECT id, user_password FROM users WHERE user_name= ?";
        $query = $pdo->prepare($sql);
        $query->execute([$userName]);
        $data = $query->fetch();

        $userFound = $query->rowCount() >0;

        if($userFound){
            $isPasswordOk = password_verify($userPassword, $data["user_password"]);

            if($isPasswordOk){
                // Stockage de l'utilisateur dans la session
                $_SESSION["user"] = $userName;
                $_SESSION["userId"] = $data["id"];
                // Redirection vers la page d'accueil lorsque on et authentifié
                header("location:index.php");
                exit;
            } else {
                echo "infos de connexion invalide";
            }
        } else {
            echo "infos de connexion invalide";
        }
    } else {
        echo "Saisie invalide";
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo list</title>
</head>
<body>
    <h1>Authentification</h1>

    <form method="post">
        <label>Nom d'utillisateur</label>
        <input type="text" name="userName">
        <label>Mot de passe</label>
        <input type="password" name="userPassword">
        <button type="submit" name="loginButton">Connexion</button>
    </form>
    
</body>
</html>