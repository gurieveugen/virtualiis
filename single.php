<?php
/**
 *
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>

<div class="image-block">
	<div class="center-wrap">
		<img src="<?php echo TDU ?>/images/img-4.jpg" alt="image description">
		<div class="overlay"></div>
	</div>
</div>
<div id="main">
<?php while ( have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div>
	</div>

<?php endwhile; ?>

</div>

<?php get_footer(); ?>
