<?php
	require_once("verifSessionProf.php");
	$_default_type = 1;
	require_once("conn_pdo.php");
	if (isset($_POST['enonce'])){

		$enonce=$_POST['enonce'];

		if (isset($_POST['type'])){
			$type = $_POST['type'];
		} else{$type = $_default_type;}

		if (isset($_POST['id'])){
			$idTemplate=$_POST['id'];
		} else{$idTemplate = NULL;}//TODO : surement, changer "id". Voir quand j'utiliserai les template

		if (isset($_POST['replacements'])){
			$replacements=$_POST['replacements'];
		} else{$replacements = NULL;}

		$req = $bdd->prepare('INSERT INTO pbm (enonce, type, idCreator, idTemplate, replacements, visible) VALUES (:enonce, :type, :idCreator, :idTemplate, :replacements, :visible)');
		$req->execute(array(
			'enonce' => $enonce,
			'type' => $type,
			'idCreator' => $_SESSION['id'],
			'idTemplate' => $idTemplate,
			'replacements' => $replacements,
			'visible' => true));

		$req->closeCursor();
		header("Location: enregistrement.php");
	}
	else{
		header("Location: ecriture_enonce.php");
	}
	
?>
