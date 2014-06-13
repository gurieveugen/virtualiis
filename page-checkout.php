<?php
/*
Template Name: Checkout Page
*/
?>
<?php get_header(); ?>
<div id="main" class="account-page">
	
	<?php while (have_posts()){ the_post(); ?>
	<div id="content">
		<?php the_content(); ?>
	</div>
	<?php } ?>
	
	
	<?php include('sidebar-my-account.php');?>
	
</div>
<?php get_footer(); ?>