<?php
    $post_id        = get_queried_object_id();
    $post_type      = get_post_type($post_id);
    $post_template  = str_replace(".php", "", get_page_template_slug($post_id));
    
    define("POST_TYPE", $post_type);
    define("POST_TEMPLATE", $post_template);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie ie6 lte9 lte8 lte7" <?php language_attributes(); ?>> <![endif]--><?php echo PHP_EOL; ?>
<!--[if IE 7]>    <html class="no-js ie ie7 lte9 lte8 lte7" <?php language_attributes(); ?>> <![endif]--><?php echo PHP_EOL; ?>
<!--[if IE 8]>    <html class="no-js ie ie8 lte9 lte8" <?php language_attributes(); ?>> <![endif]--><?php echo PHP_EOL; ?>
<!--[if IE 9]>    <html class="no-js ie ie9 lte9" <?php language_attributes(); ?>> <![endif]--><?php echo PHP_EOL; ?>
<!--[if gt IE 9]> <html class="no-js" <?php language_attributes(); ?>> <![endif]--><?php echo PHP_EOL; ?>
<!--[if !IE]><!--><html class="no-js" <?php language_attributes(); ?>>  <!--<![endif]--><?php echo PHP_EOL; ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo get_bloginfo('site_title'); ?></title>
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC" rel="stylesheet">
<?php wp_head(); ?>
<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> - Feed" href="<?php bloginfo('rss2_url'); ?>" />
</head>
<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
	<div class="wrapper hfeed">
		<header class="site-header" itemscope itemtype="http://schema.org/WPHeader">
			<h1>D&amp;D Top Trumps!</h1>
		</header>
		<div class="main-container">