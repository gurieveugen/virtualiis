<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>

<?php if ( have_posts() ) : ?>

<div class="panel-boxes">
<?php while ( have_posts() ) : the_post(); ?>

		<div class="box" id="post-<?php the_ID(); ?>">
			<?php 
				$post_thumbnail_id = get_post_thumbnail_id(); 
				if(!empty($post_thumbnail_id)){?>
				<img src="<?php echo get_thumb($post_thumbnail_id, 314, 128, true); ?>" alt="<?php the_title(); ?>">
			<?php	}?>
				<div class="holder">
					<span><?php the_title(); ?></span>
					<a href="<?php the_permalink()?>" class="see-more-link">SEE MORE</a>
				</div>
		</div>

<?php endwhile; ?>
</div> <!-- .post-holder -->
	
<?php theme_paging_nav(); ?>

<?php else: ?>
	
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'theme' ); ?></h1>
	</header>
	
	<div class="page-content">

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'theme' ); ?></p>
		<?php get_search_form(); ?>

	</div><!-- .page-content -->
	
<?php endif; ?>