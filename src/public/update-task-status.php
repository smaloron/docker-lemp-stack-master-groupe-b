<?php

require("../model/database.php");
$pdo = getPDO();

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$done = filter_input(INPUT_GET, "done", FILTER_SANITIZE_SPECIAL_CHARS);

// conversion de la chaîne de caractère en entier 
// pour insertion dans la bd
$done = $done =="true"?1:0;

try {
    $sql = "UPDATE tasks SET done=? WHERE id=?";
    $query = $pdo->prepare($sql);
    $query->execute([$done, $id]);
    var_dump($id, $done);
}catch(PDOException $err){
    var_dump($err);
}

