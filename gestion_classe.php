<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	

	if(isset($_SESSION['class_form'])){
		unset($_SESSION['class_form']); //Pour le moment c'est très mal géré donc autant supprimer
	}

	$n_visible = 3;
	$n_max_student = 99;

	function displayClasse($enregistrement){
		// $limText=300;
		// $enonce = $enregistrement['enonce'];
		// $id= $enregistrement['idPbm'];

		// if (strlen($enonce) > $limText) 
		// {
		// 	$enonce=substr($enonce, 0, $limText).'[...]';
		// }

		// echo "<li>";
		// 	echo "<div class=\"problem_s\">";
		// 		echo "<span class=\"problem_select\">";
		// 			echo "<input type=\"checkbox\" class=\"check_pbms\" name=\"check_pb[]\" value=\"".$id."\"></input>";
		// 		echo "</span>";
		// 		echo "<span class=\"problem_text\">";
		// 			echo $enonce;
		// 		echo"</span>";

		// 	echo"</div>";
		// echo"</li>";
		echo "<br/><br/>";
		echo"Votre classe : ";
		echo $enregistrement['nom'];
		echo "<br/><br/>";

	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Gestion de classe</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
	</head>
	<body id="main_body">
		<?php include("headerEnseignant.php"); ?>
			<div id="form_container">
			<h1><a>Untitled Form</a></h1>
				<div>

				<?php

					if(isset($_SESSION['feedback_assignExercices'])){
						echo '<p id=feedbackAssignExercices>'.$_SESSION['feedback_assignExercices'].'</p>';
						unset($_SESSION['feedback_assignExercices']);
					}


					$vosClasses = $bdd->prepare("SELECT * FROM classe WHERE idCreator = ?");
					$vosClasses->execute(array($_SESSION['id']));
					$vosClassesFlag = False; //flag, vaut vrai quand l'account connecté a créé des séries
					$n_classes = $vosClasses->rowCount();
					if($n_classes > 0){
						$vosSeriesFlag = True;
						if($n_classes == 1){
							echo"<h3>Votre classe</h3>";
						}
						else{
							echo"<h3>Vos classes</h3>";
						}
						
						while ($enregistrement = $vosClasses->fetch())
						{
							displayClasse($enregistrement);
						} 
					}
					else{
						echo "Vous n'avez actuellement aucune classe.";
					}
					$vosClasses->closeCursor();
				?>



				<?php
					if($n_classes >0){
						if($n_classes == 1){
							echo "<h3>Assigner une série d'exercices à votre classe</h3>";
						}
						else {
							echo "<h3>Assigner une série d'exercices à une de vos classes</h3>";
						}

						?>
						<form action="assignExercices.php" method="post" class="appnitro" id="formulaire_assignation_exercices">
							<ul>

								<?php
								if($n_classes > 1){
								 	$vosClasses = $bdd->prepare("SELECT * FROM classe WHERE idCreator = ?");
									$vosClasses->execute(array($_SESSION['id']));
									echo '<li id="li_993" >';
									echo '	<label class="description" for="element_993">Choix de la classe</label>';
									echo '	<div>';
									echo '		<select id="f2_classe" name="classe">';
									while ($enregistrement = $vosClasses->fetch()){
										echo '			<option value="'.$enregistrement['idClasse'].'">'.$enregistrement['nom'].'</option>';
									}
									echo '		</select>';
									echo '	</div>';
									echo '</li>';
									$vosClasses->closeCursor();
								}
								?>


								<li id="li_992" >
									<label class="description" for="element_992">Choix de la série</label>
									<div>
										<select id="f2_serie" name="serie">
										<?php

											$vosSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator = ? ORDER BY ordrePres");
											$vosSeries->execute(array($_SESSION['id']));
											while ($enregistrement = $vosSeries->fetch()){
												echo '<option value="'.$enregistrement['idSerie'].'">'.$enregistrement['nomSerie'].'</option>';
											} 
											$vosSeries->closeCursor();

											$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? ORDER BY ordrePres");
											$autresSeries->execute(array($_SESSION['id']));

											while ($enregistrement = $autresSeries->fetch()){
												echo '<option value="'.$enregistrement['idSerie'].'">'.$enregistrement['nomSerie'].'</option>';
											}
											$autresSeries->closeCursor();

										?>
										</select>
									</div>
									<p class="guidelines" id="guide_992"><small>Choisissez la série d'exercices que votre classe doit réaliser </small></p> 
								</li>

								<input type="submit" value="Assigner la série d'exercices">
							</ul>		
						</form>


						<?php
					} // fin de "if($n_classes >0)"
				?>



				<h3>Création d'une classe</h3>

				<p>
					En créant une classe, vous créez les profils des élèves, qui pourront accéder à DIANE et aux séries d'exercices que vous leur demanderez de faire. <br/>
					Attention, les élèves n'ont pas de mot de passe. Pour rentrer sur le site, les élèves ont besoin d'indiquer leur jour et mois de naissance, faites donc bien attention à bien rentrer ces dates de naissance. Par ailleurs, puisqu'ils n'ont pas de mot de passe individuel, gardez à l'esprit qu'il y a toujours un risque qu'un élève se fasse passer pour un autre élève.<br/>
					Si vous avez une classe multiniveau, merci de créer une classe différente pour chaque niveau.
				</p>

				<input type="button" value = "Ajouter une classe" onclick="showFormClass();"> 

				<form action="createClass.php" display="none" method="post" class="appnitro" id="formulaire_creation_classe" onsubmit ="return verifClassForm();">
					<ul>
						<li id="li_999" >
							<label class="description" for="element_999">Nom de la nouvelle classe</label>
							<div>
								<input id="f_nom_classe" name="nom_classe" class="element text large" type="text" maxlength="30" required <?php if(isset($_SESSION['class_form'])){echo "value=\"".$_SESSION['class_form']['nom_classe']."\"";}?>> 
							</div>
							<p class="guidelines" id="guide_999"><small>Vous pouvez ici nommer votre classe </small></p> 
						</li>

						<li id="li_998" ><?php //TODO: SELECT if isset()?>
							<label class="description" for="element_998">Niveau</label>
							<select id="f_niveau" name="niveau">
								<option value="CP">CP</option>
								<option value="CE1">CE1</option>
								<option value="CE2">CE2</option>
								<option value="CM1">CM1</option>
								<option value="CM2">CM2</option>
								<!--
								<option value="CP/CE1">CP/CE1</option>
								<option value="CE1/CE2">CE1/CE2</option>
								<option value="CE2/CM1">CE2/CM1</option>
								<option value="CM1/CM2">CM1/CM2</option>
								<option value="CP/CE1/CE2">CP/CE1/CE2</option>
								<option value="CE1/CE2/CM1">CE1/CE2/CM1</option>
								<option value="CE2/CM1/CM2">CE2/CM1/CM2</option>-->
								<option value="autre">Autre</option>
							</select>
							<p class="guidelines" id="guide_998"><small>Sélectionner le niveau de votre classe </small></p> 
						</li>

						<li id="li_997">
							<label class="description" for="element_997">Nom de l'école</label>
							<input id="f_nom_ecole" type="text" name="nom_ecole" class="element text large" maxlength="50" required <?php if(isset($_SESSION['class_form'])){echo "value=\"".$_SESSION['class_form']['nom_ecole']."\"";}?>>
							<p class="guidelines" id="guide_997"><small>Merci d'indiquer le nom de l'école </small></p> 
						</li>

						<li id="li_996">
							<label class="description" for="element_996">Ville</label>
							<input id="f_ville" type="text" name="ville" class="element text large" maxlength="50" required <?php if(isset($_SESSION['class_form'])){echo "value=\"".$_SESSION['class_form']['ville']."\"";}?>>
							<p class="guidelines" id="guide_996"><small>Merci d'indiquer la ville où se situe l'école </small></p> 
						</li>

						<li id="li_995">
							<label class="description" for="element_995">Remarques</label>
							<textarea id="f_remarques" name="remarques" rows="4" cols="50"><?php if(isset($_SESSION['class_form'])){echo $_SESSION['class_form']['remarques']."\"";}?></textarea>
							<p class="guidelines" id="guide_995"><small>Si vous avez des remarques particulières concernant votre classe, indiquez-les ici </small></p> 
						</li>
						<!--
						<li id="li_994">
							<label class="description" for="element_994">Élèves</label>
							<p>Il vous faudra suivre un format spécifique pour rentrer les élèves. Sur chaque ligne, il faut mettre le prénom, le nom, la date de naissance au format JJ/MM/AAAA, et le sexe ("f" ou "m") séparés par des points virgules</p>
							<textarea id="f_eleves" name="eleves" rows="20" cols="50" placeholder="prénom_élève_1;nom_élève_1;date_naissance_élève_1;sexe"><?php if(isset($_SESSION['class_form'])){echo $_SESSION['class_form']['eleves']."\"";}?></textarea>
							<p class="guidelines" id="guide_994"><small>Mettez les prénoms, noms et date de naissance de tous vos élèves en suivant le format "prenom;nom;JJ/MM/AAAA;sexe"</small></p> 
						</li>
						-->

					<!-- <form display="block" method="post" class="appnitro" id="formulaire_ajout_eleve" onsubmit ="return verifClassForm();"> -->
						</ul>

						<h3>Elèves</h3>
						<ul>
						<?php
							$invis = "";
							for($i = 1; $i<$n_max_student; $i++){
								if($i>$n_visible){
									$invis = ' style="display:none"';
								}
								echo "<li id=li_add_student_form_".$i.$invis.">";
									echo "<div class=\"add_student_form\">";
										echo '<label class="label_add_student_form" for="add_student_firstname_'.$i.'">Prénom</label>';
										echo '<span class="add_student_span">';
											echo '<input id="add_student_firstname_'.$i.'" name="add_student_firstname[]" class="element text" type="text">';
										echo '</span>';

										echo '<label class="label_add_student_form" for="add_student_name_'.$i.'">Nom</label>';
										echo '<span class="add_student_span">';
											echo '<input id="add_student_name_'.$i.'" name="add_student_name[]" class="element text" type="text">';
										echo '</span>';

										echo '<label class="label_add_student_form" for="add_student_birthday_'.$i.'">Date de naissance</label>';
										echo '<span class="add_student_span">';
											echo '<input id="add_student_birthday_'.$i.'" name="add_student_birthday[]" type="date">';
										echo '</span>';

										echo '<label class="label_add_student_form" for="add_student_sex_'.$i.'">Sexe</label>';
										echo '<span class="add_student_span">';
											echo '<select id="add_student_sex_'.$i.'" name="add_student_sex[]">';
												echo '<option value="f">Fille</option>';
												echo '<option value="m">Garçon</option>';
											echo '</select>';
										echo '</span>';

									echo"</div>";
								echo"</li>";
							}
							?>
						</ul>
						<input type="button" value="Élève Supplémentaire" id="button_add_student" onclick="showOneMoreStudent();">
						<input type="submit" value="Créer la classe">
				</form>

				</div>
			</div>
		<img id="bottom" src="static/images/bottom.png" alt="">

		<script type="text/javascript">
			var n_eleves_actuels =<?php echo $n_visible;?>;

			function showFormClass(){
				class_form = document.getElementById("formulaire_creation_classe");
				class_form.style.display = 'block';
				add_student_form = document.getElementById("formulaire_ajout_eleve");
				add_student_form.style.display = 'block';
			}

			function verifClassForm(){
				// f_nom_classe = document.getElementById("f_nom_classe");
				// f_niveau = document.getElementById("f_nivea");
				// f_nom_ecole = document.getElementById("f_nom_ecole");
				// f_ville = document.getElementById("f_ville");
				// f_remarques = document.getElementById("f_remarques");
				// f_eleves = document.getElementById("f_eleves");

				// if(verifEleves(f_eleves.value)){
				// 	return true;
				// }
				
				return false;
			}

			function removeBlankLines(lines){
				
				var linesWithoutBlankLines = new Array();
				for (i = 0; i < lines.length; i++) { 
				    if(lines[i].trim()!=""){
				    	linesWithoutBlankLines.push(lines[i]);
				    }
				}
				return(linesWithoutBlankLines);
			}

			function checkDateValidityOrReturnDate(dateString){
				var regDate=/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/;
				var values=dateString.match(regDate);
				if(!values){
					return false;
				}
				return values;
			}

			function verifEleves(string){
			    if (!string) {
			        alert("Rentrez des élèves");
			        return false;
			    }
				var table=string.split("\n");
				table2=removeBlankLines(table);
				for (i = 0; i < table2.length; i++) {
					var eleve=table2[i].split(";");
					if(eleve.length!=4){
						alert("à la ligne "+(i+1)+" le format n'est pas celui attendu");
						return false;
					}
					if((eleve[0]).trim()==""||(eleve[1]).trim()==""){
						alert("à la ligne "+(i+1)+" problème avec le nom/prénom");
						return false;
					}
					var dateString=checkDateValidityOrReturnDate(eleve[2]);
					if(!dateString){
						alert("La date à la ligne "+(i+1)+" n'est pas sous le format JJ/MM/AAAA");
						return false;
					}
					if( ((eleve[3]).trim()!="m") && ((eleve[3]).trim()!="f") ) {
						alert("à la ligne "+(i+1)+" problème avec le sexe");
						return false;
					}
				}
				return confirm(" Vous vous appretez à créer une classe avec "+i+" élèves");
			}

			function showOneMoreStudent(){
				if(n_eleves_actuels <<?php echo $n_max_student;?>){
					n_eleves_actuels++;
					var id_name = String("li_add_student_form_").concat(n_eleves_actuels);
					var newElem = document.getElementById(id_name);
					newElem.style.display ="block";
				}
				else{
					alert("Vous avez atteint le nombre maximum d'élèves affichés. Si votre classe comprend plus de "+<?php echo $n_max_student;?>+" élèves, merci de former plusieurs classes.");
				}
			}

		</script>
	</body>
</html>







