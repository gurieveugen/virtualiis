<?php
/*
Template Name: Page fo user
*/

?>
<?php get_header(); ?>

	<?php while (have_posts()) : the_post(); ?>
	<div id="main" class="for-user">
		<div id="content">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>	
	
	<?php include('sidebar-my-account.php');?>
</div>
<?php get_footer(); ?>