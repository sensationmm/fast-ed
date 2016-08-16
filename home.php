<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
 * Template Name: Home
*/
get_header();  
?>

	<div class="banner">
	<?php
		$banner1 = get_field('hp_banner_1', $pageObj->ID);
		$banner2 = get_field('hp_banner_2', $pageObj->ID);
		$banner3 = get_field('hp_banner_3', $pageObj->ID);
		$banner4 = get_field('hp_banner_4', $pageObj->ID);
		$banner5 = get_field('hp_banner_5', $pageObj->ID);

		if($banner2.$banner3.$banner4.$banner5 != '') {
			echo '<script type="text/javascript" src="js/swiper.min.js"></script>
					<link rel="stylesheet" href="assets/css/swiper.min.css" type="text/css" />
					<script type="text/javascript">
					$(document).ready(function() {
					var mySwiperHire = new Swiper ("#swiper-banner", {
							// Optional parameters
							direction: "horizontal",
							loop: true,
							slidesPerView: 1,
							speed: 1000,
					    
						    // Navigation arrows
						    nextButton: "#swiper-banner-next",
						    prevButton: "#swiper-banner-prev",
					        pagination: ".swiper-pagination",
					        paginationClickable: true,
					        autoplay: 5000
					    });
					});
					</script>';
			echo '<div id="swiper-banner" class="swiper-container">';
			echo '<div class="swiper-wrapper">';
			echo '<div class="swiper-slide"><img src="'.$banner1.'" /></div>';
			if($banner2 != '')
				echo '<div class="swiper-slide"><img src="'.$banner2.'" /></div>';
			if($banner3 != '')
				echo '<div class="swiper-slide"><img src="'.$banner3.'" /></div>';
			if($banner4 != '')
				echo '<div class="swiper-slide"><img src="'.$banner4.'" /></div>';
			if($banner5 != '')
				echo '<div class="swiper-slide"><img src="'.$banner5.'" /></div>';
			echo '</div>';
			echo '</div>';

		} else {
			echo '<div class="banner-inner"><img src="'.$banner1.'" /></div>';
		}
	?>
		
	</div>
	
	<div class="body">
		<div class="swiper-pagination"></div>
		<article class="home">
		<?php 
			$displayTitle = get_field('page_display_title', $pageObj->ID);
			echo '<h1>'.(($displayTitle == '') ? $pageObj->post_title : $displayTitle).'</h1>'; 

			echo apply_filters('the_content', $pageObj->post_content);
		?>
		</article>

	    	<div class="recipe-finder">
			    <div class="col4">
			    	<h2>Recipe Finder</h2>
			    	<p>There are hundreds of recipes to search on the site! You can search by title, dish or ingredients.</p>
			    	<form method="get" action="/recipes/">
					<input type="hidden" name="filter" value="true" />
					<input name="search" type="text" value="Enter search" onfocus="this.select();" />
					<div class="button red" style="clear:both;"><input type="submit" value="Find a recipe" /></div>
					</form>
			    </div>

			    <?php
			    	$recipe1 = get_field('hp_recipe_1', $pageObj->ID);
			    	$recipe2 = get_field('hp_recipe_2', $pageObj->ID);
			    	$recipe3 = get_field('hp_recipe_3', $pageObj->ID);
			    	$recipe4 = get_field('hp_recipe_4', $pageObj->ID);

			    	for($r=1; $r<=4; $r++) {
			    		$recipe = 'recipe'.$r;
						echo '<div class="col4 recipe">';
						echo '<a href="'.get_the_permalink($$recipe->ID).'" title="View '.$$recipe->post_title.'">';

						$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($$recipe->ID), 'large');
						if($featuredImage != '')
							echo get_the_post_thumbnail($$recipe->ID, array(220,220));
						else
							echo '<img src="assets/images/awaiting-image.jpg" />';
						echo '</a>';
						echo '<div class="recipe-label">';
						echo '<a href="'.get_the_permalink($$recipe->ID).'" title="View '.$$recipe->post_title.'">';
						echo $$recipe->post_title.'</a></div>';
						echo '</div>';
					}
			    ?>
	    	</div>

	    	<div class="cols">
		    	<?php
		    		$text = get_field('hp_bhg_text', $pageObj->ID);
		    		$image = get_field('hp_bhg_background_image', $pageObj->ID);
		    	?>
			    <div class="col3 bhg" style="background-image:url(<?php echo $image; ?>);">
			    	<div class="feature-logo"><img src="assets/images/logo-bhg.png" /></div>
			    	<div class="feature-info">
			    		<div class="feature-info-text"><?php echo $text; ?></div>
			    		<div class="button"><a href="/better-homes-gardens/" title="Find out more">Find out more</a></div>
			    	</div>
			    </div>

		    	<?php
		    		$text = get_field('hp_rc_text', $pageObj->ID);
		    		$image = get_field('hp_rc_background_image', $pageObj->ID);
		    	?>

			    <div class="col3 bhg" style="background-image:url(<?php echo $image; ?>);">
			    	<div class="feature-logo"><img src="assets/images/logo-roughcut.gif" /></div>
			    	<div class="feature-info">
			    		<div class="feature-info-text"><?php echo $text; ?></div>
			    		<div class="button"><a href="/roughcut/" title="Find out more">Find out more</a></div>
			    	</div>
			    </div>

			    <div class="col3 events">
			    	<div class="col-inner">
				    	<h2>Where's Ed?</h2>
				    	<?php
					    	$listings = array('post_type' => 'event',
									  'orderby' => 'meta_value',
									  'order' => 'ASC',
									  'meta_key' => 'event_date',
									  'posts_per_page' => 3);

							$events = new WP_Query($listings);

							if ($events->have_posts() ) : 

								while ( $events->have_posts() ) : $events->the_post();
									$ID = get_the_ID();
									$title = get_the_title();
									echo '<div class="event">';
									echo '<div class="event-image">';
									echo '<a href="/events/" title="View '.$title.'">';

									$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'large');
									if($featuredImage != '')
										echo get_the_post_thumbnail($ID, array(70,'auto'));
									else
										echo '<img src="assets/images/awaiting-image.jpg" />';

									echo '</a></div>';
									echo '<div class="event-info">';
									echo '<a href="/events/" title="View '.$title.'">';

									$eventDate = get_field('event_date', $ID);
									$eventDuration = get_field('event_duration', $ID);
									$eventDuration--; //allow for number of days to be inclusive of start date
									
									echo '<div class="event-date">';
									if($eventDuration == 0)
										echo date('j F Y', strtotime(get_field('event_date', $ID)));
									else {
				

										$date = strtotime($eventDate);
										$endDate = strtotime("+".$eventDuration." days", $date);

										echo date('j', strtotime($eventDate)).'-'.date('j F Y', $endDate);

									}
									echo '</div>';
									echo $title;
									echo '</a>';
									echo '</div>';
									echo '</div>';
								endwhile;
							endif;
						?>

				    	<div class="view-all"><a href="/events/" title="View all">View all &gt;</a></div>

				    </div>
			    </div>
			</div>


		    <div class="cols">
			    <div class="col4">
			    <?php 
			    	$img = get_field('hp_charities_image', $pageObj->ID); 
			    	$link = get_field('hp_charities_link', $pageObj->ID); 
			    	if($link != '')
			    		echo '<a href="'.$link.'">';
			    	echo '<img src="'.$img.'" />';
			    	if($link != '')
			    		echo '</a>';
			    ?>
			    </div>

			    <div class="col4">
			    <?php 
			    	$img = get_field('hp_books_image', $pageObj->ID); 
			    	echo '<a href="/books/"><img src="'.$img.'" /></a>';
			    ?>
			    </div>

			    <div class="col4 news">
			    	<div class="col-inner">
				    	<h2>Latest News</h2>

				    	<?php
					    	$listings = array('post_type' => 'post',
									  'orderby' => 'meta_value',
									  'cat' => 740,
									  'posts_per_page' => 2);

							$news = new WP_Query($listings);

							if ($news->have_posts() ) : 

								while ( $news->have_posts() ) : $news->the_post();
									$ID = get_the_ID();
									$title = get_the_title();
									echo '<div class="event">';
									echo '<div class="event-info">';
									echo $title;
									echo '<a class="read-more" href="'.get_permalink($ID).'" title="View '.$title.'">Read more &gt;</a>';
									echo '</div>';
									echo '</div>';
								endwhile;
							endif;
						?>

					    <div class="view-all"><a href="/blog/?filter=true&category=740" title="View all">View all &gt;</a></div>
					</div>
			    </div>

			    <div class="col4"><?php echo output_adverts(1); ?></div>
			</div>
	</div>

<?php get_footer(); ?> 