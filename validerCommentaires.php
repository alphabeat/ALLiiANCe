<?php
	$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	if(isset($_POST['submit'])){
	
		if(!empty($_POST['pseudo'])){
			
				if(!empty($_POST['pwd'])){
				
					if(!isset($_SESSION['timeWrongPWD']) || (time() - $_SESSION['timeWrongPWD']) > 3 ){ //Pour éviter le bruteforce
					
						$query = $bdd->prepare('SELECT COUNT(*) AS nb FROM membres WHERE pseudo=? AND password=?');
						$pwd = hash('sha256', $_POST['pwd']);
						$query->execute(array($_POST['pseudo'], $pwd));
						$donnees=$query->fetch();
						
						if($donnees['nb'] == 1){ //Un couple pseudo/mot de passe a été trouvé, on peut entrer les informations dans la base de données
						
							foreach($_POST AS $key => $value){
							
								if(substr_count($key, 'commentaire') == 1){
								
									$pos = strpos($key, '_')+1;
									$id = substr($key, $pos);
									if(is_numeric($id)){
										$query = $bdd->prepare('UPDATE commentaire SET valider = ? WHERE id_commentaire = ?');
										$query->execute(array($value, $id));							
										$query->closeCursor();
									}
								}
							}
						}
						else{
							echo 'Mauvais pseudo/mot de passe';
							$_SESSION['timeWrongPWD'] = time();
						}
						$query->closeCursor();
						
					}
					else
						echo 'Veuillez attendre quelques seconde avant de remettre votre mot de passe';
					
				}
				else
					echo 'Veuillez entrer un mot de passe';
			}
			else
				echo 'Veuillez entrer un pseudo';

	}
	
	include("header.php");
?>
<link type="text/css" rel="stylesheet" href="stylesheet.css" />

	<div class="container">
		<div class="sixteen columns">

			<h1>Valider les commentaires</h1>
					
			<div class="barre"></div>
		
			<form action="validerCommentaires.php" method="post">
				
<?php

	$query=$bdd->query('SELECT * FROM commentaire WHERE valider = 0'); /*0 pour un commentaire en attente, 1 pour un commentaire validé, 2 s'il a été refusé*/
	$i=0;
	while($donnees = $query->fetch()){
		echo '<strong>' , $donnees['pseudo'] , '</strong> a ecrit : ' , $donnees['texte'];
		echo ' <br /> Valider : <input type="radio" name="commentaire_'. $donnees['id_commentaire'] .'" value="1" /> Ne pas repondre : <input type="radio" name="choix" value="0" /> Refuser : <input type="radio" name="choix" value="2" /><br /><div class="barre"></div>';
	$i++;
	}

?>
					<p>
						<label for="pseud">Pseudo :</label>
						<input type="text" name="pseudo" id="pseud" maxlength="10" />
					</p>
					<p>
						<label for="text">Mot de passe : </label>
						<input type="password" name="pwd" maxlength="20" />
					</p>
				
					<input type="submit" name="submit" id="submit" />
				</form>

		</div>
	</div>


	
<?php
include("footer.php");
?>