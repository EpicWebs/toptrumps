<?php get_header(); ?>
<div class="row">
	<section id="content">
		<header class="header">
			<h1 class="entry-title"><?php _e( 'Tag Archives: ', 'basetheme' ); ?><?php single_tag_title(); ?></h1>
		</header>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<?php if ( is_singular() ) { echo '<h1 class="entry-title">'; } else { echo '<h2 class="entry-title">'; } ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a><?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?> <?php edit_post_link(); ?>
				<?php if ( !is_search() ) get_template_part( 'entry', 'meta' ); ?>
			</header>
			<section class="entry-summary">
				<?php the_excerpt(); ?>
			</section>
			<footer class="entry-footer">
				<span class="cat-links"><?php _e( 'Categories: ', 'basetheme' ); ?><?php the_category( ', ' ); ?></span>
				<span class="tag-links"><?php the_tags(); ?></span>
				<?php if ( comments_open() ) { 
				echo '<span class="meta-sep">|</span> <span class="comments-link"><a href="' . get_comments_link() . '">' . sprintf( __( 'Comments', 'basetheme' ) ) . '</a></span>';
				} ?>
			</footer> 
		</article>
		<?php endwhile; endif; ?>
		<?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) { ?>
		<nav id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link(sprintf( __( '%s older', 'basetheme' ), '<span class="meta-nav">&larr;</span>' ) ) ?></div>
			<div class="nav-next"><?php previous_posts_link(sprintf( __( 'newer %s', 'basetheme' ), '<span class="meta-nav">&rarr;</span>' ) ) ?></div>
		</nav>
		<?php } ?>
	</section>
	<aside itemscope itemtype="http://schema.org/WPSideBar">
		<?php get_sidebar(); ?>
	</aside>
</div>
<?php get_footer(); ?>