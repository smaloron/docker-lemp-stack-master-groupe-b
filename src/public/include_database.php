<?php
$databaseUser = "root";
$databasePassword = "secret";
$dataSourceName = "mysql:host=lemp-mariadb;dbname=todolist";
$pdo = new PDO($dataSourceName, $databaseUser, $databasePassword);
