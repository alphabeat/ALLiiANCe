<link type="text/css" rel="stylesheet" href="stylesheet.css" />
<?php
/*
CREATE TABLE IF NOT EXISTS `classement` (
  `pseudo` varchar(20) NOT NULL,
  `resultat` int(11) NOT NULL,
  PRIMARY KEY (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/

/*
CREATE TABLE IF NOT EXISTS `delation` (
  `id_delation` int(11) NOT NULL AUTO_INCREMENT,
  `pseudoDelateur` varchar(20) NOT NULL,
  `pseudoPlus` varchar(20) NOT NULL,
  `pseudoMoins` varchar(20) NOT NULL,
  PRIMARY KEY (`id_delation`),
  UNIQUE KEY `pseudo_delateur` (`pseudoDelateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;*/

include('header.php');
?>
	<div class="container">
		<div class="sixteen columns">
			<br />
			<h1>Resultat</h1>
			<table id="resultat">
				<tr>
					<th>Classement</th>
					<th>Pseudo</th>
					<th>Resultat</th>
				</tr>
				<?php
				
				$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

				$query=$bdd->query('SELECT pseudo, resultat FROM classement ORDER BY 2 DESC');
				
				$i=1;
				while($donnees = $query->fetch()){
				
					echo '<tr>';
					echo '<td>' , $i , '</td>';
					echo '<td>' , $donnees['pseudo'] , '</td>';
					echo '<td>' , $donnees['resultat'] , '</td>';
					echo '</tr>';
					$i++;
				}
				?>
			</table>	
		</div>
	</div>

        
<?php

include("footer.php");
?>
