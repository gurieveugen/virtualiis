<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
	<footer id="footer">
		<div class="center-wrap">
			<div class="foter-area">
				<p class="copy">Copyright 2014: Virtualiis Pty Ltd</p>
				<div class="links-block">
					<a href="https://itunes.apple.com/au/app/virtualiis-augmented-reality/id599567663?mt=8"><img src="<?php echo TDU ?>/images/img-App-Store.png" alt="image description"></a>
					<a href="https://play.google.com/store/apps/details?id=com.virtualiis.app"><img src="<?php echo TDU ?>/images/img-3.png" alt="image description"></a>
				</div>
			</div>
			<div class="right-nav">
				<?php wp_nav_menu( array(
					'container' => false,
					'menu' => 'Footer Menu 1',
					)); 
				?>	
				<?php wp_nav_menu( array(
					'container' => false,
					'menu' => 'Footer Menu 2',
					)); 
				?>	
				<?php wp_nav_menu( array(
					'container' => false,
					'menu' => 'Footer Menu 3',
					)); 
				?>					
			</div>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>