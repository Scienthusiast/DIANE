<?php

session_start(); // D�marre la session. Sp�cifie une id de session.

$login="nom"; // On d�finit la variable classique $login

$password="mot de passe"; // On d�finit la variable classique $password

session_register("login"); // On enregistre $login dans la session

session_register("password"); // On enregistre $password dans la session

header("Location: exemple2.php?".session_name()."=".session_id());

exit(); // Redirection. On en reparle dans le II.3.

?>  
 


