	<footer>
		<div class="footer-inner">
			<div class="body">

				<div class="newsletter">
					<h2>Sign up to our newsletter</h2>
					<?php echo apply_filters('the_content', '[contact-form-7 id="7286" title="Newsletter"]'); ?>
					<div class="clear"></div>
				</div>
				

				<div class="footer-info">
					Copyright &copy; Ed Halmagyi<br />
					Website by <a href="http://www.engagingcomms.com" title="View Engaging Communications website" target="_blank">Engaging Communications</a>
				</div>

				<div class="footer-section">
				<?php
	    			$nav = wp_get_nav_menu_items('footer-1');
	    			if(sizeof($nav) > 0) {
	    				echo '<ul class="list">';
	    				for($i=0; $i<sizeof($nav); $i++) {
	    					$navPage = get_field('_menu_item_object_id', $nav[$i]->ID);
	    					$navPage = get_post($navPage);
	    					echo '<li>';
	    					echo '<a href="'.get_permalink($navPage->ID).'" title="Go to '.$navPage->post_title.'">'.$navPage->post_title.'</a>';
	    					echo '</li>';
		    			}
	    				echo '</ul>';
		    		}
	    		?>
				</div>

				<div class="footer-section">
				<?php
	    			$nav = wp_get_nav_menu_items('footer-2');
	    			if(sizeof($nav) > 0) {
	    				echo '<ul class="list">';
	    				for($i=0; $i<sizeof($nav); $i++) {
	    					$navPage = get_field('_menu_item_object_id', $nav[$i]->ID);
	    					$navPage = get_post($navPage);
	    					echo '<li>';
	    					echo '<a href="'.get_permalink($navPage->ID).'" title="Go to '.$navPage->post_title.'">'.$navPage->post_title.'</a>';
	    					echo '</li>';
		    			}
	    				echo '</ul>';
		    		}
	    		?>
				</div>
			</div>
		</div>
	</footer>

	<script type="text/javascript" src="js/site-functions.js"></script>
	
    <?php wp_footer(); ?>

</body>
</html>