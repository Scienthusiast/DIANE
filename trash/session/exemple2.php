<?php

// Ici $login et $password ne sont pas d�finis

session_start();

// Ils sont d�finis � partir d'ici.

echo $login;

echo $password;

if($login!="nom") session_destroy(); // destruction de la session

?> 