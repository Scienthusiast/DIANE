<?php
	require_once("verifSessionProf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Problem Creation Interface</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
<script type="text/javascript" src="static/js/view.js"></script>

</head>
<body id="main_body" >
	<?php include("headerEnseignant.php"); ?>
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>				
					<div class="form_description" style="display:inline-block">
			<form id="form_470585" class="appnitro" name="mainform" method="post" action="">
		<h3>Créer un problème le plus simplement possible</h3>
			<ul>		<li id="li_4" >
		<label class="description" for="element_4">Ecriture d'un énoncé</label>	
		<div>	<!-- <input id="property" type="button" name="prop" value="OK" onClick="parent.location='ProblemCreation.php'"/> -->
		</div>
		<a  href="DirectProblemCreation.php"><img src="static/images/pbm.png" heigth=40px width=52px style="cursor:hand;"></a>
		<p class="guidelines" id="guide"><small>Choisissez cette option pour construire rapidement un nouveau problème</small></p>
		</li>	</ul>	
		
		<h3>Créer un problème avec des propriétés avancées</h3>


		<?php
		if($_SESSION['accountType'] == 'chercheur'){
			echo '<li id="li_5" >';
			echo '<label class="description" for="element_5">Création d\'un nouveau template </label>';
			echo '	<div>	<!--<input id="property" type="button" name="prop" value="OK" onClick="parent.location=\'ProblemCreation.php\'"/>-->';
			echo '</div>';
			echo '<a  href="ProblemCreation.php"><img src="static/images/template.png" heigth=40px width=52px style="cursor:hand;"></a>';
			echo '<p class="guidelines" id="guide_5"><small>Choisissez cette option pour construire un type de problème à partir de 0</small></p>';
			echo '</li>';
			echo '<li id="li_6" >';
			echo '<label class="description" for="element_6">Partir d\'un template existant </label>';
			echo '<div>';
			echo '<!-- <input id="t" type="button" name="prop" value="OK" onClick="parent.location=\'affichage.php\'"/>  -->';
			echo '</div>';
			echo '<a  href="copyATemplate.php"><img src="static/images/template_modif.png" heigth=38px width=100px style="cursor:hand;"></a>';
			echo '<p class="guidelines" id="guide_6"><small>Choisissez cette option pour construire un type de problème à partir d\'un autre type de problème</small></p>';
			echo '</li>';
		}
		?>

		<li id="li_7" >
			<label class="description" for="element_7">Utiliser un template pour générer un problème </label>
			<div><!-- <input id="pt" type="button" name="prop" value="OK" onClick="parent.location='choixPbm.php'"/>-->
			</div> 
			<a  href="choixPbm.php"><img src="static/images/template_instanciate.png" heigth=80px width=50px style="cursor:hand;"></a>
			<p class="guidelines" id="guide_6"><small>Cette étape est obligatoire pour finaliser la construction d'un énoncé. </small></p> 
		</li>		</ul>
		</form>	
	
	</div>
	</div>
	<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>