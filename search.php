<?php
/**
 *
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>

	<div id="main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?></h1>
		</header>

		<?php include("loop.php"); ?>

	<?php else : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'twentythirteen' ); ?></p>
			<?php get_search_form(); ?>
	<?php endif; ?>

	</div><!-- #content -->

<?php get_footer(); ?>
