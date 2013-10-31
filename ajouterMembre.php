<?php

	$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	$admin_password = 'azerty'; //->Définir un password
	
	if(isset($_POST['submit'])){

		if($_POST['admpwd'] == $admin_password){ //Password admin pour éviter que quelqu'un n'ajouter un membre alors qu'il n'est pas dans notre liste (en cas de piratage de nos pc)
		
			if(!empty($_POST['pseudo'])){
			
				if(!empty($_POST['pwd'])){
				
					$query = $bdd->prepare('INSERT INTO membres (pseudo, password) VALUES (?, ?)');
					$pwd = hash('sha256', $_POST['pwd']);
					$query->execute(array($_POST['pseudo'], $pwd));
					$query->closeCursor();
				}
				else
					echo 'Veuillez entrer un mot de passe';
			}
			else
				echo 'Veuillez entrer un pseudo';

		}
		else
			echo 'Mauvais mot de passe admin';
	}

include("header.php");
?>
<link type="text/css" rel="stylesheet" href="stylesheet.css" />

	<div class="container">
		<div class="sixteen columns">

			<h1>Ajouter un membre</h1>
					
			<div class="barre"></div>
		
			<form action="ajouterMembre.php" method="post">
					<p>
						<label for="pseud">Pseudo :</label>
						<input type="text" name="pseudo" id="pseud" maxlength="10" />
					</p>
					<p>
						<label for="text">Mot de passe : </label>
						<input type="password" name="pwd" maxlength="20" />
					</p>
					<p>
						<label for="text">Mot de passe admin : </label>
						<input type="password" name="admpwd" maxlength="20" />
					</p>

					<input type="submit" name="submit" id="submit" />
				</form>

		</div>
	</div>


	
<?php
include("footer.php");
?>