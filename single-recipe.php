<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
*/
get_header();  
?>

	<?php echo output_banner(6961); //recipes page banner ?>
	
	<div class="body">
		<article>
			<h1><?php echo $pageObj->post_title; ?></h1>

			<div class="cols">
				<div class="col2">
					<div class="recipe-image">
					<?php
						$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($pageObj->ID), 'large');
						if($featuredImage != '')
							echo get_the_post_thumbnail($pageObj->ID, array(440,600));
						else
							echo '<img src="assets/images/recipe-main-hold.jpg" />';
					?>
					</div>
					
					<div class="recipe-share">
					<?php echo apply_filters('the_content', '[shareaholic app="share_buttons" id="20786455"]'); ?>
					</div>

					<div class="recipe-tags">
					<?php
						$tags = wp_get_post_tags($pageObj->ID);
						if(sizeof($tags) > 0) {
							echo '<b>Tags</b>: ';
							$tagsList = '';
							foreach ( $tags as $tag ) {
								$tag_link = get_tag_link( $tag->term_id );
										
								$tagsList .= '<a href="'.$tag_link.'" title="'.$tag->name.' Tag" class="'.$tag->slug.'">';
								$tagsList .= strtolower($tag->name).'</a>, ';
							}
							echo substr($tagsList, 0, -2);
						}
					?>
					</div>
				</div>

				<div class="col2">
					<div class="recipe-info">
					<?php
						$serves = get_field('recipe_serves', $pageObj->ID);
						$servesNum = get_field('recipe_serves_number', $pageObj->ID);

						$serves = str_replace($servesNum, '<span>'.$servesNum.'</span>', $serves);

						if(substr_count($serves, ' ') < 2) {
							switch(strtolower(substr($serves, 0, 3))) {
								case 'ser':
									$serves .= ' people';
									break;
								case 'mak':
									$serves .= ' pieces';
									break;
							}
						}

						echo trim($serves);
					?>
					</div>

					<?php
						$prep = get_field('recipe_preparation_time', $pageObj->ID);
						if($prep != '') {
							echo '<div class="recipe-info">';
							$prep = trim($prep);
							$prep = explode(' ', $prep);
							$prep = '<span>'.$prep[0].'</span> '.$prep[1];
							$prep = str_replace('minutes', 'mins', $prep);
							echo 'Prep '.$prep;
							echo '</div>';
						}

						$cook = get_field('recipe_cooking_time', $pageObj->ID);
						if($cook != '' && trim($cook) != 'nil') {
							echo '<div class="recipe-info">';
							$cook = trim($cook);
							$cook = explode(' ', $cook);
							$cook = '<span>'.$cook[0].'</span> '.$cook[1];
							$cook = str_replace('minutes', 'mins', $cook);
							echo 'Cook '.$cook;
							echo '</div>';
						}
					?>

					<p class="intro recipe-intro"><?php echo $pageObj->post_excerpt; ?></p>

					<div class="cols">
						<div class="col2 ingredients">
							<div class="col-header">Ingredients</div>
							<ul class="ingredients">
							<?php
								$ingredients = get_field('recipe_ingredients', $pageObj->ID);
								$ingredients = strip_tags($ingredients, '<br><strong>');
								$ingredients = explode('<br />', $ingredients);
								$ingredientsList = '';
								for($i=0; $i<sizeof($ingredients); $i++) {
									if($ingredients[$i] != '' && $ingredients[$i] != ' ')
										$ingredientsList .= '<li>'.$ingredients[$i].'</li>';
								}
								$ingredientsList = str_replace('<strong>','</ul><ul class="ingredients"><li><strong>', $ingredientsList);
								$ingredientsList = str_replace('</strong>','</strong></li>', $ingredientsList);
								if(substr($ingredientsList, 0, 9) == '<li></ul>')
									$ingredientsList = substr($ingredientsList, strpos($ingredientsList, '<li><strong>'));
								echo $ingredientsList;
							?>
							</ul>
						</div>

						<div class="col2">
							<div class="col-header">Instructions</div>
							<?php 
								$instructions = $pageObj->post_content;
								$instructions = apply_filters('the_content', $instructions);
								$instructions = trim(preg_replace('/(?![ ])\s+/', ' ', $instructions));
								$instructions = str_replace('<br />','</p><p>', $instructions);
								$instructions = str_replace('<p> ','<p>', $instructions);

								$highlight = array("Professional Tip: ");
								for($h=1; $h<=10; $h++)
									$highlight[] = '<p>'.$h.' ';

								$highlightReplace = array("<strong>Professional Tip:</strong> ");
								for($h=1; $h<=10; $h++)
									$highlightReplace[] = '<p><strong>'.$h.'</strong> ';

								$instructions = str_ireplace($highlight, $highlightReplace, $instructions);
								echo $instructions;
							?>
						</div>

					</div>
				</div>
			</div>
		</article>

		<section class="col-main">
			<?php
				$showAdverts = 1;

				$servewith = get_field('_yyarpp', $pageObj->ID);
				if($servewith != '') {
					$showAdverts = 2;
					$servewith = explode(',', $servewith);

					if(sizeof($servewith) > 0) {

						echo '<div class="related-recipes">';
						echo '<div class="related-recipes-header">Serve with</div>';

						$show = (sizeof($servewith) > 4) ? 4 : sizeof($servewith);
							echo '<div class="cols">';
							for($s=0; $s<$show; $s++) {
								$serve = get_post($servewith[$s]);
								echo '<div class="col4 recipe">';
								echo '<a href="'.get_permalink($serve->ID).'" title="View '.$serve->post_title.'">';
								echo get_the_post_thumbnail($serve->ID, array(440,600)).'</a>';
								echo '<div class="recipe-over"><a href="'.get_permalink($serve->ID).'" title="View '.$serve->post_title.'">';
								echo $serve->post_title.'</a></div>';
								echo '</div>';
							}
							echo '</div>';
						echo '</div>';
					}
				}
			?>

			<div class="related-recipes">
				<div class="related-recipes-header">Similar recipes</div>
				<?php
				    $tags = wp_get_post_tags($pageObj->ID);
				     
				    if ($tags) {
					    $tag_ids = array();
					    foreach($tags as $individual_tag) 
					    	$tag_ids[] = $individual_tag->term_id;
					    $args = array(
						    'tag__in' => $tag_ids,
						    'post__not_in' => array($post->ID),
						    'post_type' => 'recipe',
						    'posts_per_page' => 4, // Number of related posts to display.
						    'caller_get_posts' => 1
					    );
					     
					    $related = new wp_query( $args );
					 	echo '<div class="cols">';
					    while( $related->have_posts() ) {
						    $related->the_post();
						    ?>
						    <div class="col4 recipe">
					    		<a href="<? the_permalink()?>" title="View recipe"><?php the_post_thumbnail($pageObj->ID, array(440,600)); ?></a>
					    		<div class="recipe-over"><a href="<? the_permalink()?>" title="View <?php the_title(); ?>"><?php the_title(); ?></a></div>
					    	</div>
					    <? }
				    echo '</div>';
				    }
				    wp_reset_query();
			    ?>

			</div>
		</section>

		<section class="col-right">
		<?php echo output_adverts($showAdverts); ?>
		</section>
	</div>

<?php get_footer(); ?> 