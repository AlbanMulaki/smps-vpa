<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package zerif
 */

get_header(); ?>
<div class="clear"></div>
</header> <!-- / END HOME SECTION  -->

	<div id="content" class="site-content">
<div class="container">

<?php if (is_page('donacion') || is_page('pyetje') || is_page('pyetjet-list') || is_page('grupi') || is_page('rreth-nesh-2') || is_page('blog')|| is_page('java')  ) : ?>
<div class="content-left-wrap col-md-12">
<?php else : ?>
<div class="content-left-wrap col-md-9">
<?php endif; ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .content-left-wrap -->
<?php if (is_page('donacion') || is_page('pyetje')|| is_page('pyetjet-list') || is_page('grupi') || is_page('rreth-nesh-2') || is_page('blog')|| is_page('java')  ) : ?>
<?php else : ?>
<div class="sidebar-wrap col-md-3 content-left-wrap">
	<?php get_sidebar(); ?>
</div><!-- .sidebar-wrap -->

<?php endif; ?>
</div><!-- .container -->
<?php get_footer(); ?>
