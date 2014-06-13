<?php
/**
 *
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>
<?php global $post; ?>
<div id="main">
	<?php
		if (is_category() && category_description()){ ?>
		<div class="entry-content"><?php echo category_description(); ?></div>
	<?php }elseif(is_tag() && tag_description()){ ?>
		<div class="entry-content"><?php echo tag_description(); ?></div>
	<?php } ?>

	<h2 class="heading">

	<?php
		if (is_category()):
			printf( __( '%s', 'theme' ), single_cat_title( '', false ) );
		elseif( is_tag() ):
			printf( __( 'Tag Archives: %s', 'theme' ), single_tag_title( '', false ) );
		elseif ( is_day() ) :
			printf( __( 'Daily Archives: %s', 'theme' ), get_the_date() );
		elseif ( is_month() ) :
			printf( __( 'Monthly Archives: %s', 'theme' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'theme' ) ) );
		elseif ( is_year() ) :
			printf( __( 'Yearly Archives: %s', 'theme' ), get_the_date( _x( 'Y', 'yearly archives date format', 'theme' ) ) );
		elseif (is_author()):
			printf( __( 'All posts by %s', 'theme' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		else :
			_e( 'Archives', 'theme' );
		endif;
		?>
	</h2>
	<?php include("loop.php"); ?>
</div>

<?php get_footer(); ?>
