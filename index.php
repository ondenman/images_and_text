<!doctype html>
<!--
	HTML5 Reset: https://github.com/murtaugh/HTML5-Reset
	Free to use
-->

<!--[if lt IE 7 ]> <html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 ie-lt10 ie-lt9 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 ie-lt10 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. --> 

<head>
	<meta charset="utf-8">
	
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>Photos and Circles</title>

	<!--  Mobile Viewport
	http://j.mp/mobileviewport & http://davidbcalhoun.com/2010/viewport-metatag
	device-width : Occupy full width of the screen in its current orientation
	initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
	maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width (wrong for most sites)
	-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	
	<link rel="shortcut icon" href="favicon.ico" />

	<link rel="stylesheet" href="style/reset.css" />
	<link rel="stylesheet" href="style/style.css" />
	<link rel="stylesheet" href="style/circle-colours.css" />
	<link rel="stylesheet" href="style/text-colours.css" />
</head>

<body>
	<div class="wrapper">
			<div id="slides">
	  			<div class="slides-container">
					    <?php 
					    	include("Parsedown.php");
					    	$images = array();
					    	$texts = array();
					    	$indexes = array();
					    	$idnames = array();
					    	$Parsedown = new Parsedown();

					    	$i=0;

					    	if (file_exists('assets')) {
						    	foreach (glob('assets/*') as $dir) {
										$imgfilepath = $dir."/*.";

								    	foreach (glob($imgfilepath."{jpg,png,gif,JPG,PNG,GIF,jpeg,JPEG}", GLOB_BRACE) as $img) {

								    		if (is_null($img)) { echo ('!!');};

								    		$index = sprintf('%02d', $i+1);
								    		$hashindex = "#".$index;

								    		$filename = basename($index);
								    		$idname = pathinfo($img, PATHINFO_FILENAME);

								    		foreach (glob($dir."/*.md") as $md ) {
													$markdown = file_get_contents($md);
													$content = $Parsedown->text($markdown);
								    		}
					    		
							    		echo "<img id='#$filename' src='$img' width='0' height='0' />";
							    		$images[$hashindex] = "$img";
							    		$texts[$hashindex] = "$content";
							    		$idnames[$hashindex] = $idname;
					    		
							    		$indexes[$i] = $hashindex;
							    		$i++;

							    	}
									}
								} else { echo("<h1>Something's wrong!<br>I can't find the assets directory. Has it been moved/deleted/renamed?</h1>");}
					    ?>
	  			</div>
			</div>
	  			
			<a id="circle-button" title="Clicking this shows the modal"><div class="circle" id="1"></div></a>
			<article>
					<div id="text" class="text-window content scrollbox"></div>
			</article>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
	<script>window.jQuery || document.write("<script src='libs/jquery-1.11.0.min.js'>\x3C/script>")</script>

	<script src="js/libs/jquery.animate-enhanced.min.js"></script>
	<script src="js/libs/jquery.superslides.min.js"></script>
	<script src="js/libs/jquery.jscrollpane.js"></script>
	<script src="js/libs/jquery.event.swipe.js"></script>
	<script src="js/libs/jquery.event.move.js"></script>
	<script>

		$( document ).ready(function() {
			  if (!$.browser.webkit) {
              $('#text').jScrollPane();
          };	
			var win = $(this);
			window.scrollTo(0,1);
 			
			<?php
			$js_array = json_encode($images);
			echo "var images = ". $js_array . ";\n";

			$js_array = json_encode($texts);
			echo "var texts = ". $js_array . ";\n";
			
			$js_array = json_encode($indexes);
			echo "var indexes = ". $js_array . ";\n";

			$js_array = json_encode($idnames);
			echo "var idnames = ". $js_array . ";\n";
			?>

			function resizeTextWindow(windowWidth) {
				
				if (windowWidth < 600) {
					$('#text').css("bottom","120px"),
					$('.circle').css("left","42%"),
					$('.circle').css("width","50px"),
	 				$('.circle').css("height","50px"),

					$('#text').css("left","0%"),
					$('#text').css("right","0%"),
	 				$('#text').css("width","100%")	
				}

				else if (windowWidth < 800) {
					$('#text').css("left","0%"),
					$('#text').css("right","0%"),		
	 				$('#text').css("bottom","30%"),
	 				$('#text').css("width","100%"),

	 				$('.circle').css("width","50px"),
	 				$('.circle').css("height","50px")
	 				$('.circle').css("bottom","5%"),
	 				$('.circle').css("left","7%")
				}

				else {
					$('#text').css("left","0%"),
	 				$('#text').css("right","auto"),
	 				$('#text').css("top","auto"),
	 				$('#text').css("bottom","18%"),
	 				$('#text').css("max-width","600px"),
	 				$('#text').css("width","auto")
	 				$('.circle').css("width","30px"),
	 				$('.circle').css("height","30px"),
	 				$('.circle').css("bottom","2.5%"),
	 				$('.circle').css("left","1.5%")

				}
			}

			function updateText (forIndex) {
			// Need to find filename at forIndex
			var idAtIndex = indexes[forIndex];
			var textFile = texts[idAtIndex];
			var theNumber = forIndex+1;
			var newID = idnames[idAtIndex];

			$(".circle").attr("id",newID);

			document.getElementById('text').innerHTML = textFile;
			$('#text').find('a').attr("target","blank");
			};
    	
    	$('#slides').superslides({
				animation: "fade",
				hashchange: "true",	
			});

			var current = $('#slides').superslides('current');
			// Update text
			updateText(current);
			var win = $(this);
			var windowWidth = win.width();
			resizeTextWindow(windowWidth);

			$(document).on('animated.slides', function() {
			// Called when slide changes
			var current = $('#slides').superslides('current');
			// Update text
			updateText(current);
			});

			$('#slides').click(function(){
      	var $slides = $('#slides');
      	var onComplete = function () {$('#text').animate({opacity:"show"});}
				$(function() {
      			$slides.data('superslides').animate('next');
      			$('#text').animate({opacity:"hide"});
  				});	
			});

			$('#circle-button').click(function(){
				if ( $('#text').css('opacity') == 0) 
					$('#text').animate({opacity:"show"});
				else
					$('#text').animate({opacity:"hide"});
			});

			$('#text').click(function(e){
				var target = $(e.target);
				if(target.is('a')) { return true }
					else {
						$('#text').animate({opacity:"hide"});
					}
			});

			$(window).on('resize', function(){
				var win = $(this);
				var windowWidth = win.width();
				resizeTextWindow(windowWidth);

			});

			$('img').bind('contextmenu', function(e) { return false; });
		
			$('#slides').on('swipeleft', function(e) {
  			var $slides = $('#slides');
				var onComplete = function () {$('#text').animate({opacity:"show"});}
				$(function() {
      			$slides.data('superslides').animate('next');
      			$('#text').animate({opacity:"hide"});
  				});	
			})

			$('#slides').on('swiperight', function(e) {
  			var $slides = $('#slides');
				var onComplete = function () {$('#text').animate({opacity:"show"});}
				$(function() {
      			$slides.data('superslides').animate('previous');
      			$('#text').animate({opacity:"hide"});
  				});	
			})
		});
		</script>
</body>
</html>