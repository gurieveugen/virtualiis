<?php
/**
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
	<div id="main" role="main">
		<div class="entry-content">
			<p style="font-size: 21px;">Virtualiis is the ultimate smartphone and tablet application for engaging your customers with your building designs. Bringing 3d models and designs from the Augmented Reality virtual world of our application, into the real world of your office, home or street.</p>
			<p>Virtualiis is the ultimate smartphone and tablet application for engaging your customers with your building designs. Bringing 3d models and designs from the Augmented Reality virtual world of our application, into the real world of your office, home or street. Virtualiis is the ultimate smartphone and tablet </p>
			<p>Create sales process, for admin system, what the user gets etc.</p>
		</div>
		<?php /*  while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
				</div>
			</div>
		<?php endwhile; */ ?>
		
		
		
		<?php if(have_posts()){?>
		<h2 class="heading">Heading to panel</h2>
		<div class="panel-boxes">
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="box">
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
			
		</div>
		<?php } ?>

		<?php //include("loop.php"); ?>
	</div>
<?php get_footer(); ?>
