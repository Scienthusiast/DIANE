<?
//on d�marre la session
session_start();

//on affiche la variable enregistr�e pr�c�demment
//print 'votre nom est '.$HTTP_SESSION_VARS[nom];

//vous pouvez l'afficher sous cette forme avec les nouvelle version de php
print '<br>votre nom est '.$_SESSION[a];

// liens page v�rifier nomm�e verif.php

print '<br><a href="verif.php">V�rifier l\'enregistrement</a>'; 

?> 