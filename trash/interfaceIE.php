<?php
session_start();
$_SESSION["numSerie"]=(int)trim($_GET["numSerie"]);
if (isset($_GET["totalExo"]))
	$_SESSION["totalExo"]=(int)trim($_GET["totalExo"]);
$nbExo=(int)trim($_GET["nbExo"]);
require_once("conn.php");
$sql1 = "SELECT * FROM serie where numSerie=".$_SESSION["numSerie"];
$result1 = mysql_query($sql1) or die ("Requ�te incorrecte");
$numExo=(int)trim($_GET["numExo"]);
while ($r1 = mysql_fetch_assoc($result1))
	  {
	  if($numExo<=$_SESSION["totalExo"])
	  	{
		  if ($r1["exo".$numExo]!="0")
			{
				$num=$r1["exo".$numExo];
				if ($r1["type".$numExo]=="a")
					$type="comparaison";
				else
					$type="complement";
				$questi=$r1["questi".$numExo];
				$_SESSION["num"]= $num;
				$_SESSION["type"]= $type;
				$_SESSION["questi"]= $questi;
				$_SESSION["terminer"]= false;
			}
   	    }
	  else 
		{
		 $_SESSION["terminer"]= true;
		}
   }
$num = $_SESSION["num"]; $type = $_SESSION["type"]; $questi = $_SESSION["questi"];
if (($_SESSION["terminer"])||($num=='')||($num==0))
{
   	$_SESSION["terminer"]= false;
	?>
	<script type='text/javascript'>window.close();</script>";
	<?php
}
	?>
<html>
<head>
<title>Interface IE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language=JavaScript src="interfaceIE.js"></script>
<style type="text/css">
<!--
.champText {background-color: #EAEAEA;}
-->
</style>
</head>
<body onload="masquer();" bgcolor="#66FF66">
<h3 align="center"><font color="#0000CC"><?php print(strtoupper($_SESSION['prenom'])."   ".strtoupper($_SESSION['nom']));?></font></h3>
<?php
if ($type=="complement")
print("<form action=\"diag_e.php\" name=\"info\" method=\"post\">");
else if ($type=="comparaison")
print("<form action=\"diag_a.php\" name=\"info\" method=\"post\">");
?> 
<table align="center">
  <tr>
    <td width="510" rowspan="2" valign="top"> 
	<table border="0" cellspacing="2">
        <tr>
          <td height="94" colspan="2" align="center">
		  <span style="color:#0000CC"><b><dfn>&nbsp;&nbsp; Exercice N� 
		  <?php echo ($_SESSION["totalExo"]-$nbExo+1); ?> &nbsp;&nbsp;</dfn></b></span>
		    <table width="100%" border="2" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td>
                  <?php
			require_once("conn.php");
			$Requete_SQL2 = "SELECT * FROM $type where numero=$num";
			$result = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());
			$nombreExemple = 1;
			while ($enregistrement = mysql_fetch_assoc($result))
				{
				  $text1 =  $enregistrement["enonce1"];
				  $text1 = str_replace("'","\'",$text1);
				  $text2 =  $enregistrement["question1"];
				  $text2 = str_replace("'","\'",$text2);
				  $text3 =  $enregistrement["enonce2"];
				  $text3 = str_replace("'","\'",$text3);
				  $text4 =  $enregistrement["question2"];
				  $text4 = str_replace("'","\'",$text4);
				}
			for($piece = strtok($text1, " "), $i=0 ; $piece != "" ; $piece = strtok(" "))
				{
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print("<a href=\"javascript:;\" onClick=\"insererSas('".$piece1." "."');\" style=\"text-decoration: none; font-size: 18pt;\">".$piece."</a>"." ");
				  $i++;
				}
 				print("<Br>");
