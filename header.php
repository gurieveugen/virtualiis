<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?>!</title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); 
		wp_head(); ?>
	<script src="<?php echo TDU ?>/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo TDU ?>/js/jquery.main.js"></script>
	<script src="<?php echo TDU ?>/js/jquery.cycle2.min.js"></script>
	<script src="<?php echo TDU ?>/js/jquery.formstyler.js"></script>
	<script>
		(function($) {
		$(function() {
			$('input[type="radio"] ').styler();
		})
		})(jQuery)
	</script>
	<!--[if lt IE 9]>
		<script src="<?php echo TDU ?>/js/pie.js"></script>
		<script src="<?php echo TDU ?>/js/init-pie.js"></script>
		<script src="<?php echo TDU ?>/js/html5.js"></script>
	<![endif]-->
	<!--[if lte IE 9]>
		<script type="text/javascript" src="<?php echo TDU ?>/js/jquery.placeholder.js"></script>
		<script type="text/javascript">
			 $(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="header">
			<div class="center-wrap">
				<?php if(is_front_page()): ?>
					<h1 class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
				<?php else: ?>
					<strong class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></strong>
				<?php endif; ?>
				<div class="holder">
					<div class="top-row">
					<?php	if ( is_user_logged_in() ) { 
						global $current_user;
						get_currentuserinfo();
					?>
						<a href="<?php echo wp_logout_url(); ?>" class="login">Log Out</a>
						<strong class="welcome">Welcome <span><?php echo $current_user->display_name; ?></span></strong>
					<?php }else{ ?>
						<a href="<?php echo wp_login_url();?>" target="_blank" class="login">Account Login</a>
						<a href="https://twitter.com/Virtualiis" target="_blank" class="twitter">twitter</a>
						<a href="https://www.facebook.com/Virtualiis" target="_blank" class="facebook">facebook</a>
<a href="http://www.f6s.com/rebeccalee?follow=1" target="_blank" title="Follow Rebecca Lee on f6s"><img src="http://www.f6s.com/images/follow-red.png" border="0" width="72" height="20 " alt="Follow Rebecca Lee on f6s" style="width: 72px; height: 20px; padding: 5px 0px 0px 240px; margin: 0px;" /></a>
					<?php }?>
					</div>
					<?php	if ( !is_user_logged_in() ) { ?>
					<div class="link-register">
						<a href="<?php bloginfo('url');?>/account-sign-up/">Or register for an account</a>
					</div>
					<?php } ?>
					<?php 
					//$anc = get_post_ancestors( $post->ID );
					//if($post->ID == MY_ACCOUNT_PAGE_ID || in_array(MY_ACCOUNT_PAGE_ID, $anc) ){
					if ( is_user_logged_in() ) { ?>
					<nav id="nav">
						<ul>
							<li <?php if(is_page('my-marker')){ echo 'class="active"'; } ?>><a href="<?php bloginfo('url'); ?>/my-account/create-new-marker/">model management</a></li>
							<li <?php if(is_page('my-account')){ echo 'class="active"'; } ?>><a href="<?php bloginfo('url'); ?>/my-account/">My account</a></li>
						</ul> 
					</nav>
					<?php }else{
					wp_nav_menu( array(
					'container' => 'nav',
					'container_id' => 'nav',
					'theme_location' => 'primary_nav',
					)); 
					}?>
				</div>
			</div>
		</header>
