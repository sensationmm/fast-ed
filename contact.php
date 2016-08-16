<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
 * Template Name: Contact
*/
get_header();  
?>

	<?php echo output_banner($pageObj->ID); ?>
	
	<div class="body">

		<article>
			<h1><?php echo $pageObj->post_title; ?></h1>

			<?php echo apply_filters('the_content', $pageObj->post_content); ?>

			<div class="cols">
				<div class="col2">
					<div class="grey-box"><?php echo apply_filters('the_content', '[contact-form-7 id="7009" title="Get in touch with Ed"]'); ?></div>
				</div>

				<div class="col2">
					<div class="grey-box"><?php echo apply_filters('the_content', '[contact-form-7 id="7010" title="Enquire about an appearance"]'); ?></div>
				</div>
			</div>
		</article>
	</div>

<?php get_footer(); ?> 