if ($questi=="1")
 		 {
		 for($piece = strtok($text2, " "); $piece != "" ; $piece = strtok(" "))
			 {
			  $piece1 = $piece;
			  $piece = str_replace("\\","",$piece);
			  print("<a href=\"javascript:;\" onClick=\"insererSas('".$piece1." "."');\" style=\"text-decoration: none;  font-size: 18pt;\">".$piece."</a>"." ");
			 } 
  				print("<Br>");
		}
  		for($piece = strtok($text3, " "), $i=0 ; $piece != "" ; $piece = strtok(" "))
			   {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print("<a href=\"javascript:;\" onClick=\"insererSas('".$piece1." "."');\" style=\"text-decoration: none;  font-size: 18pt;\">".$piece."</a>"." ");
				  $i++;
			   }
  			   print("<Br>");

		for($piece = strtok($text4, " "); $piece != "" ; $piece = strtok(" "))
			  {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print("<a href=\"javascript:;\" onClick=\"insererSas('".$piece1." "."');\" style=\"text-decoration: none; font-size: 18pt;\">".$piece."</a>"." ");
			  }
  			  print("<Br>");
  			  mysql_close();
		?>
                </td>
              </tr>
            </table>
			<h3>Pour &eacute;crire, tu peux cliquer sur les mots de l'&eacute;nonc&eacute;</h3>
		  </td>
        </tr>
        <tr>
          <td width="420" height="31" align="center">             
            <input name="T1" type="text" value="" size="70" style="font-size:10pt;" class="champText" id="sas"
			  onFocus="monTour(5);colorFocus('sas');" 
			  onBlur="colorBlur('sas');">
</td>
          <td width="78" align="center"><input type="button" value="Effacer tout" name="efface5"  onClick="document.info.T1.value='';document.info.T1.focus();"></td>
        </tr>   
		 <tr>
		   <td height="36" colspan="2" align="center">
		   <input name="button2" type="button" style="color:#000066"  onClick="inserer(document.info.T1.value); document.info.T1.value='';" 
		   value="     Ecrire dans la feuille     "></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
		    <input type="button" value=" 1 " name="un" onclick="if (tester == 5) {insererSas('1');} else {afficher(1);}">
            <input type="button" value=" 2 " name="deux" onClick="if (tester == 5) {insererSas('2');} else {afficher(2);}">            
            <input type="button" value=" 3 " name="trois" onclick="if (tester == 5) {insererSas('3');} else {afficher(3);}">
            <input type="button" value=" 4 " name="quatre" onclick="if (tester == 5) {insererSas('4');} else {afficher(4);}">
            <input type="button" value=" 5 " name="cinq" onclick="if (tester == 5) {insererSas('5');} else {afficher(5);}">
            <input type="button" value=" 6 " name="six" onclick="if (tester == 5) {insererSas('6');} else {afficher(6);}">
            <input type="button" value=" 7 " name="sept" onclick="if (tester == 5) {insererSas('7');} else {afficher(7);}">
            <input type="button" value=" 8 " name="huit" onclick="if (tester == 5) {insererSas('8');} else {afficher(8);}">
            <input type="button" value=" 9 " name="neuf" onclick="if (tester == 5) {insererSas('9');} else {afficher(9);}">
            <input type="button" value=" 0 " name="zero" onclick="if (tester == 5) {insererSas('0');} else {afficher(0);}">
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center"> 
              <input type="button" value=" + " name="plus" onclick="if (tester == 5) insererSas(' + ');operat('+');">
              <input type="button" value=" - " name="moin" onclick="if (tester == 5) insererSas(' - ');operat('-');">
              <input type="button" value=" x " name="mult" id="mult" onclick="if (tester == 5) insererSas(' x '); operat('x');">
              <input type="button" value=" : " name="div"  id="div" onclick="if (tester == 5) insererSas(' : '); operat(':');">
			  <input type="button" value=" = " name="egale" onclick="if (tester == 5) {insererSas(' = ');} else {resultat();}">
          </td>
        </tr>
		<tr>
          <td height="29" colspan="2" align="center"><h3>Tu peux t'aider de la calculette</h3>
        </tr>
         
        <tr align="center">
          <td colspan="2" >            <table width="554" border="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="213" height="38">&nbsp;</td>
              <td width="44" bgcolor="#999999">&nbsp; </td>
              <td width="110" align="center" bgcolor="#999999">
                <input name="operande1" type="text" size="12" maxlength="10" class="champText" id="op1" style="text-align:right"
				onFocus="monTour(1); count(event,1);colorFocus('op1');document.info.resultat1.value='';" 
				onBlur="colorBlur('op1');" 
				onSelect="this.value='';" 
				onKeyPress="return checkIt(event);" 
				onKeyUp="count(event,1);">
