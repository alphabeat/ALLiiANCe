<?php
include('header.php');
?>
<section class="container" id="corps">
	<div class="sixteen columns">
		<h2>L'équipe</h2>
		<div id="wrapper">
			<ul id="slider">
				<li>
					<h1 id="left_title">Alpha</h1>
					<h5 id="left_poste" class="rouge">Président</h5>
					<img id="left_image" src="images/cadre.jpg" alt="test" />
					<p id="right_text">
						Jupiter is the fifth planet from the Sun and the largest planet within the Solar System. 
						It is a gas giant with mass one-thousandth that of the Sun but is two and a half times 
						the mass of all the other planets in our Solar System combined. Jupiter is classified as 
						a gas giant along with Saturn, Uranus and Neptune. Together, these four planets are sometimes 
						referred to as the Jovian or outer planets.
					</p>
				</li>
				<li>
					<h1 id="right_title">GeonPi</h1>
					<h5 id="right_poste" class="rouge">Vice-Président</h5>
					<img id="right_image" src="images/cadre.jpg" alt="test" />
					<p id="left_text">
						Rayguns are a type of fictional directed-energy weapon. They are a well-known feature of 
						science fiction; for such stories they typically have the general function of guns. According 
						to the stories, when activated, a raygun emits a ray, typically visible, usually lethal if 
						it hits a human target, often destructive if it hits mechanical objects, with properties and 
						other effects unspecified or varying.
					</p>
				</li>
				<li>
					<h1 id="left_title">Benef</h1>
					<h5 id="left_poste" class="rouge">Responsable de la communication externe</h5>
					<img id="left_image" src="images/cadre.jpg" alt="test" />
					<p id="right_text">Jupiter is the fifth planet from the Sun and the largest planet within the 
						Solar System. It is a gas giant with mass one-thousandth that ofthe Sun but is two and a 
						half times the mass of all the other planets in our Solar System combined. Jupiter is 
						classified as a gas giant along with Saturn, Uranus and Neptune. Together, these four planets 
						are sometimes referred to as the Jovian or outer planets.
					</p>
				</li>
			</ul>
			<p id="sliderNavigation">
			</p>
			<div id="sliderPagination">
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">

$("#slider").skeletonSlideShow({
	navigationContainer: '#sliderNavigation',
	paginationContainer: '#sliderPagination',
	markupNavigation: false,
	height: 300,
	width: 900,
	visibleFor: 7500,
	pluginLoaded: function(){
		$('#sliderNavigation .previous_page').html('<img src="images/arrow_left.png" alt="<" />');
		$('#sliderNavigation .next_page').html('<img src="images/arrow_right.png" alt=">" />');
	}
});
</script>
<?php 
include('footer.php');
?>