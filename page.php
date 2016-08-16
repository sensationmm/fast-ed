<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
*/
get_header();  
?>

	<?php echo output_banner($pageObj->ID); ?>
	
	<div class="body">

		<article class="col-main">
			<h1>
			<?php 
				$displayTitle = get_field('page_display_title', $pageObj->ID);
				echo ($displayTitle == '') ? $pageObj->post_title : $displayTitle; 
			?>
			</h1>

			<?php echo apply_filters('the_content', $pageObj->post_content); ?>
		</article>

		<section class="col-right">

		<?php
			$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($pageObj->ID), 'large');
			if($featuredImage != '')
				echo '<div class="advert">'.get_the_post_thumbnail($pageObj->ID).'</div>';
		?>

			<div class="cols">
				<div class="news">
			    	<div class="col-inner">
				    	<h2>Where's Ed?</h2>

				    	<?php
					    	$listings = array('post_type' => 'event',
									  'orderby' => 'meta_value',
									  'order' => 'ASC',
									  'meta_key' => 'event_date',
									  'posts_per_page' => 4);

							$events = new WP_Query($listings);

							if ($events->have_posts() ) : 

								while ( $events->have_posts() ) : $events->the_post();
									$ID = get_the_ID();
									$title = get_the_title();
									echo '<div class="event">';
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

				    	<div class="view-all nospan"><a href="/events/" title="View all">View all &gt;</a></div>
				    	<div class="clear"></div>
					</div>
			    </div>
			</div>

			<div class="advert"><?php echo apply_filters('the_content', '[custom-facebook-feed]'); ?></div>
		</section>
	</div>

<?php get_footer(); ?> 