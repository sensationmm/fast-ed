<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
 * Template Name: Magazine
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

	<?php echo output_banner($pageObj->ID); ?>
	
	<div class="body">

		<article class="col-mid">
			<h1>
			<?php 
				$displayTitle = get_field('page_display_title', $pageObj->ID);
				echo ($displayTitle == '') ? $pageObj->post_title : $displayTitle; 
			?>
			</h1>

			<?php
				$intro = get_field('magazine_intro', $pageObj->ID);
				if($intro != '')
					echo '<p>'.$intro.'</p>';

				echo apply_filters('the_content', $pageObj->post_content);
			?>

			<?php
				$previewLast = get_field('magazine_last_week', $pageObj->ID);
				$previewThis = get_field('magazine_this_week', $pageObj->ID);
				$previewNext = get_field('magazine_next_week', $pageObj->ID);

				if($previewLast.$previewNext.$previewThis != '') {

					echo '<div class="magazine-content">';
					if($previewLast != '')
						echo '<div class="magazine-week"><h2>Last Week</h2>'.$previewLast.'</div>';

					if($previewThis != '')
						echo '<div class="magazine-week"><h2>This Week</h2>'.$previewThis.'</div>';

					if($previewNext != '')
						echo '<div class="magazine-week"><h2>Next Week</h2>'.$previewNext.'</div>';
					echo '</div>';
				}
			?>

			<div class="button red learnmore">
			<?php
				$link = get_field('magazine_link', $pageObj->ID);
				$label = get_field('magazine_label', $pageObj->ID);

				echo '<a href="'.$link.'" title="'.$label.'" target="_blank">'.$label.'</a>';
			?>	
			</div>
		</article>

		<section class="col-sub">
		<?php
			$logo = get_field('magazine_logo', $pageObj->ID);
			$cover = get_field('magazine_cover', $pageObj->ID);
			$preview1 = get_field('magazine_preview_1', $pageObj->ID);
			$preview2 = get_field('magazine_preview_2', $pageObj->ID);
			$preview3 = get_field('magazine_preview_3', $pageObj->ID);

			echo '<div class="logo"><img src="'.$logo.'" /></div>';

			if($preview1.$preview2.$preview3 == '')
				echo '<div class="advert"><img src="'.$cover.'" /></div>';
			else {
				echo '<div id="swiper-preview" class="swiper-container">';
				echo '<div class="swiper-wrapper">';
				echo '<div class="swiper-slide"><img src="'.$cover.'" /></div>';
				if($preview1 != '')
					echo '<div class="swiper-slide"><img src="'.$preview1.'" /></div>';
				if($preview2 != '')
					echo '<div class="swiper-slide"><img src="'.$preview2.'" /></div>';
				if($preview3 != '')
					echo '<div class="swiper-slide"><img src="'.$preview3.'" /></div>';
				echo '</div>';

				echo '<div id="swiper-preview-next" class="slider-next swiper-button-next"></div>';
				echo '<div id="swiper-preview-prev" class="slider-prev swiper-button-prev"></div>';
				echo '</div>';
			}
		?>
			
			
		</section>
	</div>

<?php get_footer(); ?> 