<?php
	if(isset($_POST['submit'])){
	
	$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$query = $bdd->prepare('SELECT COUNT(*) AS nb FROM delation WHERE pseudoDelateur=?');
	$query->execute(array($_POST['pseudoDelateur']));
	$donnees=$query->fetch();
	if($donnees['nb'] == 0){
	
		if(isset($_POST['pseudoDelateur']) && isset($_POST['pseudoPlus']) && isset($_POST['pseudoMoins'])){

			$query = $bdd->prepare('INSERT INTO delation (pseudoDelateur, pseudoPlus, pseudoMoins) VALUES (?, ?, ?)');
			$query->execute(array($_POST['pseudoDelateur'], $_POST['pseudoPlus'], $_POST['pseudoMoins']));
			$query->closeCursor();
			
			$query = $bdd->prepare('SELECT COUNT(*) AS count FROM classement WHERE pseudo=?');
			$query->execute(array($_POST['pseudoPlus']));
			$donnees=$query->fetch();
			
			if($donnees['count'] == 1){
			
				$query = $bdd->prepare('UPDATE classement SET resultat=resultat+1 WHERE pseudo = ?');
				$query->execute(array($_POST['pseudoPlus']));
	
			}
			else{
			
				$query = $bdd->prepare('INSERT INTO classement (pseudo, resultat) VALUES (?, 1)');			
				$query->execute(array($_POST['pseudoPlus']));
	
			}
			
			$query = $bdd->prepare('SELECT COUNT(*) AS count FROM classement WHERE pseudo=?');
			$query->execute(array($_POST['pseudoMoins']));
			$donnees=$query->fetch();
			
			if($donnees['count'] == 1){
			
				$query = $bdd->prepare('UPDATE classement SET resultat=resultat-1 WHERE pseudo = ?');
				$query->execute(array($_POST['pseudoMoins']));
	
			}
			else{
			
				$query = $bdd->prepare('INSERT INTO classement (pseudo, resultat) VALUES (?, -1)');			
				$query->execute(array($_POST['pseudoMoins']));
	
			}
			
			
			echo 'Vote enregistre';

		}

	}
	else
		echo 'Pseudo deja utilise';
	
}

include("header.php");
?>

<link type="text/css" rel="stylesheet" href="stylesheet.css" />

	<div class="container">
		<div class="sixteen columns">
			<br />
			
			<form method="post" action="delation.php">
				<p>
					<label>Pseudo Delateur: </label>
					<input type="text" name="pseudoDelateur" maxlength="20" />
				</p>
				<p>
					<label>Pseudo +1 : </label>
					<input type="text" name="pseudoPlus" maxlength="20" />

					<label>Pseudo -1 : </label>
					<input type="text" name="pseudoMoins" maxlength="20" />

				</p>
			
				<input type="submit" name="submit" id="submit" />
			</form>
	
		</div>
	</div>

        
<?php

include("footer.php");
?>
