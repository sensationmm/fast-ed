<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
*/
get_header();  
$pageType = '/blog/';
?>

	<?php echo output_banner(6967); //blog page banner ?>
	
	<div class="body">

		<article class="col-main last">
			<h1><?php echo $pageObj->post_title; ?></h1>

			<div class="article-social">
				<?php echo date('j F Y', strtotime($post->post_date)); ?>
			</div>

			<?php
				$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($pageObj->ID), 'large');
				if($featuredImage != '')
					echo '<div class="article-float">'.get_the_post_thumbnail($pageObj->ID, array(440,600)).'</div>';

				echo apply_filters('the_content', $pageObj->post_content);
			?>

			<div class="tags">
				
				<?php the_tags( '<span>TAGS:</span> ', ', ' ); ?> 
			    <div class="button back red"><a href="/blog/" title="Back to blog">&lt; BLOG</a></div>
			</div>
		</article>

		<section class="col-left">
		<?php
			echo output_filter($pageType, 'article', filter_link($pageType,'search','all'));

			echo output_adverts(1); 
		?>
		</section>
	</div>

<?php get_footer(); ?> 