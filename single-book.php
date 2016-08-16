<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
*/

global $headerInclude;
$headerInclude = '
<script type="text/javascript" src="js/swiper.min.js"></script>
<link rel="stylesheet" href="assets/css/swiper.min.css" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {
var mySwiperHire = new Swiper ("#swiper-preview", {
		// Optional parameters
		direction: "horizontal",
		loop: true,
		slidesPerView: 1,
		speed: 500,
    
	    // Navigation arrows
	    nextButton: "#swiper-preview-next",
	    prevButton: "#swiper-preview-prev",
    });
});
</script>';
get_header();  
?>

	<?php echo output_banner(6973); //books page banner ?>

	<div class="body">

		<section class="col-left">
		<?php
			$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($pageObj->ID), 'large');
			echo '<div class="advert">';
			if($featuredImage != '')
				echo '<img src="'.$featuredImage[0].'" />';
			else
				echo '<img src="assets/images/awaiting-image.jpg" />';

			if($link != '')
				echo '<a href="'.$link.'" target="_blank" title="'.$button.'">'.$button.'</a>';

			echo '</div>';

			$button = get_field('book_button_text', $pageObj->ID);
			$link = get_field('book_button_link', $pageObj->ID);

			if($link != '') {
				echo '<div class="button booking red"><a href="'.$link.'" title="'.$button.'" target="_blank">'.$button.'</a></div>';
			}

		?>
		</section>

		<article class="col-main last">
			<h1><?php echo $pageObj->post_title; ?></h1>

			<?php
				echo apply_filters('the_content', $pageObj->post_content);

				$sample1 = get_field('book_sample_1', $pageObj->ID);
				$sample2 = get_field('book_sample_2', $pageObj->ID);
				$sample3 = get_field('book_sample_3', $pageObj->ID);
				$sample4 = get_field('book_sample_4', $pageObj->ID);
				$sample5 = get_field('book_sample_5', $pageObj->ID);

				if($sample1.$sample2.$sample3.$sample4.$sample5 != '') {
					echo '<div id="swiper-preview" class="swiper-container">';
					echo '<div class="swiper-wrapper">';
					if($sample1 != '')
						echo '<div class="swiper-slide"><img src="'.$sample1.'" /></div>';
					if($sample2 != '')
						echo '<div class="swiper-slide"><img src="'.$sample2.'" /></div>';
					if($sample3 != '')
						echo '<div class="swiper-slide"><img src="'.$sample3.'" /></div>';
					if($sample4 != '')
						echo '<div class="swiper-slide"><img src="'.$sample4.'" /></div>';
					if($sample5 != '')
						echo '<div class="swiper-slide"><img src="'.$sample5.'" /></div>';
					echo '</div>';

					echo '<div id="swiper-preview-next" class="slider-next swiper-button-next"></div>';
					echo '<div id="swiper-preview-prev" class="slider-prev swiper-button-prev"></div>';
					echo '</div>';
				}

				echo '<div class="tags">';
			    echo '<div class="button back red"><a href="/books/" title="Back to books">&lt; Books</a></div>';
				echo '</div>';
			?>
		</article>
	</div>

<?php get_footer(); ?> 