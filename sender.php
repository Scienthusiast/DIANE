
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Questions</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="userscript.js"></script>

</head>
<body id="main_body" >
<?php if (isset($_POST["properties"])){
	$test=$_POST["properties"];
	 foreach ($test as $t){echo 'You selected ',$t,'<br />';} 


}?>

	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>
		<form id="form_470585" class="appnitro"  method="post" action="properties.php" name="formulaire">
			<input type="hidden" name="type" value="HereAType"/>
			<input type="hidden" name="identification" value="HereAType"/>
			<input type="hidden" name="target" value="HereAtarget"/>
			<input type="hidden" name="infos" value="HereTheInformations"/>
			<input type="hidden" name="sender" value="<?php echo(basename($_SERVER['REQUEST_URI']));?>"/>
			<input type="submit" value="send"/>			
					
		</form>
	</body>
</html>