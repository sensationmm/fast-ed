<?php

	add_theme_support('menus');
	add_theme_support( 'post-thumbnails' );

	add_action( 'init', 'create_post_type');
	function create_post_type() {
		register_post_type( 'recipe',
			array('labels' => array( 'name' => __( 'Recipes' ), 'singular_name' => __( 'Recipe' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'taxonomies' => array('category','post_tag'),
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'event',
			array('labels' => array( 'name' => __( 'Events' ), 'singular_name' => __( 'Event' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title','editor','author','thumbnail'))
		);
		register_post_type( 'book',
			array('labels' => array( 'name' => __( 'Books' ), 'singular_name' => __( 'Book' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title','editor','author','thumbnail'))
		);
		register_post_type( 'advert',
			array('labels' => array( 'name' => __( 'Adverts' ), 'singular_name' => __( 'Advert' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title','editor','author','thumbnail'))
		);
	}

	add_filter( 'template_include', 'var_template_include', 1000 );
	function var_template_include( $t ){
	    $GLOBALS['current_theme_template'] = basename($t);
	    return $t;
	}

	/*
	* get current page template
	* $echo: (bool) echo or return value
	*/
	function get_current_template( $echo = false ) {
	    if( !isset( $GLOBALS['current_theme_template'] ) )
	        return 'false';
	    if( $echo )
	        echo $GLOBALS['current_theme_template'];
	    else
	        return $GLOBALS['current_theme_template'];
	}

	/*
	* build link for filters
	* $base: (string) page to redirect to, eg. recipes, blog
	* $type: (string) filter to set, eg. category, search
	* $val: (string) value of filter to set
	*/
	function filter_link($base, $type, $val) {

		$currentFilters = $_GET;
		$currentFilters[$type] = $val;
		
		unset($currentFilters['filter']);

		if($val == 'all') {
			unset($currentFilters[$type]);

			if($type == "search")
				unset($currentFilters['orderby']);
		}

		$currentFiltersKeys = array_keys($currentFilters);

		$link = $base;
		if(sizeof($currentFilters) > 0) {
			$link .= '?filter=true';
			for($i=0; $i<sizeof($currentFilters); $i++)
				$link .= '&'.$currentFiltersKeys[$i].'='.$currentFilters[$currentFiltersKeys[$i]];
		}
		$link .= '#body';

		return $link;
	}

	/*
	* output filter listings for blog/recipes pages
	*/
	function output_filter($page, $postType, $url) {

		$filters = '<div class="search-recipes">';
		$filters .= '<div class="grey-box-header">Search '.$postType.'s</div>';

		$filtersMobile = '<form class="mobile-filter" name="filterlistMobile" method="get" action="">';
		$filtersMobile .= '<input type="hidden" name="filter" value="true" />';
		$filtersMobile .= '<select name="category" onchange="document.filterlistMobile.submit();">';
		$filtersMobile .= '<optgroup>';
		$filtersMobile .= '<option value="0">All</option>';
		
		$searchTerms = (isset($_GET["search"])) ? $_GET["search"] : 'Enter search';
			
		$filters .= '<form method="get" action="'.$url.'">';
		$filters .= '<input type="hidden" name="filter" value="true" />';
		$filters .= '<input name="search" type="text" value="'.$searchTerms.'" onclick="this.select();" onfocus="this.select();" />';
		$filters .= '<div class="label-header">Order by:</div>';
		$filters .= '<input type="radio" name="orderby" value="date" id="sort-date" checked="checked" />';
		$filters .= '<label for="sort-date">Date</label>';
		$filters .= '<input type="radio" name="orderby" value="name" id="sort-title" '.(($_GET["orderby"] == 'name') ? 'checked="checked" ' : '').' />';
		$filters .= '<label for="sort-title">Title</label>';

		if(isset($_GET["category"]))
			$filters .= '<input type="hidden" name="category" value="'.$_GET["category"].'" />';

		$filters .= '<div class="button red"><input type="submit" value="Find a';
		if(in_array(substr($postType, 0, 1), array('a','e','i','o','u')))
			$filters .= 'n';
		$filters .= ' '.$postType.'" /></div>';

		if(isset($_GET["search"]))
			$filters .= '<div class="search-reset"><a href="'.$url.'" title="Reset search values">Reset</a></div>';

		$filters .= '</form>';
		$filters .= '</div>';

		$filters .= '<div class="filter-list">';
		$filters .= '<div class="grey-box-header">Categories</div>';
		$filters .= '<ul class="filter">';
		$filters .= '<li'.(($_GET["category"] == '') ? ' class="active"' : '').'>';
		$filters .= '<a href="'.filter_link($page,'category','all').'" title="View all '.$postType.'s">All</a>';
		$filters .= '</li>';

		$filterTermsArray = array('fields' => 'id=>name',
								  'hide_empty' => true);
		//page spcific criteria
		switch($postType) {
			case 'recipe':
				$filterTermsArray['parent'] = 5;
				$filterTermsArray['child_of'] = 5;
				break;
			case 'article':
				$filterTermsArray['parent'] = 0;
				$filterTermsArray['child_of'] = 0;
				$filterTermsArray['exclude'] = array(5,1,743);
				break;
												   
		}

		$filterTerms = get_terms('category', $filterTermsArray);

		$filterTermsIDs = array_keys($filterTerms);

		for($ft=0; $ft<sizeof($filterTerms); $ft++) {

			$termID = $filterTermsIDs[$ft];
			$termName = $filterTerms[$filterTermsIDs[$ft]];

			$filterTermsSub = get_terms('category', array('parent' => $termID, 
														  'fields' => 'id=>name',
														  'hide_empty' => true));
			$filterTermsSubIDs = array_keys($filterTermsSub);

			//term has children
			$nested = (sizeof($filterTermsSub) > 0) ? 'nested' : '';
			//if current term or child term active
			$active = (in_array($_GET["category"], array_merge(array($termID), $filterTermsSubIDs))) ? 'active' : '';

			$filters .= '<li'.(($nested.$active != '') ? ' class="'.$nested.' '.$active.'"' : '').'>';

			$filters .= '<a href="'.filter_link($page,'category',$termID).'" title="View '.$termName.' '.$postType.'s">'.$termName.'</a>';

			$filtersMobile .= '<option value="'.$termID.'"';
			if($active == 'active')
				$filtersMobile .= ' selected="selected"';
			$filtersMobile .= '>'.$termName.'</option>';

			if(sizeof($filterTermsSub) > 0) {
				$filters .= '<ul>';
				for($fts=0; $fts<sizeof($filterTermsSub); $fts++) {

				$subTermID = $filterTermsSubIDs[$fts];
				$subTermName = $filterTermsSub[$filterTermsSubIDs[$fts]];
				
				$active = ($_GET["category"] == $subTermID) ? 'active' : '';

					$filters .= '<li'.(($active != '') ? ' class="'.$active.'"' : '').'>';
					$filters .= '<a href="'.filter_link($page,'category',$subTermID).'" title="View '.$subTermName.' '.$postType.'s">'.$subTermName.'</a>';
					$filters .= '</li>';

					$filtersMobile .= '<option value="'.$subTermID.'"';
					if($active == 'active')
						$filtersMobile .= ' selected="selected"';
					$filtersMobile .= '> -- '.$subTermName.'</option>';
				}
				$filters .= '</ul>';
			}
			$filters .= '</li>';
		}
		$filters .= '</ul>';

		if(isset($_GET["search"])) {
			$filtersMobile .= '<input type="hidden" name="search" value="'.$_GET["search"].'" />';
			$filtersMobile .= '<input type="hidden" name="orderby" value="'.$_GET["orderby"].'" />';
		}
		$filtersMobile .= '</optgroup>';
		$filtersMobile .= '</select>';
		$filtersMobile .= '</form>';

		$filters .= $filtersMobile;
		$filters .= '</div>';

		return $filters;
	}

	/*
	* output adverts
	* $num: (int) the number of adverts to display
	*/
	function output_adverts($num) {
		$output = '';

		$listings = array('post_type' => 'advert',
					  'orderby' => 'rand',
					  'posts_per_page' => $num);

		$ads = new WP_Query($listings);

		if ($ads->have_posts() ) : 

			while ( $ads->have_posts() ) : $ads->the_post();
				$img = get_field('advert_image', get_the_ID());
				$alt = get_field('advert_alt_text', get_the_ID());
				$link = get_field('advert_link', get_the_ID());
				$output .= '<div class="advert">';
				if($link != '')
					$output .= '<a href="'.$link.'" target="_blank" title="'.$alt.'">';
				$output .= '<img src="'.$img.'" alt="'.$alt.'" />';
				if($link != '')
					$output .= '</a>';
				$output .= '</div>';
			endwhile;
		endif;

		return $output;
	}

	/*
	* output page banner
	* $src: (int) id of page to display banner of
	*/
	function output_banner($src) {
		$banner = get_field('page_banner', $src);

		$banner = '<div class="banner"><div class="banner-inner"><img src="'.$banner.'" /></div></div>';

		return $banner;
	}

?>