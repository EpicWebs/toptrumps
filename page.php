<?php get_header(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<h1><?php the_title(); ?></h1>
	<div class="content" itemprop="text">
		<?php the_content(); ?>
	</div>
	<?php endwhile; endif; ?>
</article>
<?php get_footer(); ?>