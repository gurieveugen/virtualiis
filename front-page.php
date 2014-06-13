<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>

<?php get_header(); ?>
<section class="visual">
	<div class="center-wrap">
		<div class="overlay"></div>
		<?php $slides = get_field('slide');
		if($slides){ ?>
		<div class="cycle-slideshow slider" data-cycle-fx=scrollHorz data-cycle-slides="> div.slide" data-cycle-speed=1200 data-cycle-timeout=4000 >	
			<div class="cycle-pager"></div>		
		<?php foreach($slides as $slide){?>	
			<div class="slide">
				<img src="<?php echo $slide['image'];?>" alt="">
				<div class="text" style="display:none">
					<p><?php echo $slide['text'];?></p>
				</div>			
			</div>
		<?php }?>		
		</div>
		<div class="slider-text">
			<div class="text">
				<p><?php echo $slides[0]['text'];?></p>
			</div>			
		</div>
		<script>
			jQuery(document).ready(function() {  		
				jQuery( '.cycle-slideshow' ).on( 'cycle-after', function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag){
				var slide_text = jQuery(incomingSlideEl).find(".text").html();
				jQuery(".slider-text .text").html(slide_text);
				});		
			});
		</script>
		<?php } ?>		
	</div>
</section>
<div class="visual-row center-wrap">
	<div class="visual-right">
		<div class="signup-block">
			<label><strong>Newsletter</strong> Signup</label>
			<div class="signup-form">
				<form action="http://virtualiis.us7.list-manage.com/subscribe/post?u=53cbbf2a23c37ebf73d6a47a8&amp;id=2c9b2d62ae" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<input type="text" name="EMAIL" id="mce-EMAIL" placeholder="enter email" required>
				<input type="submit">
				</form>
			</div>
			<small>Be the first to use and know about Virtualiis</small>
		</div>
		<div class="download-block">
			<a href="https://itunes.apple.com/au/app/virtualiis-augmented-reality/id599567663?mt=8" target="_blank">
				<img src="<?php echo TDU; ?>/images/img-download.png" alt="image description">
				<div class="holder">
					<h3><strong>Download</strong> App</h3>
					<small>start using Virtualiis today</small>
				</div>
			</a>
		</div>
	</div>
</div>
<?php while (have_posts()) : the_post(); ?>
<section class="home-content">
	<div class="center-wrap">
		<?php the_content(); ?>
		<?php /*
		<img src="<?php echo TDU; ?>/images/img-2.png" alt="image description">
		<div class="three-columns">
			<div class="column">
				<span class="circle">1</span>
				<div class="holder">
					<p><strong>Upload</strong> Model to Virtualiis.com and <strong>Download</strong> marker</p>
				</div>
			</div>
			<div class="column">
				<span class="circle">2</span>
				<div class="holder">
					<p><strong>Download</strong> Virtualiis, open and point the camera view to the marker.</p>
				</div>
			</div>
			<div class="column">
				<span class="circle">3</span>
				<div class="holder">
					<p><strong>Print</strong> markers anywhere for users to view your models </p>
				</div>
			</div>
		</div>
		<div class="create-box">
			<div class="hgroup">
				<h2>Sign up now</h2> 
				<h4>for $0 set up fee</h4>
			</div>
			<ul class="create-list">
				<li>Create your account</li>
				<li>Upload your models to Virtualiis</li>
				<li>Allow everyone &amp; anyone to view</li>
			</ul>
			<a href="/account-sign-up/" class="create-link">CREATE YOUR <strong>ACCOUNT</strong></a>
		</div> */ ?>
	</div>
</section>
<?php endwhile; ?>
<?php get_footer(); ?>