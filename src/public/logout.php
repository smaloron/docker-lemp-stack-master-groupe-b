<?php
session_start();

// destruction de la session
session_destroy();

// On relannce la session
session_start();
// réattribution d'un id de session
session_regenerate_id();

//Redirection
header("location:index.php");
