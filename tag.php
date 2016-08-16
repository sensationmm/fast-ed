<?php 
	$referer = $_SERVER["HTTP_REFERER"];
	$referer = substr($referer, 0, -1);
	$referer = substr($referer, strrpos($referer, '/')+1);

	$referrerType = get_page_by_path('/'.$referer.'/', OBJECT, array('post','recipe'));
	$referrerType = $referrerType->post_type;

//echo '<pre>'; print_r($referer);echo '</pre>';
//echo '<pre>'; print_r($referrerType);echo '</pre>';

switch($referrerType) {
	case 'post':
		$post = get_post(6967);
		include 'blog.php'; 
		break;
	case 'recipe':
		$post = get_post(6961);
		include 'recipes.php'; 
		break;
}

?>