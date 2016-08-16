<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
 * Template Name: Events
*/
get_header();  
?>

	<?php echo output_banner($pageObj->ID); ?>
	
	<div class="body">

		<section class="col-main">
			<article>
				<h1><?php echo $pageObj->post_title; ?></h1>
				<?php echo apply_filters('the_content', $pageObj->post_content); ?>
			</article>
		

			<?php
				$listings = array('post_type' => 'event',
						  'orderby' => 'meta_value',
						  'order' => 'ASC',
						  'meta_key' => 'event_date');

				$results = new WP_Query($listings);

				if ($results->have_posts() ) : 

					while ( $results->have_posts() ) : $results->the_post();
						$ID = get_the_ID();
						$title = get_the_title();
						$content = get_the_content();

						echo '<div class="article-listing">';
						echo '<div class="article-image">';
						$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'large');
						if($featuredImage != '')
							echo get_the_post_thumbnail($ID, array(100,'auto'));
						else
							echo '<img src="assets/images/awaiting-image.jpg" />';
						echo '</div>';

						echo '<div class="article-info">';
						echo '<div class="article-title"><h2>'.$title.'</h2></div>';

						echo '<div class="article-date">';
						$eventDate = get_field('event_date', $ID);
						$eventDuration = get_field('event_duration', $ID);
						$eventDuration--; //allow for number of days to be inclusive of start date

						if($eventDuration == 0)
							echo date('j F Y', strtotime(get_field('event_date', $ID)));
						else {
	

							$date = strtotime($eventDate);
							$endDate = strtotime("+".$eventDuration." days", $date);

							echo date('j', strtotime($eventDate)).'-'.date('j F Y', $endDate);

						}
						echo '</div>';

						echo apply_filters('the_content', $content);
						echo '</div>';
						echo '</div>';

					endwhile;

				else :
					echo '<div class="no-results">';
					$noresults = get_post(6991);
					$noresultsContent = $noresults->post_content;
					$noresultsContent = str_replace('{{type}}', 'articles', $noresultsContent);
					echo apply_filters('the_content', $noresultsContent);
					echo '</div>';
				endif;
			?>
		</section>

		<section class="col-right">

			<div class="button booking red"><a href="/contact/" title="Make a booking">Make A Booking</a></div>
			<div class="cols">
				<div class="col1 news">
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
			</div>

			<div class="advert"><img src="assets/images/advert-mushrooms.jpg" /></div>
		</section>
	</div>

<?php get_footer(); ?> 