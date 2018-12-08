<?php get_header(); ?>
	<sectionid="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="header">
				<h1 itemprop="name" class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
			</header>
			<section class="entry-content">
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium',array('itemprop' => 'image')); } ?>
					<?php the_content(); ?>
			</section>
		</article>
		<?php endwhile; endif; ?>
	</section>
	<aside itemscope itemtype="http://schema.org/WPSideBar">
		<?php get_sidebar(); ?>
	</aside>
<?php get_footer(); ?>