<?php

/**
 * Retourne une instance de PDO
 * Pour la connexion à la base de données
 */
function getPDO(): PDO{
    $databaseUser = "root";
    $databasePassword = "secret";
    $dataSourceName = "mysql:host=lemp-mariadb;dbname=todolist";
    return new PDO($dataSourceName, $databaseUser, $databasePassword);
}