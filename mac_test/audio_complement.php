<?php require ("conn.php"); ?>
<html>
<script type="text/javascript" language="javascript">
  var texte = "Voulez-vous r�ellement supprimer cet �nonc� ?"
  function supprimer(num)
  {
  	if(confirm(texte))
	{
	  document.location.href = "supprimer_enonce.php?numExo="+num+"&typeExo=complement";
	}
	else
	{
		//alert("supprimer_enonce.php?numExo="+num+"&typeExo=complement");
	}
  }
</script>
 <head>
  <title>Enonc� complement</title>
 </head>
<body>

<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">El�ve</a>
</p>

<form action="selection.php" method="post">
  <table width="900" border="2" align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <tr align="center" bgcolor="#99FF99"> 
	
	<td width="800" height="29" bgcolor="#F0F7FA">Enonc�s complement</td>
 
	<td  width="100" bgcolor="#F0F7FA">Action</td>
    </tr>
    <?php
  // initialisation
	$nb=7;
	if(empty($page)) $page = 1;
	if(empty($total)){ // nombre total de r�sultats
 	$sql1 = "select count(*) as qte from complement";
 	$p = @mysql_query($sql1,$BD_link);
 	$total = @mysql_result($p,"0","qte");
	}

	// on determine debut du limit
	$debut = ($page - 1) * $nb;

  $sql = "SELECT * FROM complement order by numero desc LIMIT $debut,$nb";

  $result = mysql_query($sql) or die ("Requ�te incorrecte");
  // = mysql_numrows($query);
  if ($result) { // Si il y'a des r�sultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text2 =  $enregistrement["question1"];
		  $text3 =  $enregistrement["enonce2"];
		  $text4 =  $enregistrement["question2"];
		  $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
		  $num = $enregistrement["numero"];
		   $exo= stripslashes($exo);
		   $dossier2 = "audio/complement/exo$num/";//prendre les caracteristiques de l'enonc� 
			if (is_dir($dossier2)){$presence_audio=true;}else{$presence_audio=false;}
?>
    <tr> 
	<td height="27">
		<?php echo($exo); ?>
	</td>
	
	<td height="27">
		<?php if($presence_audio){echo ("<a href=\"audio_complement_upload.php?num=$num&delete=true\"");?>
	onclick="return(confirm('Etes-vous s�r ?'));"> supprimer audio</a>
		<?php }else{echo ("<a href=\"audio_complement_upload.php?num=$num&type=complement\">"); ?>
	ajouter audio</a>
		<?php } ?>
	</td>
  </tr>
    <?php
        } // Fin instruction while

      } else  // Pas de r�sultat trouv�

    echo "Pas de r�sultat";

      
?>
  </table>
<div align="center">
  <p>
    <?php
	// calcul du nombre de pages
 	$nbpages = ceil($total / $nb); // arrondi a l'entier superieur
 	// on affiche les pages
 	for($i = 1;$i <= $nbpages;$i ++)
	{
 	   echo "<a href=\"$PHP_SELF?page=$i&total=$total\">page$i</a>";
       if($i < $nbpages) echo " - ";
    }
  mysql_free_result($result); // Lib�re la m�moire
  mysql_close($BD_link); // Ferme la connexion
 ?>
  </p>

</div>
  
</form>
</body>
</html>
