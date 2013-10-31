<?php
/* CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `texte` text NOT NULL,
  `date` date NOT NULL,
  `id_membres` int(11) NOT NULL,
  PRIMARY KEY (`id_news`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; */
?>

<?php

	$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//Si on poste quelque chose
	if(isset($_POST['submit'])){
		
		if(!empty($_POST['pseudo'])){
		
			if(!empty($_POST['text'])){

				if($_SESSION['last_comment_time'] < time()-10){

					$query=$bdd->prepare('INSERT INTO commentaire (id_news,texte,date,pseudo,valider) VALUES (:id, :texte, ' . time() . ', :pseudo, 0)'); //0 pour un commentaire en attente, 1 pour un commentaire validé, 2 s'il a été refusé
					$query->execute(array('id' => $_GET['id'], 'texte' => $_POST['text'], 'pseudo' => $_POST['pseudo']));
					$_SESSION['last_comment_time']=time();
					echo 'Votre commentaire a ete poste';
				}
				else
					echo 'Veuillez attendre quelques secondes avant de reposter votre message';
			}
			else
				echo 'Veuillez entrer un texte';
			
		}
		else
			echo 'Veuillez entrer un pseudo';
	}
	
include('header.php');
?>

<link type="text/css" rel="stylesheet" href="stylesheet.css" />


<?php


	$query=$bdd->prepare('SELECT * FROM news WHERE id_news = ?');
	$query->execute(array($_GET['id']));
	$donnees = $query->fetch();
		echo ' 
		<div class="news">
			<h2><a href="">' , $donnees['titre'] , '</a></h2>
			<p class="date">' , $donnees['date'] , '</p>
			',$donnees['texte'],'
			<div class="news_foot"></div>';

	$query->closeCursor();
?>

		<div>
		
		
<?php

	//News précèdente et news suivante
	if($_GET['id'] > 1){

		$query=$bdd->prepare('SELECT id_news, titre FROM news WHERE id_news = ?');
		$query->execute(array($_GET['id']-1));
		$prev_news=$query->fetch();
		echo '<a href="commentaires.php?id=' , $prev_news['id_news'] , '"> ' , $prev_news['titre'] , '</a>';
		$query->closeCursor();
	}
	else
		echo 'Aucune news precedente';
		
	
	$query=$bdd->prepare('SELECT id_news, titre FROM news WHERE id_news = ?');
	$query->execute(array($_GET['id']+1));
	
	if($next_news=$query->fetch()){
	
		echo '<span class="news_next"><a href="commentaires.php?id=' , $next_news['id_news'] , '">' , $next_news['titre'] , '</a></span>';
	}
	$query->closeCursor();	
?>			

		</div>	
		
		<div class="news_foot"></div>				

	</div>	
	
	<div id="commentaire">

<?php			

	$query=$bdd->prepare('SELECT COUNT(*) AS nb_commentaires FROM commentaire WHERE id_news=? AND valider=1');
	$query->execute(array($_GET['id']));
	$donnees=$query->fetch();
	if($donnees['nb_commentaires'] == 0){
			echo '<h3>Pas de commentaires</h3>';
	}
	else {

		echo '<h3>' , $donnees['nb_commentaires'];
		
		if($donnees['nb_commentaires'] == 1)
			echo ' commentaire';
		else
			echo ' commentaires';
		
		echo '</h3>';
		
		$query=$bdd->prepare('SELECT * FROM commentaire WHERE id_news=? AND valider=1');
		$query->execute(array($_GET['id']));
		
		while($donnees = $query->fetch()){

			echo '<div class="news_foot"></div>';
			echo '<div class="text_commentaire">
						<p class="pseudo"><strong>' , $donnees['pseudo'] , '</strong></p>
						<p class="date2"><strong>' , date("d-m-Y",$donnees['date']) , '</strong></p>
						<p>' , $donnees['texte'] , '</p>
				  </div>';
					
		}				

	}
	$query->closeCursor();	
?>				
				<div class="news_foot"></div>				
				
				<h3>Ajouter un commentaire</h3>
				<div class="news_foot_bordure_double"></div>
				<div class="news_foot_bordure_double"></div>
				
				<br />
				
				<form action="commentaires.php?id=<?php echo $_GET['id'] ?>" method="post">
					<p class="center">
						<label for="pseud">Pseudo :</label>
						<input type="text" name="pseudo" id="pseud" maxlength="10" />
					</p>
					<p class="center">
						<label for="text">Commentaire :</label>
						<textarea name="text" id="text"></textarea>
					</p>
					<input type="submit" name="submit" id="submit" />
				</form>
		</div>
	
<?php 
include('footer.php');
?>