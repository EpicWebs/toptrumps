<?php get_header(); ?>
<section id="content">
	<header class="header">
		<h1 class="entry-title"><?php 
		if ( is_day() ) { printf( __( 'Daily Archives: %s', 'basetheme' ), get_the_time( get_option( 'date_format' ) ) ); }
		elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'basetheme' ), get_the_time( 'F Y' ) ); }
		elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'basetheme' ), get_the_time( 'Y' ) ); }
		else { _e( 'Archives', 'basetheme' ); }
		?></h1>
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
	<?php endwhile; endif; ?>
	<?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) { ?>
	<nav id="nav-below" class="navigation">
		<div class="nav-previous"><?php next_posts_link(sprintf( __( '%s older', 'basetheme' ), '<span class="meta-nav">&larr;</span>' ) ) ?></div>
		<div class="nav-next"><?php previous_posts_link(sprintf( __( 'newer %s', 'basetheme' ), '<span class="meta-nav">&rarr;</span>' ) ) ?></div>
	</nav>
	<?php } ?>
</section>
<aside itemscope itemtype="http://schema.org/WPSideBar" class="col-sm-3">
	<?php get_sidebar(); ?>
</aside>
<?php get_footer(); ?>