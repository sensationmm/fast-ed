<?php
	if($pageObj->post_type == 'recipe')
		include 'single-recipe.php';
	else if($pageObj->post_type == 'book')
		include 'single-book.php';
	else
		include 'single-blog.php';
?>