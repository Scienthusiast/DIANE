<?php 
require_once("mac_test/conn.php");
$requete1 = "select * from diagdistrib where numEleve =".$_POST["numEleve"];
//$requete1 = "select * from diagdistrib where colonne2=2 and colonne14=0";//".$_POST["numDiag"];
//$requete1 = "select * from diagdistrib where numDiag = 80";//.$_POST["numDiag"];
//$requete1 = "select * from diagdistrib where numDiag between 34 and 377";
function calcul2($tab1,$tab2)
	{
		$cal=$tab2[0];
		for($i=0;$i<count($tab1);$i++)
			switch ($tab1[$i])
			{
				case "+" : $cal = $cal+$tab2[$i+1];
							break;
				case "-" : $cal = $cal-$tab2[$i+1];
							break;
				case "*" : $cal = $cal*$tab2[$i+1];
							break;
				case ":" : $cal = $cal/$tab2[$i+1];
							break;
			}
		return $cal ;
	}

//$requete1 = "select * from diagdistrib where numEleve=65";
$result = mysql_query($requete1) or die("Impossible d'interroger la base de donn�es");
$num = mysql_num_rows($result);
if ($num != 0) 
{ 
	$file= fopen("diagXMLdistrib.xml", "w"); 
	$_xml ="<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\r\n"; 
 	$_xml .="<?xml-stylesheet href=\"diag_d.xsl\" type=\"text/xsl\"?>\r\n";
$_xml .="<diagnostic>\r\n"; 
	while ($r = mysql_fetch_array($result)) 
	 { 
		$reponseEleve='';
		$reponse='';
		$tabOperation[]='';
		$tabOp[]='';
		$tab[]='';
		$tabOper[]='';
		$tabNombre[]='';
		$tabSR []= '';
		$tabR []= '';
		$tabTOper[]='';
		$tabImp[] = '';
		$tabImplicite[]='';
		$tabOper[]='';$tabFOperande[]='';
		$RCorrect='';$RCorrectErreur='';$RInCorrect='';
		unset($reponse,$reponseEleve,$tabImplicite,$tabOperation,$tabNombre,$tab,$tabOp,$tabOper,$tabSR,$tabR,$tabOper,$RCorrect,$RCorrectErreur,$RInCorrect);
		unset($text1,$text2,$enonce,$va1,$va2,$va3,$va4,$va5,$nva,$posFact,$varFacteur,$varFactorise);
		$_xml .="<exercice numTrace='".$r["numTrace"]."'>\r\n"; 
		//echo("num�ro de trace =".$r["numTrace"]."<br>");
		$req = "select zoneText as reponse from trace where id=".$r["numTrace"];
		$res = mysql_query($req) or die("Impossible d'interroger la base de donn�es");
		while ($rc = mysql_fetch_array($res)) 
	  	{
		 $reponseEleve = $rc["reponse"];
		 $reponseEleve = ereg_replace("\r\n|\n", "<br/>",$reponseEleve);
		 $reponse = $rc["reponse"];
		 $reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|,|(|)|+|*|:|=|-]', " ",$reponse));
		
		//tabNombre contient  tous les nombres que contient la r�ponse de l'apprenant
		$tabNombre = preg_split ("/[\s]+/", $reponse);
		$tabNombre = array_values (preg_grep("/\d/", $tabNombre));
		//les parenth�ses ne sont pas obligatoire par contre le signe �gale doit �tre pr�sent pour reconna�tre une op�ration
		$pattern = "/((?:\d+\s*[\+\-\*\/x:]\s*)*(?:\(?\s*(?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)?\s*[\+\-\*\/x:]?\s*)*\d*\s*)=(\s*\d+)/";
		//ER qui reconnait les operation de type a+....+a = a ou sans le signe egale 
		//$pattern = "/(((?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*)=?\s*(\d*))/"; //(?:) parenth�se non capturante 
		preg_match_all($pattern,$reponse,$tab);
		
		//tableau des op�ration utilis�es dans la r�ponse de l'apprenant ==> tabOperation
		$tabOperation = $tab[0];
		$tabSR = $tab[1];
		$tabR = $tab[2];
		
	/* //verification de chaque op�ration 
		$sansResultat=$tabSR[0];
		$resultat=$tabR[0];
		
		$pat1 = "/\d+/";$pat2 = "/\+|-|\*|:]/";
		//tableau des op�randes 
		preg_match_all($pat1,$sansResultat,$tabOperande);
		$tabOper = $tabOperande[0];
		preg_match_all($pat2,$sansResultat,$tabOperateur);
		$tabOperateur = $tabOperateur[0];
		print_r($tabOper);echo("<br>");print_r($tabOperateur);echo("<br>");
		$resOp = calcul2($tabOperateur,$tabOper);
		echo($resOp);echo("<br>"); */
		
		//print_r($var1); echo("<br>");
		//print_r($tabR); echo("<br>");
		//print_r($tabSR); echo("<br>");

		$resFin=trim(end($tabR));
		for($i=0;$i<count($tabOperation); $i++)
		 {
		 	$tabOp[$i]=trim(ereg_replace('\s*| ','',$tabOperation[$i]));
			$tabSR[$i]=trim(ereg_replace('\s*| ','',$tabSR[$i]));
		 }
		 $opFinSR=trim(end($tabSR));
		 $resFin=trim(end($tabR));
		//tableau des op�randes 
		$pat1 = "/\d+/";
		$tabTOper= array();
		for($i=0;$i<count($tabOperation); $i++)
		{
			preg_match_all($pat1,$tabOperation[$i],$tabTOperande);
			$tabOper{$i}=$tabTOperande[0];
			$tabTOper=array_merge($tabTOper,$tabOper{$i});
		}
				
	    //tableau des op�randes : uniquement l'op�ration finale
		preg_match_all($pat1,end($tabOperation),$tabFOperande);
		$tabOper = $tabFOperande[0];

		//tableau implicite
		for ($i=0; $i<count($tabTOper); $i++)
			 {
				for ($j=0 ; $j < count($tabNombre) ; $j++)
					{
					  if ($tabTOper[$i] == $tabNombre[$j])
						{
							$tabNombre[$j]='';
							break 1;
						}
					}
			 }
		for ($i=0 ; $i < count($tabNombre) ;$i++)
		
		if ($tabNombre[$i]!='')
		  $tabImp[] = $tabNombre[$i];
		//comparer les r�sultats des op�rations avec ceux du tableau tabImp
		$tabImplicite=array_diff($tabImp,$tabR);
	}
		$procJuste=array("D"=>$r["D"],"Dc"=>$r["Dc"],"De"=>$r["De"],"De2"=>$r["De2"],"F"=>$r["F"],"Fc"=>$r["Fc"],"Fe"=>$r["Fe"],"Fe2"=>$r["Fe2"]);
		$errCal=array("Addition"=>$r["Addition"],"Multiplication"=>$r["Multiplication"],"Position"=>$r["Position"]);
		$errRais=array("B"=>$r["B"],"At"=>$r["At"],"M"=>$r["M"],"M2"=>$r["M2"],"M3"=>$r["M3"],"N"=>$r["N"]);
		$raisInc=array("A"=>$r["A"],"Di"=>$r["Di"]);
		$raisAty=array("Em"=>$r["Em"],"Ed"=>$r["Ed"],"Ea"=>$r["Ea"],"Ej"=>$r["Ej"]);
		$developpement=array("D"=>$r["D"],"Dc"=>$r["Dc"],"De"=>$r["De"],"De2"=>$r["De2"]);
		$factorisation=array("F"=>$r["F"],"Fc"=>$r["Fc"],"Fe"=>$r["Fe"],"Fe2"=>$r["Fe2"]);
		
		if(in_array(1,$developpement))
			$typeStr="D";
		else if(in_array(1,$factorisation))
			$typeStr="F";
		else if(in_array(1,$raisAty))
			$typeStr="RA";
		else if(in_array(1,$raisInc))
			$typeStr="RI";
		else if(in_array(1,$errRais) and $r["B"]==1)
			$typeStr="PR";
		else if(in_array(1,$errRais))
			$typeStr="ER";
		if($r["Cimp"]==3)
			$typeStr="imp";
		if($r["Cimp"]==1 and count($tabOperation)==0)
			$typeStr="impf";
		/* print_r($procJuste);echo("<br/>");
		print_r($errCal);echo("<br/>");
		print_r($errRais);echo("<br/>");
		print_r($raisInc);echo("<br/>");
		print_r($raisAty);echo("<br/>");
 */
		//Nombre d'operations utilis�es par l'apprenant
		$nbOper=count($tabOperation);//$r["nbOper"];

	//afficher les op�rations d�tecter
for($i=0;$i<count($tabOperation);$i++)
{
	//echo($tabOperation[$i]."<br/>");
}
			
		//Rechercher les informations sur l'�nonc� dans la BD
		
		$requete2 = "SELECT * FROM distributivite where numero=".$r["numExo"];
		$result2 = mysql_query($requete2) or die("Erreur de S&eacute;lection dans la base : ". $requete2 .'<br />'. mysql_error());
		while ($r2 = mysql_fetch_assoc($result2))
				{
				  $text1 = stripslashes($r2["enonce"]);//str_replace("'","\'",$r2["enonce1"]);
				  $text2 = stripslashes($r2["question"]);
				  $enonce=$text1."\r\n".$text2;
				  $enonce = ereg_replace("\r\n", "<br/>",$enonce);
				  $va1=$r2["va1"]; $va2=$r2["va2"]; $va3=$r2["va3"]; $va4=$r2["va4"]; $va5=$r2["va5"];
				  $nva=$r2["nva"]; $fact=$r2["fact"]; 
				  $posFact=$r2["facteur"]; $varFacteur=$r2["varFacteur"]; $varFactorise=$r2["varFactorise"];
				  $r1=$va1*$fact;
				  $r2=$va2*$fact;
				  $r3=$va3*$fact;
				  $r4=$va4*$fact;
				  $r5=$va5*$fact;
				  $sommeva=$va1+$va2+$va3+$va4+$va5;
				  $resfin=$sommeva*$fact;
				}
		if (isset($enonce)) 
		{
			//echo($enonce);
		$_xml .="<enonce>".$enonce."</enonce>\r\n";
		}
		
		$_xml .="<reponse>".$reponseEleve."</reponse>\r\n";

		//Rechercher le Nom et Pr�nom de l'apprenant
		$requete3 = "select nom, prenom, sexe from eleve where numEleve=".$r["numEleve"];
		$result3 = mysql_query($requete3) or die("Erreur de S&eacute;lection dans la base : ". $requete3 .'<br/>'. mysql_error());
		while ($r3 = mysql_fetch_assoc($result3))
				{
					$nom =  substr($r3["nom"],0,1);
					$prenom =$r3["prenom"]; 
					$sexe = $r3["sexe"];									
				}
		$_xml .="<nom>".ucfirst($prenom)." ".strtoupper($nom)."</nom>\r\n";
		
		//verifie si la solution est Correcte
		if(in_array(1,$procJuste) and $r["Addition"]==0 and $r["Multiplication"]==0 and $r["Position"]==0)
		{
			//echo ("<br>proc�dure juste<br>");
			$RCorrect=true;
		}
		else if(in_array(1,$procJuste) and ($r["Addition"]!=0 or $r["Multiplication"]!=0 or $r["Position"]!=0))
		{
			//echo ("<br>proc�dure juste avec des erreurs de calcul<br>");
			$RCorrectErreur=true;
		}
		else if(!in_array(1,$procJuste) and in_array(1,$errRais))
		{
			//echo ("<br>Erreur de raisonnement<br>");
			$RInCorrect=true;
		}
		else if((!in_array(1,$procJuste) and !in_array(1,$errRais) and in_array(1,$raisInc))||$typeStr=="impf")
		{
			//echo ("<br>raisonnement incomplet<br>");
			$RInCorrect=true;
		}
		
		else if(!in_array(1,$procJuste) and !in_array(1,$errRais) and !in_array(1,$raisInc) and in_array(1,$raisAty))
		{
			//echo ("<br>raisonnement atypique<br>");
			$RAtypique=true;
			if($r["Multiplication"]!=0 or $r["Position"]!=0)
			{
				$ErrAtypique=true;
				$RAtypique=false;
			}
		}
		else if ($r["B"]==1) 
		{	
			$PasResolu=true;
			//echo ("<br>probl�me non r�solu<br>");
		}
		else if(!in_array(1,$procJuste) and !in_array(1,$errRais) and !in_array(1,$raisInc) and !in_array(1,$raisAty))
		{
			//echo ("<br>erreur de codage<br>");
		}


		//l'apprenant a-t-il bien r�solu le probl�me ?
	if ((isset($RCorrect) and $RCorrect)  || ($typeStr=="imp"))
		$_xml .="<resolution> a bien r�solu le probl�me</resolution>\r\n";
	else if (isset($RCorrectErreur)and $RCorrectErreur)
		$_xml .="<resolution> a bien r�solu le probl�me � l'exception d'erreurs de calcul</resolution>\r\n";
	else if (isset($PasResolu) and $PasResolu) 
			$_xml .="<resolution> n'a pas r�solu le probl�me</resolution>\r\n";
	else if (isset($RInCorrect) and $RInCorrect) 
		$_xml .="<resolution> n'a pas r�solu le probl�me correctement</resolution>\r\n";
	else if (isset($RAtypique) and $RAtypique) 
		$_xml .="<resolution> a bien r�solu le probl�me mais avec une strat�gie atypique</resolution>\r\n";
	
	else if (isset($ErrAtypique) and $ErrAtypique) 
		$_xml .="<resolution> a bien r�solu le probl�me mais avec une strat�gie atypique et des erreurs de calcul</resolution>\r\n";
	

		//balise qui affiche le pr�nom de l'�l�ve
		$_xml .="<prenom>".ucfirst($prenom)."</prenom>\r\n";
		
		//balise qui affiche le nombre d'op�rations utilis�es
		if($r["Cimp"]==0) $calImp=0;
		else $calImp=1;
		switch ($nbOper)
				{ 
					case "0" : $nbOperLettre="z�ro"; break;
					case "1" : $nbOperLettre="un"; break;
					case "2" : $nbOperLettre="deux"; break;
					case "3" : $nbOperLettre="trois"; break;
					case "4" : $nbOperLettre="quatre"; break;
					case "5" : $nbOperLettre="cinq"; break;
					case "6" : $nbOperLettre="six"; break;
					case "7" : $nbOperLettre="sept"; break;
					case "8" : $nbOperLettre="huit"; break;
					case "9" : $nbOperLettre="neuf"; break;
					default : $nbOperLettre=$nbOper; break;
				}
		$_xml .="<nbOper nbOper=\"".$nbOper."\" calImp=\"".$calImp."\" sexe=\"".$sexe."\">".$nbOperLettre."</nbOper>\r\n";
		//balise affiche la strat�gie, erreurs de calcul
		if ($r["Id"]) 
		{ 
						
			//proc�dure juste
			if($r["D"]==1) 
			{
				$strategie="d�veloppement : forme classique";
				$code="D";
			}
			else if($r["Dc"]==1)
			{
				$strategie="develeppement : condensation";
				$code="Dc";
			}
			
			if($r["De"]==1)
			{
				$strategie="develeppement : Explosion 1";
				$code="De";
			}
			else if($r["De2"]==1)
			{
				$strategie="develeppement : Explosion 1";
				$code="De2";
			}
			
			if($r["F"]==1)
			{
				$strategie="factorisation : forme classique";
				$code="F";
			}
			else if($r["Fc"]==1)
			{
				$strategie="factorisation : condensation";
				$code="Fc";
			
			}
			else if($r["Fe"]==1)
			{
				$strategie="factorisation : Explosion I";
				$code="Fe";
			}
			else if($r["Fe2"]==1)
			{
				$strategie="factorisation : Explosiion II";
				$code="Fe2";
			}
			//Erreur de raisonnement
			else if($r["B"]==1) 
			{
				$strategie="aucune r�ponse";
				$code="B";
			}
			else if($r["At"]==1)
			{
				$strategie="addition de tous les termes de l'�nonc�";
				$code="At";
			}
			else if($r["M"]==1)
			{
				$strategie="multiplication du facteur par le nombre de factoris�";
				$code="M";
			}
			else if($r["M2"]==1)
			{
				$strategie="multiplication par 2";
				$code="M2";
			}
			else if($r["M3"]==1)
			{
				$strategie="multiplication par 3";
				$code="M3";
			}
			else if($r["N"]==1)
			{
				$strategie="Erreur unique";
				$code="N";
			}
			//Raisonnement incomplet
			else if($r["A"]==1) 
			{
				$strategie="Raisonnement incomplet : addition";
				$code="A";
			}
			else if($r["Di"]==1)
			{
				$strategie="Raisonnement incomplet : d�vellopement incomplet";
				$code="Di";
			}
 			//raisonnement bon atypique
			if($r["Em"]==1) 
			{
				$strategie="raisonnement bon atypique : myriade";
				$code="Em";
			}
			else if($r["Ed"]==1)
			{
				$strategie="raisonnement bon atypique : d�composition";
				$code="Ed";
			}
			else if($r["Ea"]==1)
			{
				$strategie="raisonnement bon atypique : mise en brique";
				$code="Ea";
			}
			else if($r["Ej"]==1)
			{
				$strategie="raisonnement bon atypique : Adjonction";
				$code="Ej";
			}
			else if($r["Cimp"]==3)
			{
				$strategie="raisonnement bon";
				$code="imp";
			}
			else if($r["Cimp"]==1 and count($tabOperation)==0)
			{
				$strategie="raisonnement incomplet";
				$code="impf";
			}
			//erreurs de calcul
			switch ($r["Addition"])
			{
				case "0" : $errAdd="pas d'erreur de calcul";break;
				case "1" : $errAdd="le calcul interm�diaire";break;
				case "2" : $errAdd="le calcul final ";break;
				case "3" : $errAdd="le calcul interm�diaire et le calcul final";break;
				case "4" : $errAdd="mais non identifi�";break;
				case "5" : $errAdd="parenth�se";break;
			}
			switch ($r["Multiplication"])
			{
				case "0" : $errMult="pas d'erreur de calcul";break;
				case "1" : $errMult="le calcul interm�diaire";break;
				case "2" : $errMult="le calcul final";break;
				case "3" : $errMult="le calcul interm�diaire et le calcul final";break;
				case "4" : $errMult="mais non identifi�";break;
				case "4" : $errMult="parenth�se";break;
			}
			switch ($r["Position"])
			{
				case "0" : $errPos="pas d'erreur de position";break;
				case "1" : $errPos="unit� mal plac�e";break;
				case "2" : $errPos="erreur de retenue additive";break;
				case "3" : $errPos="erreur de retenue multiplicative";break;
			}
			//Calculs Implicites
			switch ($r["Cimp"])
			{
			case "0" : $imp="pas de calcul implicite";break;
			case "1" : $imp="calcul interm�diaire implicite";break;
			case "2" : $imp="calcul final implicite";break;
			case "3" : $imp="calcul interm�diaire et calcul final implicite";break;
			}
		
		$_xml .="<fact>".$fact."</fact>\r\n";

		//echo($strategie." --> ".$code."<br>");
		//balise qui affiche la strat�gie utilis�e
		$_xml .="<strategie typeStr=\"".$typeStr."\" str=\"".$code."\" imp=\"".$r["Cimp"]."\" sexe=\"".$sexe."\">\r\n";
			$_xml .="<str>".$strategie."</str>\r\n";
			$_xml .="<facteur>".$fact."</facteur>\r\n";
			$_xml .="<nbVal>".$nva."</nbVal>\r\n";
			$_xml .="<sommeVal>".$sommeva."</sommeVal>\r\n";
			
			
			switch ($nva)
			{
			case "3" : $_xml .="<valSomme>".$va1.", ".$va2.", ".$va3."</valSomme>\r\n";
					   $_xml .="<minVal>".min($va1,$va2,$va3)."</minVal>\r\n";
						break;
			case "4" : $_xml .="<valSomme>".$va1.", ".$va2.", ".$va3.", ".$va4."</valSomme>\r\n";
					   $_xml .="<minVal>".min($va1,$va2,$va3,$va4)."</minVal>\r\n";
						break;
			case "5" : $_xml .="<valSomme>".$va1.", ".$va2.", ".$va3.", ".$va4.", ".$va5."</valSomme>\r\n";
						$_xml .="<minVal>".min($va1,$va2,$va3,$va4,$va5)."</minVal>\r\n";
						break;
			}
		$_xml .="</strategie>\r\n";
		
		//balise qui affiche les op�rations saisis
		$_xml .="<operation>";
		for($i=0;$i<count($tabOperation);$i++)
		{
			$_xml .=$tabOperation[$i]."<br/>";
		}
		$_xml .="</operation>\r\n";

		
		//balise qui affiche les erreurs de calcul
		if($r["Cimp"]!="0") 
		{
			//echo($imp."<br>");
			$_xml .="<calImp imp=\"".$r["Cimp"]."\" sexe=\"".$sexe."\">".$imp."</calImp>\r\n";
		}
		//erreur de calcul d�tect� non identifi�
		if($r["Addition"]=="4" and $r["Multiplication"]=="4")
		{
			//echo("erreur de calcul non identifi�<br>");
			$_xml .="<errCal sexe=\"".$sexe."\">erreur de calcul non identifi�</errCal>\r\n";
		}
		//erreur d'addition uniquement
		if($r["Addition"]!="0" and $r["Addition"]!="4" and $r["Multiplication"]=="0")
		{
			//echo("erreur d'addition : ".$errAdd."<br>");
			$_xml .="<errAdd sexe=\"".$sexe."\">".$errAdd."</errAdd>\r\n";
		}
		//erreur de multiplication uniquement
		if($r["Multiplication"]!="0" and $r["Multiplication"]!="4" and $r["Addition"]=="0") 
		{
			//echo("erreur de multiplication : ".$errMult."<br>");				
			$_xml .="<errMult sexe=\"".$sexe."\">".$errMult."</errMult>\r\n";
		}
		//erreur d'addition et de multiplication
		if($r["Addition"]!="0" and $r["Addition"]!="4" and $r["Multiplication"]!="0")
		{
			if($r["Addition"]=="1" and $r["Multiplication"]=="1")
				$errAddMul="une erreur d'addition et de multiplication dans le calcul interm�diaire";
			else if($r["Addition"]=="1" and $r["Multiplication"]=="2")
				$errAddMul="une erreur d'addition dans le calcul interm�diaire et une erreur de multiplication dans le calcul final";
			else if($r["Addition"]=="2" and $r["Multiplication"]=="1")
				$errAddMul="une erreur de multiplication dans le calcul interm�diaire et une erreur d'addition dans le calcul final";
			else if($r["Addition"]=="5" and $r["Multiplication"]=="5")
			{
				$errAddMul="une erreur de parenth�se";
			}
			//echo("il a fait ".$errAddMul."<br>");
			$_xml .="<errAddMul sexe=\"".$sexe."\">".$errAddMul."</errAddMul>\r\n";
		}
		
		
		if($r["Position"]!="0")
		{
			//echo($errPos."<br>");
			$_xml .="<errPos sexe=\"".$sexe."\">".$errPos."</errPos>\r\n";
		}
		//echo("_________________<br/>");
				

		} //fin du if ($r["Id"]) 
	 	$_xml .="</exercice>\r\n"; 

	  } 
	$_xml .="</diagnostic>"; 
	unset($r,$strategie);
	fwrite($file, $_xml); 
	fclose($file); 
	//echo "le fichier XML vient d'�tre cr�er.  <a href=\"diagXMLphp.php\">visualiser</a><br/>"; 	
	echo "Le fichier XML vient d'�tre cr�er.  <a href=\"diagXMLdistrib.xml\">visualiser</a><br/>"; 	

} 
else 
{ 
	echo "Pas d'enregistrement. <a href=\"javascript:history.go(-1)\">Retour</a> "; 
} 

?>