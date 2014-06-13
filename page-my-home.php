<?php
/*
Template Name: My Home
*/

if ( !is_user_logged_in() ) {
	wp_redirect(wp_login_url());
	exit;
}else{
	global $current_user;
	global $woocommerce;
    get_currentuserinfo();
}


?>
<?php get_header(); ?>

	<?php while (have_posts()) : the_post(); ?>
	<div id="main" class="procces-home">
		<div id="content">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>	
	
	<?php include('sidebar-my-account.php');?>
</div>
<?php get_footer(); ?>