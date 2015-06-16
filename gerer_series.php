<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	require_once("conn_pdo.php");

	// on veut pouvoir :
	/* 
	- créer une session = choisir des séries
	- modifier / supprimer (QUE POUR CHERCHEUR)
	- promote problem (promote problem selection) : QUE POUR CHERCHEUR
	- ajouter
	- voir les infos = code de la série, nombre d'exos, etc
	*/

	
	define("RIGHTS_SUPPR", 0x1);
	define("RIGHTS_PROMOTE", 0x2);

	/*
	function test_flags($flags) {
	  if ($flags & FLAG_A) echo "A";
	  if ($flags & FLAG_B) echo "B";
	  if ($flags & FLAG_C) echo "C";
	}
	test_flags(FLAG_B | FLAG_C); */


	if($_POST){
		if(isset($_POST['idToSuppr'])){
			if(is_numeric($_POST['idToSuppr'])){
				$idToSuppr = (int)$_POST['idToSuppr'];
				// On vérifie que l'account a le droit de supprimer la série en question //TODO : add admin rights

				$req = $bdd->query('SELECT idCreator from serie WHERE idSerie = '.$idToSuppr);
				$res = $req->fetch();
				
				if($_SESSION['id'] != $res['idCreator']){ // Ne devrait pas arriver dans une utilisation normale... J'ai l'impression que ça veut dire qu'il a forgé la requête POST
					echo "Vous n'avez pas les droits pour supprimer cette série...";
				}
				else{
					//Suppression des dépendances dans serie_pbm
					$bdd->query('DELETE FROM pbm_serie where serie = '.$idToSuppr);

					//Suppression de la série
					$bdd->query('DELETE FROM serie where idSerie = '.$idToSuppr);
				}

				// if($res->fetch()){
				// 	//echo $res."<br/>";
				// 	echo $res['idCreator']."<br/>";
				// }

				// $req = $bdd->prepare('INSERT INTO pbm_template (constraints, public_notes, compteurs, Text_html, Text_brut, properties, private_notes, idCreator) VALUES (:constraints, :public_notes, :compteurs, :Text_html, :Text_brut, :properties, :private_notes, :idCreator)');
				// $req->execute(array(
				// 	'constraints' => $c,
				// 	'public_notes' => $public,
				// 	'compteurs' => $comp,
				// 	'Text_html' => $html,
				// 	'Text_brut' => $brut,
				// 	'properties' => $prop,
				// 	'private_notes' => $private,
				// 	'idCreator' => $_SESSION['id']));

				$req->closeCursor();
		

			}
		}
		
		
	}

	function displaySerie($enregistrement, $rights = 0x0){ //,$count){ //TODO : ajouter $droits, etc
		$limText=110;
		$text1 = $enregistrement['nomSerie'];
		$id= $enregistrement['idSerie'];

		if (strlen($text1) > $limText) 
		{
			$text1=substr($text1, 0, $limText).'[...]';
		}

		//echo "<li id=\"li_".$count."\">";
		echo "<li>";
			echo "<div class=\"serie_s\">";
				echo "<span class=\"serie_select\">";
					echo "<input type=\"checkbox\" name=\"".$id."\" value=\"".$id."\"></input>";
				echo "</span>";
				echo "<span class=\"serie_text\">";
					echo $text1;
				echo"</span>";
				echo"<span class=\"serie_see\">";
					echo"<a id=\"serie_see".$id."\" href=\"s_see".$id."\"><img src=\"static/images/loupe.gif\" alt=\"voir cette série\"/></a>";
				echo"</span>";


				//if(isset($_SESSION['typeAccount'])){
					//if($_SESSION['typeAccount']=='chercheur'){
				if($rights & RIGHTS_SUPPR){
					echo "<span class=\"serie_delete\">";
					echo "<a id=\"serie_delete".$id."\" href=\"\" onclick=\"confirmSuppr(".$id.");return false;\"><img src=\"static/images/delete.png\" alt=\"supprimer cette série\"/></a>";
					echo "</span>";
				}
				if($rights & RIGHTS_PROMOTE){
					echo "<span class=\"serie_promote\">";
					echo "<a id=\"serie_promote".$id."\" href=\"s_pro".$id.".php\"><img src=\"static/images/star.png\" alt=\"promouvoir cette série\"/></a>";
					echo "</span>";
				}
				
			echo"</div>";
		echo"</li>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" charset="utf-8">
		<title>Séries de Problèmes</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css">
		<script language = "JAVASCRIPT">
			function confirmSuppr(idToSuppr){
				if(confirm("Êtes vous sûr de vouloir supprimer cette série ? Les exercices eux-mêmes ne seront pas supprimés.")){
					var idToSupprForm = document.getElementById("idToSupprForm");
					idToSupprForm.value = idToSuppr;
					document.forms["action_form"].submit();
				}
			}
		</script>
	</head>

	<body id="main_body" >
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<form action="gerer_series.php" method="post" class="appnitro" id="action_form">

			<h2>Gérer les séries</h2>
			<?php
				// TODO : il me faut un if(isset($_SESSION)) qui englobe tout !
				require_once("conn_pdo.php");
				$limText=110;
				
				// Séries crées par l'id en session

				//$vosSeries = $bdd->query("SELECT * FROM serie WHERE idCreator = ".$_SESSION['id']."ORDER BY ordrePres"); //try - catch ?
				$vosSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator = ? ORDER BY ordrePres");
				$vosSeries->execute(array($_SESSION['id']));
				$vosSeriesFlag = False; //flag, vaut vrai quand l'account connecté a créé des séries
				if($vosSeries->rowCount()!=0){
					echo"<h3>Vos séries d'exercices</h3>";
					$vosSeriesFlag = True;

					//$t=0;
					while ($enregistrement = $vosSeries->fetch())
					{
						displaySerie($enregistrement, RIGHTS_SUPPR);
					} 
				} 
				$vosSeries->closeCursor();


				
				//récupération de toutes les séries (il faudra passer en "toutes les séries qui ne m'appartiennent pas")
				
				if($vosSeriesFlag){
					echo"<h3>Autres séries d'exercices</h3>";
					$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? ORDER BY ordrePres");
					$autresSeries->execute(array($_SESSION['id']));
				}
				else{
					$autresSeries = $bdd->query('SELECT * FROM serie ORDER BY ordrePres'); //try - catch ?
				}
				if ($autresSeries->rowCount()!=0) 
				{ // Si il y'a des résultats
					$t=0;
					while ($enregistrement = $autresSeries->fetch())
					{
						displaySerie($enregistrement);
					} // Fin instruction while

				} else { // Pas de résultat trouvé
					echo "Il n'y a aucune autre série.";
				}
				$autresSeries->closeCursor();
				?>



			<input type="hidden" id="idToSupprForm" name="idToSuppr" value="">
			</form>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>


