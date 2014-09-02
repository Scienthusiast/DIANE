<?php

session_start();

echo $login; // il a la valeur de la variable de session correspondante.

// la variable $login pr�sente dans notre page prend une valeur diff�rente de
// celle pr�sente dans la session. La variable de session $login n'a pas �t�
// modifi�e ; elle a toujours la m�me valeur !

$login="nouveau_login";

echo $login; // Affiche "nouveau_login"

// Met � jour la variable de session $login avec la nouvelle valeur � savoir
// "nouveau_login"

session_register("login");

?> 