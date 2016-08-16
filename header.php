<?php
	global $headerInclude, $post, $pageObj, $tagObj;
	$pageObj = $post;
	$template = get_current_template();
	$template = substr($template, 0, stripos($template, '.'));


	if(!is_tag())
		$title = ($pageObj->ID != 6959) ? $pageObj->post_title.' :: Fast Ed' : $pageObj->post_title;
	else {
		$tagObj = get_tag(get_query_var('tag_id'));
		$title = ucwords($tagObj->name).' Recipes :: Fast Ed';
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php echo $title; ?></title>
<base href="http://www.fast-ed.com.au/wp-content/themes/fasted2015/" /><!--[if IE]></base><![endif]-->
<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald:700,400' rel='stylesheet' type='text/css'>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-7565120-17', 'auto');
    ga('send', 'pageview');
</script>
<?php echo $headerInclude; ?>
<?php wp_head(); ?>
</head>
<body id="<?php echo $template; ?>">
    
	<header>
    	<div class="body">
	    	<div class="logo"><a href="/" title="View Homepage"><img src="assets/images/fast-ed.png" /></a></div>
	    
	    	<nav>
    		<?php
    			$nav = wp_get_nav_menu_items('header');
    			if(sizeof($nav) > 0) {
                    echo '<div class="mobile-nav-close"></div>';

    				echo '<ul class="list">';
    				echo '<li>';
    				echo '<a ';
    					if($pageObj->ID == 6959)
    						echo 'class="active" ';
    					echo 'href="/" title="Go to Homepage">Home</a>';
    					echo '</li>';
    				for($i=0; $i<sizeof($nav); $i++) {
    					$navPage = get_field('_menu_item_object_id', $nav[$i]->ID);
    					$navPage = get_post($navPage);
    					echo '<li>';

    					echo '<a ';
    					if($pageObj->ID == $navPage->ID 
    						|| ($navPage->ID == 6961 && $pageObj->post_type == 'recipe')
    						|| ($navPage->ID == 6967 && $pageObj->post_type == 'post')
    						)
    						echo 'class="active" ';
    					echo 'href="'.get_permalink($navPage->ID).'" title="Go to '.$navPage->post_title.'">'.$navPage->post_title.'</a>';
    					echo '</li>';
	    			}
    				echo '</ul>';
	    		}
    		?>
	    	</nav>
            <div class="mobile-nav"><img src="assets/images/icon-nav.gif" /></div>
            <div class="mask"></div>

            <div class="social-links">
            <?php
                $urlFB = get_field('hp_facebook_url', 6959);
                $urlIG = get_field('hp_instagram_url', 6959);

                if($urlFB != '')
                    echo '<div class="social-link"><a href="'.$urlFB.'" target="_blank" title="View Fast Ed on Facebook"><img src="assets/images/icon-facebook.gif" /></a></div>';

                if($urlIG != '')
                    echo '<div class="social-link"><a href="'.$urlIG.'" target="_blank" title="View Fast Ed on Instagram"><img src="assets/images/icon-instagram.gif" /></a></div>';
            ?>
            </div>
		</div>
	</header>