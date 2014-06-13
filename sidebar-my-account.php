	<div id="sidebar">
		<nav class="left-nav">
			<ul>
				<li class="home <?php if(is_page('my-home')){ echo 'active'; } ?>"><a href="<?php bloginfo('url'); ?>/my-account/my-home/">Home</a></li>
				<li class="new-marker <?php if(is_page('create-new-marker')){ echo 'active'; } ?>"><a href="<?php bloginfo('url'); ?>/my-account/create-new-marker/ ">Create New Marker</a></li>
				<?php
				$my_markers = get_my_markers();
				if ( $my_markers->have_posts() ) {
				$c = 1;
				?>
				<li class="my-markers has-dropdown <?php if(is_page('my-marker')){ echo 'active'; } ?>"><a href="#" class="mm">My Markers</a>
					<ul <?php if(!is_page('my-marker')){ echo 'style="display:none";';}?> id="markers_list">
					<?php while ( $my_markers->have_posts() ) {  $my_markers->the_post();?>
					<?php $marker_status = get_post_meta(get_the_ID(), 'marker_status', true);
							if(!empty($marker_status)){ $marker_status = '&nbsp<small title="marker status">('.$marker_status.')</small>';}
					?>
						<li <?php if(is_page('my-marker') && $marker_id == get_the_ID()){ echo 'class="active"'; } ?>><a href="<?php bloginfo('url'); ?>/my-account/my-marker/<?php echo get_the_ID(); ?>"><span class="num"><?php echo sprintf('%02d', $c);?></span> <?php the_title(); ?><?php echo $marker_status;?></a></li>
					<?php $c++; }?>	
					</ul>
				</li>
				<?php } ?>	
			</ul>
			<?php 
				wp_nav_menu( array(
					'container' => 'nav',
					'container_class' => 'left-nav',
					'menu' => 'User Menu',
					)); 
			?>			
		</nav>
	</div>
	<script type="text/javascript">
	jQuery(window).load(function(){
		jQuery("li.my-markers a.mm").click(function(){
			jQuery("#markers_list").slideToggle();
			return false;
		});
	});
	</script>