</td>
              <td width="179"><!--DWLayoutEmptyCell-->&nbsp;              </td>
              </tr>
            <tr>
              <td align="right"><!--DWLayoutEmptyCell-->&nbsp;</td>
              <td align="right" bgcolor="#999999">
                <select name="operateur1" onChange="document.info.operande2.focus();" onBlur="colorBlur('operateur1');" 
					onFocus="colorFocus('operateur1');"id='operateur1'>
                      <option value="   " class="champText" selected></option>
                      <option value=" + ">+</option>
                      <option value=" - ">-</option>
                      <option value=" x ">x</option>
                      <option value=" : ">:</option>
                </select>
             </td>
              <td bgcolor="#999999">&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr>
              <td align="right"><input name="effacetout" type="button" id="effacetout3"
					onClick="document.info.resultat1.value=''; document.info.operande1.value='';
							 document.info.operande2.value=''; 
							 document.info.operateur1.selectedIndex='0';
							 document.info.operande1.focus();" value="Effacer l'op&eacute;ration"></td>
              <td bgcolor="#999999">&nbsp;</td>
              <td align="center" bgcolor="#999999">
                <input name="operande2" type="text" size="12" maxlength="10"class="champText" id="op2" style="text-align:right"
				  onFocus="monTour(2); count(event,2);colorFocus('op2');document.info.resultat1.value='';" 
				   onBlur="colorBlur('op2')" 
				  onSelect="this.value=''" 
				  onKeyPress="return checkIt(event)" 
				  onKeyUp="count(event,2)">
              </td>
              <td><!--DWLayoutEmptyCell-->&nbsp;              </td>
              </tr>
            <tr>
              <td><!--DWLayoutEmptyCell-->&nbsp; 
              </td>
			  
              <td colspan="2" bgcolor="#999999"><hr align="center" style="color:#000000 "></td>
              <td><!--DWLayoutEmptyCell-->&nbsp;</td>
            </tr>
            <tr>
              <td height="33" align="right"><!--DWLayoutEmptyCell-->&nbsp;</td>
              <td align="right" bgcolor="#999999">
                <input type="button" name="egale1" size="1" value=" = " onclick="resultat();count(event,4);monTour(4);">
             </td>
              <td align="center" bgcolor="#999999">
                <input name="resultat1" type="text" size="12" maxlength="10" class="champText" id="res" style="text-align:right"
				  onFocus="monTour(4); count(event,4);colorFocus('res');" 
				  onBlur="colorBlur('res')"  
				  onSelect="this.value=''" 
				  onKeyPress="return checkIt(event)" 
				  onKeyUp="count(event,4)" >
             </td>
              <td><!--DWLayoutEmptyCell-->&nbsp;              </td>
              </tr>
          </table></td></tr>
        <tr>
          <td height="60" colspan="2" align="center">
		  <input type="button" name="B2" value="Ecrire le calcul dans la feuille" onClick="verifCal();"></td>
        </tr>
      </table></td>
    <td width="10" rowspan="2" valign="top"></td>
    <td width="435" height="568" align="center" valign="top">
	<h4>&Eacute;cris tes calculs et ta r&eacute;ponse dans cette feuille</h4>
	  <input name="retour" type="button" value="Passer &agrave; la ligne" onClick="inserer('\n');document.info.zonetexte.focus();">      
	  <input name="annuler" type="button" id="annuler" value="Annuler" 
	  		onClick="if (feuille.isContentEditable==true) annulerAction();"> 
      <input name="effacer" type="button" id="effacer2" value="Effacer toute la feuille"
	  	onClick="document.info.zonetexte.value='';document.info.zonetexte.focus();">
		<textarea name="zonetexte" cols="50" rows="28" class="champText" id="feuille"
			 onFocus="colorFocus('feuille');" 
			 onBlur="colorBlur('feuille');"></textarea>
			 <p>
		<input name="button" type="button" value="                 Exercice termin&eacute                " onClick="verifForm();">
		</p>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top"><span style="color:#0000CC"><b><dfn>
      <?php 
$reste = $nbExo-1;
if($reste > 1)
 echo ("Il te reste ".$reste." exercices");
else if($nbExo-1 == 1)
 echo ("Il te reste ".$reste." exercice");
else if($reste == 0)
 echo ("c'est le dernier exercice"); 
?>
    </dfn></b></span>
    </td>
  </tr>
</table>
<input name="oper1" type="hidden">
<input name="oper2" type="hidden">
<input name="nbExo"  value="<?php echo($nbExo);?>" type="hidden">
<input name="numExo"  value="<?php echo($numExo);?>" type="hidden">
</form>
<table width="796"  border="0" align="center">
  <tr>
    <td align="center"><a href="javascript:;" onClick="abandonner();">Abandonner</a></td>
  </tr>
  <tr>
    <td align="right">
</td>
  </tr>
</table>


</body>
</html>