<?php
/**
 *
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
<div class="image-block">
	<div class="center-wrap">
		<img src="<?php echo TDU ?>/images/img-4.jpg" alt="image description">
		<div class="overlay"></div>
	</div>
</div>
<div id="main">
	<div class="entry-content">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div>
</div>
<?php endwhile; ?>
<div class="bottom-three-columns">
	<div class="center-wrap">
		<div class="column">
			<h2><strong>Showcase</strong> examples</h2>
			<p>See how others are using Virtualiis</p>
			<?php 
			$posts_query = new WP_Query(array('post_type'=>'post', 'posts_per_page'=>2));
			if ( $posts_query->have_posts() ) {
				while ( $posts_query->have_posts() ) {  $posts_query->the_post(); ?>
			<div class="block">
				<h4><?php the_title();?></h4>
				<span class="row-by">by <a href="<?php echo get_author_posts_url($posts_query->post->post_author); ?>" class="author-link"><?php the_author(); ?></a> on <a href="#" class="date-link"><?php the_time('d.m.Y'); ?></a></span>
				<?php //the_excerpt();?>
				<?php
				global $more;
				$more = 0; 
				the_content('');
				/*
				$cont = get_the_excerpt(); 
				if (!$cont) $cont = short_content(get_the_content(), 30, ''); 
				echo $cont;	
				*/	
				?>				
				<a href="<?php the_permalink();?>" class="more-link">View More</a>
			</div>
			<?php } } wp_reset_postdata(); ?>	
		</div>
		<div class="column">
			<h2><strong>Twitter</strong> Feed </h2>
			<div class="cf">
				<a href="https://twitter.com/Virtualiis" target="_blank" class="twitter">twitter</a>
				<p>Follow our twitter feed</p>
			</div>
			<?php /* 
			<div class="messages-block">
				<div class="block">
					<span class="time">about 9 hours ago</span>
					<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra - <a href="#">http://bit.ly/2mgfuD</a></p>
				</div>
				<div class="block">
					<span class="time">about 9 hours ago</span>
					<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra - <a href="#">http://bit.ly/2mgfuD</a></p>
				</div>
				<div class="block">
					<span class="time">about 9 hours ago</span>
					<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra - <a href="#">http://bit.ly/2mgfuD</a></p>
				</div>
			</div> */ ?>
			<?php
				$args = array(
					'before_widget' => '<div class="messages-block">',
					'after_widget' => '</div>',
					'before_title' => '',
					'after_title' => '',
				);
				xmt($args, 'Primary');
			?>
		</div>
		<div class="column">
			<h2><strong>Connect</strong> with us</h2>
			<p>Let us know how you would like to use Virtualiis</p>
			<?php echo do_shortcode('[contact-form-7 id="42" title="Contact form"]');?>
			<script>
			jQuery(document).ready(function() {
				jQuery("#your-name").attr("placeholder", "Your Name...");
				jQuery("#your-email").attr("placeholder", "Your Email...");
				jQuery("#your-message").attr("placeholder", "Your Message...");
			});
			</script>
			<?php /*
			<form action="#" class="contact-form">
				<input type="text" placeholder="Your Name...">
				<input type="email" placeholder="Your Email...">
				<textarea placeholder="Your Message..."></textarea>
				<div class="bottom-row">
					<span class="required">* All fields are required</span>
					<input type="submit" value="Send">
				</div>
			</form>
			*/ ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
