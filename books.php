<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
 * Template Name: Books
*/
get_header();  
$pageType = $_SERVER["REQUEST_URI"];
if(strpos($pageType, '?') !== false)
	$pageType = substr($pageType, 0, strpos($pageType, '?'));
?>

	<?php echo output_banner($pageObj->ID); ?>
	
	<div class="body">
		<a name="body"></a>
		<article>
		<?php
			if(!is_tag())
				echo '<h1>'.$pageObj->post_title.'</h1>';
			else { 
				echo '<h1>'.$tagObj->name.' Recipes</h1>';
			}
			echo apply_filters('the_content', $pageObj->post_content);



			$listings = array('post_type' => 'book');

			$books = new WP_Query($listings);

			if ($books->have_posts() ) : 
				echo '<div class="cols">';

				while ( $books->have_posts() ) : $books->the_post();
					$ID = get_the_ID();
					$title = get_the_title();

					echo '<div class="col4">';
					echo '<div class="article-image">';
					$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'large');
					echo '<a href="'.get_permalink($ID).'" title="View '.$title.'">';
					if($featuredImage != '')
						echo '<img src="'.$featuredImage[0].'" />';
					else
						echo '<img src="assets/images/awaiting-image.jpg" />';
					echo '</a>';
					echo '</div>';
					echo '</div>';

				endwhile;
				echo '</div>';
			endif;
	    ?>
		</article>
	</div>

<?php get_footer(); ?> 