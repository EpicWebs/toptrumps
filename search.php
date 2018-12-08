<?php get_header(); ?>
	<section id="content">
		<?php if ( have_posts() ) : ?>
		<header class="header">
			<h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'basetheme' ), get_search_query() ); ?></h1>
		</header>
		<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<?php if ( is_singular() ) { echo '<h1 class="entry-title">'; } else { echo '<h2 class="entry-title">'; } ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a><?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?> <?php edit_post_link(); ?>
				<?php if ( !is_search() ) get_template_part( 'entry', 'meta' ); ?>
			</header>
			<section class="entry-summary">
				<?php the_excerpt(); ?>
				<?php if( is_search() ) { ?><div class="entry-links"><?php wp_link_pages(); ?></div><?php } ?>
			</section>
			<footer class="entry-footer">
				<span class="cat-links"><?php _e( 'Categories: ', 'basetheme' ); ?><?php the_category( ', ' ); ?></span>
				<span class="tag-links"><?php the_tags(); ?></span>
				<?php if ( comments_open() ) { 
				echo '<span class="meta-sep">|</span> <span class="comments-link"><a href="' . get_comments_link() . '">' . sprintf( __( 'Comments', 'basetheme' ) ) . '</a></span>';
				} ?>
			</footer> 
		</article>
		<?php endwhile; ?>
		<?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) { ?>
		<nav id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link(sprintf( __( '%s older', 'basetheme' ), '<span class="meta-nav">&larr;</span>' ) ) ?></div>
			<div class="nav-next"><?php previous_posts_link(sprintf( __( 'newer %s', 'basetheme' ), '<span class="meta-nav">&rarr;</span>' ) ) ?></div>
		</nav>
		<?php } ?>
		<?php else : ?>
		<article id="post-0" class="post no-results not-found">
			<header class="header">
				<h2 class="entry-title"><?php _e( 'Nothing Found', 'basetheme' ); ?></h2>
			</header>
			<section class="entry-content">
				<p><?php _e( 'Sorry, nothing matched your search. Please try again.', 'basetheme' ); ?></p>
				<?php get_search_form(); ?>
			</section>
		</article>
		<?php endif; ?>
	</section>
	<aside itemscope itemtype="http://schema.org/WPSideBar">
		<?php get_sidebar(); ?>
	</aside>
<?php get_footer(); ?>