<?php get_header(); ?>
<section id="content">
	<header class="header">
		<h1 class="entry-title"><?php single_cat_title(); ?></h1>
		<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
	</header>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php edit_post_link(); ?>
		<section class="entry-meta">
			<span class="author vcard"><?php the_author_posts_link(); ?></span>
			<span class="meta-sep"> | </span>
			<span class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
		</section>
		</header>
		<section class="entry-summary">
			<?php the_excerpt(); ?>
		</section> 
	</article>
	<?php endwhile; endif; ?>
</section>
<aside itemscope itemtype="http://schema.org/WPSideBar" class="col-sm-3">
	<?php get_sidebar(); ?>
</aside>
<?php get_footer(); ?>