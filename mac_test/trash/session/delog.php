<?
session_unregister("nom");
print("<img src=\"carre.gif\">");
session_unset();
print("<img src=\"carre.gif\">");
session_destroy();
print("<img src=\"carre.gif\">");
print("Vous �tes bien d�log�.<p>Clickez <a href=\"nom.php\">ici</a> pour entrer votre nom.");
?> 