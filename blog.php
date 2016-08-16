<?php
/**
 * @package WordPress
 * @subpackage Fast Ed 2015
 * Template Name: Blog
*/
get_header();  
$pageType = $_SERVER["REQUEST_URI"];
if(strpos($pageType, '?') !== false)
	$pageType = substr($pageType, 0, strpos($pageType, '?'));
?>

	<?php echo output_banner($pageObj->ID); ?>
	
	<div class="body">
		<a name="body"></a>
		<article class="header">
		<?php
			if(!is_tag())
				echo '<h1>'.$pageObj->post_title.'</h1>';
			else { 
				echo '<h1>'.$tagObj->name.' Articles</h1>';
			}
			echo apply_filters('the_content', $pageObj->post_content);
	    ?>
		</article>

		<section class="col-left">
		<?php
			echo output_filter($pageType, 'article', filter_link($pageType,'search','all'));

			echo output_adverts(1); 
		?>
		</section>

		<section class="col-main last">
		<?php
			/******************************************************************************************************************/
			//build products query
			/******************************************************************************************************************/
			if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
			elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
			else { $paged = 1; }

			$posts_per_page = 10;
			
			$listings = array('post_type' => 'post',
								'posts_per_page' => $posts_per_page,
								'paged' => $paged);

			if(isset($_GET["category"]))
				$listings['cat'] = $_GET["category"];

			if(isset($_GET["search"]) && $_GET["search"] != 'Enter search')
				$listings['s'] = $_GET["search"];

			if(isset($_GET["orderby"])) {
				switch($_GET["orderby"]) {
					case 'name': 
						$listings["orderby"] = 'post_title'; 
						$listings["order"] = 'asc'; 
						break;
					case 'date': 
					default: 
						$listings["orderby"] = 'post_date'; 
						$listings["order"] = 'desc'; 
						break;
				}
			}

			if(is_tag())
				$listings["tag"] = $tagObj->slug;
			
			remove_all_filters('posts_orderby');//prevent plugin clashing with custom ordering
			$results = new WP_Query($listings);

 			$totalNumResults = ceil(($results->found_posts));

 			//show number of results
			$resultsText = 'Showing ';
			if($totalNumResults > 0) {
				$resultsText .= $posts_per_page * $paged - $posts_per_page + 1;
				$resultsText .= '-';
				$resultsText .= $posts_per_page * $paged - ($posts_per_page - $results->post_count);
				$resultsText .= ' of ';
			}
			$resultsText .= $totalNumResults.' results';
			if(isset($_GET["filter"]) && $_GET["filter"] == true)
				$resultsText .= '<div class="results-filtered">Filtered</div>';

			echo '<div class="num-results">'.$resultsText.'</div>';

 			if ($results->have_posts() ) : 

				while ( $results->have_posts() ) : $results->the_post();
					$ID = get_the_ID();
					$title = get_the_title();
					$excerpt = get_the_excerpt();
					echo '<div class="article-listing">';
					echo '<div class="article-image">';
					echo '<a href="'.get_permalink($ID).'" title="View '.$title.'">';
					$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'large');
					if($featuredImage != '')
						echo get_the_post_thumbnail($ID, array(100,'auto'));
					else
						echo '<img src="assets/images/awaiting-image.jpg" />';

			    	echo '</a>';
					echo '</div>';
					echo '<div class="article-info">';
					echo '<div class="article-title"><h2>';
					echo '<a href="'.get_permalink($ID).'" title="View '.$title.'">';
					echo $title.'</a></h2></div>';
					echo '<div class="article-date">'.date('d/m/y', strtotime($post->post_date)).'</div>';
					echo '<p>'.$excerpt.'</p>';
					echo '<a href="'.get_permalink($ID).'" title="View '.$title.'">Read more &gt;</a>';
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
			echo '<div class="num-results">'.$resultsText.'</div>';
		?>

			<div class="pagination">
			<?php
				$big = 999999999; // need an unlikely integer

				$pagination = paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'current' => $paged,
					'total' => $results->max_num_pages,
					'prev_text' => __('&lt;'),
					'next_text' => __('&gt;'),
				) );

				echo '<div class="pagination-links">'.$pagination.'</div>';
			?>
			</div>
		</section>
	</div>

<?php get_footer(); ?> 